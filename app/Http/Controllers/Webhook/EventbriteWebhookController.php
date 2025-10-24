<?php
/**
 * Eventbrite Webhook receiver (POST).
 *
 * - Verifies optional shared secret (?t=...).
 * - Appends a webhook receipt row (delivery/action/api_url) to CSV.
 * - If api_url is present and looks valid, fetches the resource using the
 *   ORGANIZER server token and writes a normalized row to attendees.csv or orders.csv.
 *
 * CSV files (append-only):
 *   storage/app/eventbrite/webhooks.csv
 *   storage/app/eventbrite/attendees.csv
 *   storage/app/eventbrite/orders.csv
 *   storage/app/eventbrite/errors.csv    (only on failures)
 */

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Services\EventbriteClient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventbriteWebhookController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        // 1) Optional shared-secret guard
        $expected = (string) config('eventbrite.webhook_secret', '');
        if ($expected !== '' && $request->query('t') !== $expected) {
            return response()->json(['ok' => false, 'error' => 'forbidden'], 403);
        }

        // 2) Extract basics
        $deliveryId = (string) $request->header('X-Eventbrite-Delivery', Str::uuid()->toString());
        $payload    = $request->json()->all();
        $apiUrl     = (string) Arr::get($payload, 'api_url', '');
        $action     = (string) Arr::get($payload, 'config.action', 'unknown');

        Log::info('Eventbrite webhook received', compact('deliveryId','action','apiUrl'));

        // 3) Append webhook receipt
        $this->csvAppend('webhooks.csv',
            ['received_at','delivery_id','action','api_url'],
            [now()->toDateTimeString(), $deliveryId, $action, $apiUrl]
        );

        // 4) If api_url is present, try to fetch and normalize
        if ($apiUrl && ! str_contains($apiUrl, '{api-endpoint-to-fetch-object-details}')) {
            try {
                $client   = new EventbriteClient();
                $resource = $client->get($apiUrl);

                // Detect type by URL or keys
                $type = $this->detectType($apiUrl, $resource);

                if ($type === 'attendee') {
                    $row = $this->mapAttendeeRow($resource);
                    $this->csvAppend('attendees.csv',
                        array_keys($row),
                        array_values($row)
                    );
                } elseif ($type === 'order') {
                    $row = $this->mapOrderRow($resource);
                    $this->csvAppend('orders.csv',
                        array_keys($row),
                        array_values($row)
                    );
                } else {
                    // Unknown type, log to errors
                    $this->csvAppend('errors.csv',
                        ['time','delivery_id','reason','api_url'],
                        [now()->toDateTimeString(), $deliveryId, 'unknown_type', $apiUrl]
                    );
                }
            } catch (\Throwable $e) {
                $this->csvAppend('errors.csv',
                    ['time','delivery_id','reason','api_url'],
                    [now()->toDateTimeString(), $deliveryId, substr($e->getMessage(), 0, 500), $apiUrl]
                );
            }
        }

        // 5) Acknowledge quickly
        return response()->json(['ok' => true]);
    }

    /** Heuristic: attendee vs order */
    private function detectType(string $apiUrl, array $resource): string
    {
        $u = strtolower($apiUrl);
        if (str_contains($u, '/attendees/')) return 'attendee';
        if (str_contains($u, '/orders/'))    return 'order';

        // Fall back on keys
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

    /** Append-only CSV helper */
    private function csvAppend(string $filename, array $headers, array $row): void
    {
        $disk = Storage::disk('local'); // storage/app
        if (! $disk->exists('eventbrite')) {
            $disk->makeDirectory('eventbrite');
        }
        $path  = 'eventbrite/' . $filename;
        $full  = storage_path('app/' . $path);
        $isNew = ! file_exists($full);

        $fh = fopen($full, 'a');
        if ($isNew) fputcsv($fh, $headers);
        fputcsv($fh, $row);
        fclose($fh);
    }
}
