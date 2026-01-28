<?php

namespace App\Services;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhoneHomeService
{
    protected const COOKIE_NAME = 'shipforswag_phoned_home';

    public function __construct(
        protected IdentityService $identity
    ) {}

    /**
     * Register this fork with the hub (once per browser session).
     * This is a fire-and-forget operation that won't block the request.
     */
    public function registerIfNeeded(): void
    {
        if (! $this->shouldPhoneHome()) {
            return;
        }

        $this->register();
    }

    /**
     * Check if we should phone home.
     */
    protected function shouldPhoneHome(): bool
    {
        // Disabled via config
        if (! config('shipforswag.phone_home_enabled', true)) {
            return false;
        }

        // No identity captured
        if (! $this->identity->hasIdentity()) {
            return false;
        }

        // Already phoned home this session (check cookie)
        if (request()->cookie(self::COOKIE_NAME)) {
            return false;
        }

        return true;
    }

    /**
     * Register with the hub.
     */
    protected function register(): void
    {
        $hubUrl = config('shipforswag.hub_url');
        $username = $this->identity->getUsername();

        try {
            Http::timeout(5)
                ->post("{$hubUrl}/api/forks/register", [
                    'github_username' => $username,
                    'deployed_url' => config('app.url'),
                ]);

            // Set cookie to prevent repeated phone-home calls (24 hour expiry)
            Cookie::queue(self::COOKIE_NAME, '1', 60 * 24);
        } catch (\Throwable $e) {
            // Silently fail - this is non-critical functionality
            Log::debug('Phone home failed', ['error' => $e->getMessage()]);
        }
    }
}
