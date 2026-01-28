<?php

namespace App\Http\Controllers;

use App\Services\IdentityService;
use App\Services\PhoneHomeService;
use Illuminate\Foundation\Inspiring;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        protected IdentityService $identity,
        protected PhoneHomeService $phoneHome
    ) {}

    public function __invoke(): View
    {
        // Trigger phone-home on first request (fire and forget)
        $this->phoneHome->registerIfNeeded();

        if (! $this->identity->hasIdentity()) {
            return view('unclaimed');
        }

        // Get an inspiring quote
        $quote = $this->getInspiration();

        return view('home', [
            'username' => $this->identity->getUsername(),
            'displayName' => $this->identity->getDisplayName(),
            'avatarUrl' => $this->identity->getAvatarUrl(400),
            'profile' => $this->identity->getProfile(),
            'hubUrl' => config('shipforswag.hub_url'),
            'quote' => $quote['text'],
            'quoteAuthor' => $quote['author'],
        ]);
    }

    /**
     * Get a random inspiring quote parsed into text and author.
     *
     * @return array{text: string, author: string}
     */
    protected function getInspiration(): array
    {
        $raw = Inspiring::quotes()->random();
        $parts = explode(' - ', $raw, 2);

        return [
            'text' => trim($parts[0]),
            'author' => trim($parts[1] ?? 'Unknown'),
        ];
    }
}
