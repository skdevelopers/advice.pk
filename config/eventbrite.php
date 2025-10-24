<?php

return [
    // Optional: guard your webhook URL using ?t=...
    'webhook_secret' => env('EVENTBRITE_WEBHOOK_SECRET', ''),

    // Token your server uses to call Eventbrite API (orders/attendees/events)
    // Should belong to the ORGANIZER account that owns events
    'server_token'   => env('EVENTBRITE_SERVER_TOKEN', ''),

    // Base API (rarely needs change)
    'base' => 'https://www.eventbriteapi.com',
];
