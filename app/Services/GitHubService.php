<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GitHubService
{
    /**
     * Fetch a GitHub user profile by username.
     *
     * @return array{
     *     login: string,
     *     name: string|null,
     *     avatar_url: string,
     *     html_url: string,
     *     bio: string|null,
     * }|null
     */
    public function getUser(string $username): ?array
    {
        $cacheKey = "github_user:{$username}";
        $cacheTtl = config('shipforswag.github_cache_ttl', 21600);

        return Cache::remember($cacheKey, $cacheTtl, function () use ($username) {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'ShipForSwag/1.0',
                ])
                ->get("https://api.github.com/users/{$username}");

            if ($response->failed()) {
                return null;
            }

            $data = $response->json();

            return [
                'login' => $data['login'],
                'name' => $data['name'],
                'avatar_url' => $data['avatar_url'],
                'html_url' => $data['html_url'],
                'bio' => $data['bio'],
            ];
        });
    }

    /**
     * Get the avatar URL for a GitHub user.
     * Falls back to GitHub's identicon if user not found.
     */
    public function getAvatarUrl(string $username, int $size = 200): string
    {
        return "https://github.com/{$username}.png?size={$size}";
    }
}
