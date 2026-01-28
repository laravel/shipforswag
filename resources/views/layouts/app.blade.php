<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name', 'Ship for Swag'))</title>
    <meta name="description" content="@yield('description', 'I shipped my app on Laravel Cloud!')">

    <!-- Open Graph / Social -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Ship for Swag')">
    <meta property="og:description" content="@yield('og_description', 'I deployed my Laravel app on Laravel Cloud!')">
    <meta property="og:image" content="{{ url('/og-image.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Ship for Swag')">
    <meta name="twitter:description" content="@yield('og_description', 'I deployed my Laravel app on Laravel Cloud!')">
    <meta name="twitter:image" content="{{ url('/og-image.png') }}">

    <!-- Fonts - Switzer for that refined Laravel Cloud feel -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --laravel-red: #FF2D20;
            --laravel-red-dark: #E62A1E;
        }

        body {
            font-family: 'Outfit', system-ui, sans-serif;
        }

        .text-laravel {
            color: var(--laravel-red);
        }

        .bg-laravel {
            background-color: var(--laravel-red);
        }

        .hover\:bg-laravel-dark:hover {
            background-color: var(--laravel-red-dark);
        }

        .ring-laravel {
            --tw-ring-color: var(--laravel-red);
        }

        /* Subtle animated gradient background */
        .bg-gradient-animated {
            background: linear-gradient(135deg, #fafafa 0%, #fff5f5 50%, #fafafa 100%);
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Fade in animation */
        .fade-in {
            animation: fadeIn 0.6s ease-out forwards;
            opacity: 0;
        }

        .fade-in-delay-1 { animation-delay: 0.1s; }
        .fade-in-delay-2 { animation-delay: 0.2s; }
        .fade-in-delay-3 { animation-delay: 0.3s; }
        .fade-in-delay-4 { animation-delay: 0.4s; }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Avatar glow effect */
        .avatar-glow {
            box-shadow:
                0 0 0 4px white,
                0 0 0 6px rgba(255, 45, 32, 0.15),
                0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        /* Button hover lift */
        .btn-lift {
            transition: all 0.2s ease;
        }

        .btn-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px -10px rgba(255, 45, 32, 0.4);
        }

        /* Subtle card */
        .card-subtle {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-animated text-slate-800 antialiased">
    <div class="min-h-screen flex flex-col">
        @yield('content')

        <footer class="mt-auto py-8 text-center">
            <p class="text-sm text-slate-400 tracking-wide">
                Powered by
                <a href="https://cloud.laravel.com" class="text-laravel hover:underline font-medium transition-colors" target="_blank" rel="noopener">Laravel Cloud</a>
            </p>
        </footer>
    </div>
</body>
</html>
