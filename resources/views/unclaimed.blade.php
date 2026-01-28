@extends('layouts.app')

@section('title', 'Ship for Swag')
@section('description', 'Fork and deploy this app on Laravel Cloud to claim your spot!')
@section('og_title', 'Ship for Swag')
@section('og_description', 'Fork and deploy this app on Laravel Cloud to claim your spot!')

@section('content')
<main class="flex-1 flex items-center justify-center px-6 py-16">
    <div class="max-w-xl w-full text-center">
        <!-- Animated placeholder avatar -->
        <div class="fade-in mb-10">
            <div class="relative inline-block">
                <div class="w-36 h-36 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center avatar-glow">
                    <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <!-- Waiting indicator -->
                <div class="absolute -bottom-1 -right-1 w-10 h-10 bg-amber-400 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Headline -->
        <div class="fade-in fade-in-delay-1 mb-4">
            <h1 class="text-4xl sm:text-5xl font-semibold text-slate-900 tracking-tight">
                Awaiting deployment
            </h1>
        </div>

        <!-- Description -->
        <div class="fade-in fade-in-delay-2 mb-10">
            <p class="text-lg text-slate-500 max-w-md mx-auto">
                This fork hasn't been deployed to Laravel Cloud yet. Once deployed, your identity will appear here automatically.
            </p>
        </div>

        <!-- Steps card -->
        <div class="fade-in fade-in-delay-3 card-subtle rounded-2xl p-8 mb-10 text-left max-w-md mx-auto">
            <h2 class="text-sm font-semibold text-slate-900 uppercase tracking-wider mb-6">How to claim your spot</h2>
            <ol class="space-y-5">
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-7 h-7 bg-laravel/10 text-laravel rounded-full flex items-center justify-center text-sm font-semibold mr-4">1</span>
                    <div>
                        <p class="text-slate-700 font-medium">Fork the repository</p>
                        <p class="text-sm text-slate-400 mt-0.5">Create your own copy on GitHub</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-7 h-7 bg-laravel/10 text-laravel rounded-full flex items-center justify-center text-sm font-semibold mr-4">2</span>
                    <div>
                        <p class="text-slate-700 font-medium">Deploy to Laravel Cloud</p>
                        <p class="text-sm text-slate-400 mt-0.5">Connect and deploy in minutes</p>
                    </div>
                </li>
                <li class="flex items-start">
                    <span class="flex-shrink-0 w-7 h-7 bg-laravel/10 text-laravel rounded-full flex items-center justify-center text-sm font-semibold mr-4">3</span>
                    <div>
                        <p class="text-slate-700 font-medium">Share your page</p>
                        <p class="text-sm text-slate-400 mt-0.5">Your identity appears automatically</p>
                    </div>
                </li>
            </ol>
        </div>

        <!-- CTA buttons -->
        <div class="fade-in fade-in-delay-4 flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a
                href="https://github.com/laravel/shipforswag"
                class="inline-flex items-center justify-center px-8 py-3.5 bg-laravel hover:bg-laravel-dark text-white font-medium rounded-full btn-lift"
                target="_blank"
                rel="noopener"
            >
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
                </svg>
                Fork on GitHub
            </a>
            <a
                href="https://cloud.laravel.com"
                class="inline-flex items-center text-sm text-slate-500 hover:text-slate-700 transition-colors"
                target="_blank"
                rel="noopener"
            >
                Learn about Laravel Cloud
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
        </div>
    </div>
</main>
@endsection
