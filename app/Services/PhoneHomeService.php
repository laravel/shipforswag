<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PhoneHomeService
{
    protected const CACHE_KEY = 'shipforswag:phoned_home';

    public function __construct(
        protected IdentityService $identity
    ) {}

    /**
     * Register this fork with the hub (once per deployment).
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

        // Already phoned home this deployment
        if (Cache::has(self::CACHE_KEY)) {
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
                ->async()
                ->post("{$hubUrl}/api/forks/register", [
                    'github_username' => $username,
                    'deployed_url' => config('app.url'),
                ]);

            // Mark as phoned home (cache for 24 hours)
            Cache::put(self::CACHE_KEY, true, 86400);
        } catch (\Throwable $e) {
            // Silently fail - this is non-critical functionality
            Log::debug('Phone home failed', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Check if this fork has already phoned home.
     */
    public function hasPhonedHome(): bool
    {
        return Cache::has(self::CACHE_KEY);
    }
}
