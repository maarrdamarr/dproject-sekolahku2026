<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $pageTitle = trim($__env->yieldContent('title'));
        @endphp

        <title>{{ $pageTitle !== '' ? $pageTitle : 'Sekolahku' }} - {{ config('app.name', 'Sekolahku') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,600,700&family=instrument-sans:400,500,600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --accent: #0f766e;
                --accent-soft: rgba(15, 118, 110, 0.15);
            }

            body {
                font-family: "Instrument Sans", sans-serif;
            }

            .font-display {
                font-family: "Space Grotesk", sans-serif;
            }

            .public-shell {
                background-image: radial-gradient(circle at top left, rgba(16, 185, 129, 0.12), transparent 45%),
                    radial-gradient(circle at top right, rgba(14, 116, 144, 0.12), transparent 40%),
                    radial-gradient(circle at bottom right, rgba(59, 130, 246, 0.08), transparent 40%);
            }

            .public-card {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 16px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-900">
        <div class="min-h-screen public-shell">
            <x-public.navbar />

            <main class="mx-auto max-w-6xl px-4 pb-16 pt-10">
                @yield('content')
            </main>

            <footer class="border-t border-slate-200/80 bg-white/70 py-6">
                <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-2 px-4 text-sm text-slate-600 md:flex-row md:items-center">
                    <span class="font-display text-slate-800">{{ config('app.name', 'Sekolahku') }}</span>
                    <span>Portal informasi sekolah dan layanan akademik.</span>
                </div>
            </footer>
        </div>
    </body>
</html>
