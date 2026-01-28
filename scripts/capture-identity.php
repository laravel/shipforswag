<?php

/**
 * Build-time Identity Capture Script
 *
 * This script runs during `composer install` (via post-install-cmd) while
 * the .git directory still exists. It captures the GitHub username from
 * the git remote origin URL and writes it to .env for runtime use.
 *
 * Supported URL formats:
 * - git@github.com:USERNAME/repo.git
 * - https://github.com/USERNAME/repo.git
 * - https://github.com/USERNAME/repo
 */

// Only run if .git directory exists (build-time, not runtime)
if (! is_dir('.git')) {
    exit(0);
}

// Get the remote origin URL
$remote = trim(shell_exec('git config --get remote.origin.url') ?? '');
if (! $remote) {
    exit(0);
}

// Parse username from git URL
// Matches: git@github.com:USER/repo.git OR https://github.com/USER/repo.git
if (preg_match('#[:/]([^/]+)/[^/]+(\.git)?$#', $remote, $matches)) {
    $username = $matches[1];

    // Skip if it's the original template repo
    if ($username === 'laravel') {
        exit(0);
    }

    // Read existing .env content
    $envPath = '.env';
    $envContent = file_exists($envPath) ? file_get_contents($envPath) : '';

    // Check if GITHUB_USERNAME already exists
    if (preg_match('/^GITHUB_USERNAME=/m', $envContent)) {
        // Update existing value
        $envContent = preg_replace(
            '/^GITHUB_USERNAME=.*$/m',
            "GITHUB_USERNAME={$username}",
            $envContent
        );
    } else {
        // Append new value
        $envContent = rtrim($envContent) . "\n\nGITHUB_USERNAME={$username}\n";
    }

    file_put_contents($envPath, $envContent);

    echo "Captured GitHub identity: {$username}\n";
}
