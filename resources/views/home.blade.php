@extends('layouts.app')

@section('title', "{$displayName} shipped!")
@section('description', "{$displayName} deployed their Laravel app on Laravel Cloud")
@section('og_title', "You shipped, {$displayName}!")
@section('og_description', "{$username} deployed their Laravel app on Laravel Cloud")

@section('content')
<main class="flex-1 flex items-center justify-center px-6 py-16">
    <div class="max-w-lg w-full text-center">
        <!-- Avatar with elegant presentation -->
        <div class="fade-in mb-10">
            <div class="relative inline-block">
                <img
                    src="{{ $avatarUrl }}"
                    alt="{{ $displayName }}"
                    class="w-36 h-36 rounded-full avatar-glow object-cover"
                >
                <!-- Success checkmark badge -->
                <div class="absolute -bottom-1 -right-1 w-10 h-10 bg-laravel rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Main headline -->
        <div class="fade-in fade-in-delay-1 mb-3">
            <h1 class="text-4xl sm:text-5xl font-semibold text-slate-900 tracking-tight">
                You shipped!
            </h1>
        </div>

        <!-- Display name and handle -->
        <div class="fade-in fade-in-delay-2 mb-6">
            <p class="text-xl text-slate-600 mb-1">
                {{ $displayName }}
            </p>
            <a
                href="https://github.com/{{ $username }}"
                class="inline-flex items-center text-slate-400 hover:text-laravel transition-colors text-sm"
                target="_blank"
                rel="noopener"
            >
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
                {{ $username }}
            </a>
        </div>

        <!-- Encouragement message -->
        <div class="fade-in fade-in-delay-2 mb-10">
            <p class="text-slate-500 text-base max-w-sm mx-auto leading-relaxed">
                That was the easy part. Now go build something incredible.
            </p>
        </div>

        <!-- Inspiring quote card -->
        <div class="fade-in fade-in-delay-3 card-subtle rounded-2xl p-6 mb-10 max-w-md mx-auto">
            <svg class="w-8 h-8 text-laravel/20 mx-auto mb-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
            </svg>
            <blockquote class="text-slate-700 text-sm italic leading-relaxed mb-2">
                {{ $quote }}
            </blockquote>
            <cite class="text-xs text-slate-400 not-italic">
                — {{ $quoteAuthor }}
            </cite>
        </div>

        <!-- Primary CTA -->
        <div class="fade-in fade-in-delay-4 mb-6">
            <a
                href="{{ $hubUrl }}"
                class="inline-flex items-center justify-center px-8 py-3.5 bg-laravel hover:bg-laravel-dark text-white font-medium rounded-full btn-lift"
                target="_blank"
                rel="noopener"
            >
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                See all participants
            </a>
        </div>

        <!-- Secondary link -->
        <div class="fade-in fade-in-delay-4">
            <a
                href="https://github.com/{{ $username }}"
                class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 transition-colors"
                target="_blank"
                rel="noopener"
            >
                View GitHub Profile
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>
</main>
@endsection
