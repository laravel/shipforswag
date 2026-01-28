<?php

return [

    /*
    |--------------------------------------------------------------------------
    | GitHub Username
    |--------------------------------------------------------------------------
    |
    | The GitHub username of the fork owner. This is automatically captured
    | during the build process by scripts/capture-identity.php reading the
    | git remote origin URL.
    |
    */

    'github_username' => env('GITHUB_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | Hub URL
    |--------------------------------------------------------------------------
    |
    | The URL of the Ship for Swag hub that displays all participants.
    | The fork will optionally phone home to this URL on first request.
    |
    */

    'hub_url' => env('SHIPFORSWAG_HUB_URL', 'https://shipforswag.com'),

    /*
    |--------------------------------------------------------------------------
    | Phone Home Enabled
    |--------------------------------------------------------------------------
    |
    | Whether to register this fork with the hub on first request.
    | Set to false to disable phone-home functionality.
    |
    */

    'phone_home_enabled' => env('SHIPFORSWAG_PHONE_HOME', false),

    /*
    |--------------------------------------------------------------------------
    | GitHub API Cache TTL
    |--------------------------------------------------------------------------
    |
    | How long to cache GitHub API responses (in seconds).
    | Default: 6 hours (21600 seconds)
    |
    */

    'github_cache_ttl' => env('GITHUB_CACHE_TTL', 21600),

    /*
    |--------------------------------------------------------------------------
    | OG Image Cache TTL
    |--------------------------------------------------------------------------
    |
    | How long to cache generated OG images (in seconds).
    | Default: 1 hour (3600 seconds)
    |
    */

    'og_image_cache_ttl' => env('OG_IMAGE_CACHE_TTL', 3600),

];
