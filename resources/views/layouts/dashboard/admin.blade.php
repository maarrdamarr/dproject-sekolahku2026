<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        @php
            $segmentTitle = 'Dashboard';
            foreach (array_reverse(request()->segments()) as $segment) {
                if (is_numeric($segment)) {
                    continue;
                }
                if (in_array($segment, ['create', 'edit'], true)) {
                    continue;
                }
                $segmentTitle = $segment;
                break;
            }
            $segmentTitle = ucwords(str_replace('-', ' ', $segmentTitle));
            $customTitle = trim($__env->yieldContent('page-title'));
            $pageTitle = $customTitle !== '' ? $customTitle : $segmentTitle;
            $title = trim($__env->yieldContent('title'));
        @endphp

        <title>{{ $title !== '' ? $title : $pageTitle }} - {{ config('app.name', 'Sekolahku') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=space-grotesk:400,600,700&family=instrument-sans:400,500,600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --accent: #4f46e5;
                --accent-soft: rgba(79, 70, 229, 0.14);
                --sidebar-bg: #0f172a;
                --sidebar-text: #e2e8f0;
                --banner-start: #1e1b4b;
                --banner-end: #0ea5e9;
            }

            body {
                font-family: "Instrument Sans", sans-serif;
            }

            .font-display {
                font-family: "Space Grotesk", sans-serif;
            }

            .dashboard-shell {
                background-image: radial-gradient(circle at top left, rgba(99, 102, 241, 0.16), transparent 45%),
                    radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.14), transparent 40%);
            }

            .dashboard-main :where(input, select, textarea) {
                width: 100%;
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.35);
                background: rgba(255, 255, 255, 0.9);
                padding: 0.65rem 0.8rem;
                font-size: 0.95rem;
                color: #0f172a;
            }

            .dashboard-main :where(input, select, textarea):focus {
                outline: 2px solid transparent;
                box-shadow: 0 0 0 3px var(--accent-soft);
                border-color: var(--accent);
            }

            .dashboard-main button {
                border-radius: 999px;
                padding: 0.55rem 1.2rem;
                font-weight: 600;
                background: var(--accent);
                color: white;
                box-shadow: 0 12px 24px rgba(79, 70, 229, 0.2);
                transition: transform 0.15s ease, box-shadow 0.15s ease;
            }

            .dashboard-main button:hover {
                transform: translateY(-1px);
                box-shadow: 0 16px 28px rgba(79, 70, 229, 0.3);
            }

            .dashboard-main table {
                width: 100%;
                border-collapse: collapse;
                border: 0;
                border-spacing: 0;
                background: rgba(255, 255, 255, 0.9);
                border-radius: 16px;
                overflow: hidden;
            }

            .dashboard-main th,
            .dashboard-main td {
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
                padding: 0.75rem 0.9rem;
                text-align: left;
                font-size: 0.95rem;
            }

            .dashboard-main th {
                background: rgba(226, 232, 240, 0.6);
                font-weight: 600;
            }

            .dashboard-card {
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(226, 232, 240, 0.8);
                border-radius: 18px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
                padding: 1.5rem;
            }

            @media (max-width: 768px) {
                .dashboard-main table {
                    display: block;
                    overflow-x: auto;
                    white-space: nowrap;
                }
            }
        </style>
    </head>
    <body class="bg-slate-100 text-slate-900">
        <div class="min-h-screen dashboard-shell">
            <x-dashboard.navbar role="Admin" />

            <div class="flex">
                @php
                    $menu = [
                        ['label' => 'Dashboard', 'url' => url('admin/dashboard'), 'active' => request()->is('admin/dashboard')],
                        ['label' => 'Users', 'url' => url('admin/users'), 'active' => request()->is('admin/users*')],
                        ['label' => 'Konten', 'url' => url('admin/contents'), 'active' => request()->is('admin/contents*')],
                        ['label' => 'Berita & Pengumuman', 'url' => url('admin/berita'), 'active' => request()->is('admin/berita*') || request()->is('admin/pengumuman*')],
                        ['label' => 'Galeri', 'url' => url('admin/galleries'), 'active' => request()->is('admin/galleries*')],
                        ['label' => 'Setting', 'url' => url('admin/settings'), 'active' => request()->is('admin/settings*')],
                        ['label' => 'Backup', 'url' => url('admin/backups'), 'active' => request()->is('admin/backups*')],
                        ['label' => 'Laporan', 'url' => url('admin/reports'), 'active' => request()->is('admin/reports')],
                    ];
                @endphp
                <x-dashboard.sidebar :items="$menu" role="Admin" />

                <main class="dashboard-main flex-1 px-6 py-8">
                    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Panel Admin</p>
                            <h1 class="font-display text-2xl text-slate-900">{{ $pageTitle }}</h1>
                            @hasSection('page-description')
                                <p class="mt-1 text-sm text-slate-600">@yield('page-description')</p>
                            @endif
                        </div>
                        @yield('page-actions')
                    </div>

                    @if(!empty($menu))
                        <div class="mb-6 lg:hidden">
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                @foreach($menu as $item)
                                    @php
                                        $active = $item['active'] ?? false;
                                    @endphp
                                    <a href="{{ $item['url'] }}" class="rounded-full border px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] {{ $active ? 'border-indigo-500 text-indigo-600' : 'border-slate-200 text-slate-500' }}">
                                        {{ $item['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="space-y-6">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
