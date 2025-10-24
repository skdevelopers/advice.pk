<?php
/**
 * Eventbrite Webhook receiver (POST).
 * - Verifies optional shared secret (?t=...).
 * - Logs each delivery to webhooks.csv (append-only).
 * - If api_url looks real, fetches with organizer server token and writes
 *   normalized rows to attendees.csv / orders.csv.
 * - Always responds 200 text/plain, never 500 due to CSV/IO.
 */

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Services\EventbriteClient;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class EventbriteWebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        // 1) Optional shared-secret guard (?t=YOUR_SECRET)
        $expected = (string) config('eventbrite.webhook_secret', '');
        if ($expected !== '' && $request->query('t') !== $expected) {
            return response('forbidden', 403)->header('Content-Type', 'text/plain');
        }

        // 2) Extract basics
        $deliveryId = (string) $request->header('X-Eventbrite-Delivery', Str::uuid()->toString());
        $payload    = $request->json()->all();
        $apiUrl     = (string) Arr::get($payload, 'api_url', '');
        $action     = (string) Arr::get($payload, 'config.action', 'unknown');

        Log::info('Eventbrite webhook received', compact('deliveryId','action','apiUrl'));

        // 3) Append webhook receipt (non-fatal)
        $this->csvSafeAppend('webhooks.csv',
            ['received_at','delivery_id','action','api_url'],
            [now()->toDateTimeString(), $deliveryId, $action, $apiUrl]
        );

        // 4) If api_url is real, fetch & normalize (non-fatal)
        if ($apiUrl && ! str_contains($apiUrl, '{api-endpoint-to-fetch-object-details}')) {
            try {
                $client   = new EventbriteClient(); // uses organizer server token
                $resource = $client->get($apiUrl);

                $type = $this->detectType($apiUrl, $resource);

                if ($type === 'attendee') {
                    $row = $this->mapAttendeeRow($resource);
                    $this->csvSafeAppend('attendees.csv', array_keys($row), array_values($row));
                } elseif ($type === 'order') {
                    $row = $this->mapOrderRow($resource);
                    $this->csvSafeAppend('orders.csv', array_keys($row), array_values($row));
                } else {
                    $this->csvSafeAppend('errors.csv',
                        ['time','delivery_id','reason','api_url'],
                        [now()->toDateTimeString(), $deliveryId, 'unknown_type', $apiUrl]
                    );
                }
            } catch (\Throwable $e) {
                $this->csvSafeAppend('errors.csv',
                    ['time','delivery_id','reason','api_url'],
                    [now()->toDateTimeString(), $deliveryId, substr($e->getMessage(), 0, 500), $apiUrl]
                );
            }
        }

        // 5) Acknowledge quickly with text/plain
        return response('ok', 200)->header('Content-Type', 'text/plain');
    }

    /** Heuristic: attendee vs order */
    private function detectType(string $apiUrl, array $resource): string
    {
        $u = strtolower($apiUrl);
        if (str_contains($u, '/attendees/')) return 'attendee';
        if (str_contains($u, '/orders/'))    return 'order';

        if (Arr::has($resource, 'profile.email') || Arr::has($resource, 'profile.name')) return 'attendee';
        if (Arr::has($resource, 'email') && Arr::has($resource, 'event_id')) return 'order';

        return 'unknown';
    }

    /** Normalize an attendee JSON into a flat row */
    private function mapAttendeeRow(array $a): array
    {
        $answers = Arr::get($a, 'answers', []);
        return [
            'fetched_at'   => now()->toDateTimeString(),
            'attendee_id'  => (string) Arr::get($a, 'id'),
            'order_id'     => (string) Arr::get($a, 'order_id'),
            'event_id'     => (string) Arr::get($a, 'event_id'),
            'status'       => (string) Arr::get($a, 'status'),
            'email'        => (string) (Arr::get($a, 'profile.email') ?: Arr::get($a, 'profile.email_address')),
            'name'         => (string) (Arr::get($a, 'profile.name') ?: trim((Arr::get($a, 'profile.first_name', '').' '.Arr::get($a, 'profile.last_name', '')))),
            'ticket_class' => (string) Arr::get($a, 'ticket_class_name'),
            'answers_json' => json_encode(is_array($answers) ? $answers : []),
            'created'      => (string) Arr::get($a, 'created'),
            'changed'      => (string) Arr::get($a, 'changed'),
        ];
    }

    /** Normalize an order JSON into a flat row */
    private function mapOrderRow(array $o): array
    {
        return [
            'fetched_at' => now()->toDateTimeString(),
            'order_id'   => (string) Arr::get($o, 'id'),
            'event_id'   => (string) Arr::get($o, 'event_id'),
            'email'      => (string) Arr::get($o, 'email'),
            'name'       => (string) Arr::get($o, 'name'),
            'status'     => (string) Arr::get($o, 'status'),
            'quantity'   => (string) Arr::get($o, 'quantity'),
            'created'    => (string) Arr::get($o, 'created'),
            'changed'    => (string) Arr::get($o, 'changed'),
        ];
    }

    /**
     * Append-only CSV helper using Storage. Creates folder/file if missing.
     * Never throws—logs warning instead.
     */
    private function csvSafeAppend(string $filename, array $headers, array $row): void
    {
        try {
            $disk = Storage::disk('local');   // storage/app
            $dir  = 'eventbrite';
            $path = $dir . '/' . ltrim($filename, '/');

            if (!$disk->exists($dir)) {
                $disk->makeDirectory($dir, 0755, true, true);
            }

            if (!$disk->exists($path)) {
                $disk->put($path, $this->csvLine($headers));
            }

            $disk->append($path, rtrim($this->csvLine($row), "\r\n"));
        } catch (\Throwable $e) {
            Log::warning('CSV append failed', [
                'file'  => $filename,
                'error' => $e->getMessage(),
            ]);
            // swallow error; do not break webhook
        }
    }

    /** Build a CSV line in memory */
    private function csvLine(array $fields): string
    {
        $fp = fopen('php://temp', 'r+');
        fputcsv($fp, $fields);
        rewind($fp);
        $line = (string) stream_get_contents($fp);
        fclose($fp);
        return $line;
    }
}
