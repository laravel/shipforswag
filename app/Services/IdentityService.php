<?php

namespace App\Services;

class IdentityService
{
    public function __construct(
        protected GitHubService $github
    ) {}

    /**
     * Get the GitHub username from config (auto-captured at build time).
     */
    public function getUsername(): ?string
    {
        return config('shipforswag.github_username');
    }

    /**
     * Check if a GitHub username has been captured.
     */
    public function hasIdentity(): bool
    {
        return $this->getUsername() !== null;
    }

    /**
     * Get the full GitHub profile for the captured username.
     *
     * @return array{
     *     login: string,
     *     name: string|null,
     *     avatar_url: string,
     *     html_url: string,
     *     bio: string|null,
     * }|null
     */
    public function getProfile(): ?array
    {
        $username = $this->getUsername();

        if (! $username) {
            return null;
        }

        return $this->github->getUser($username);
    }

    /**
     * Get the display name (real name or username fallback).
     */
    public function getDisplayName(): ?string
    {
        $profile = $this->getProfile();

        if (! $profile) {
            return $this->getUsername();
        }

        return $profile['name'] ?? $profile['login'];
    }

    /**
     * Get the avatar URL for the captured username.
     */
    public function getAvatarUrl(int $size = 200): ?string
    {
        $username = $this->getUsername();

        if (! $username) {
            return null;
        }

        return $this->github->getAvatarUrl($username, $size);
    }
}
