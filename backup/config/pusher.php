<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Pusher Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Pusher real-time messaging service.
    | These values should match the ones in your .env file.
    |
    */

    'app_id' => env('PUSHER_APP_ID', '1973334'),
    'key' => env('PUSHER_APP_KEY', 'd767d86681964bbcd7d4'),
    'secret' => env('PUSHER_APP_SECRET', 'f9f029c495677caf1dab'),
    'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
    'encrypted' => true,
];
