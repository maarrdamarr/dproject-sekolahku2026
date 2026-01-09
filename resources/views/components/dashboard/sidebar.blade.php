@props(['items' => [], 'role' => 'Dashboard'])

<aside class="dashboard-sidebar">
    <div class="dashboard-sidebar__inner">
        <div class="dashboard-sidebar__header">
            <p class="text-xs uppercase tracking-[0.3em] text-white/60">Menu</p>
            <p class="font-display text-lg text-white">{{ $role }}</p>
        </div>

        <nav class="dashboard-sidebar__nav">
            @foreach($items as $item)
                @php
                    $active = $item['active'] ?? false;
                @endphp
                <a href="{{ $item['url'] }}" class="dashboard-sidebar__link {{ $active ? 'is-active' : '' }}">
                    <span>{{ $item['label'] }}</span>
                </a>
            @endforeach
        </nav>
    </div>
</aside>

<style>
    .dashboard-sidebar {
        min-height: calc(100vh - 88px);
        width: 260px;
        background: var(--sidebar-bg);
        color: var(--sidebar-text);
        border-right: 1px solid rgba(148, 163, 184, 0.2);
    }

    .dashboard-sidebar__inner {
        padding: 1.5rem 1.25rem;
        position: sticky;
        top: 0;
    }

    .dashboard-sidebar__header {
        margin-bottom: 1.5rem;
    }

    .dashboard-sidebar__nav {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .dashboard-sidebar__link {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.6rem 0.8rem;
        border-radius: 12px;
        font-size: 0.95rem;
        color: rgba(226, 232, 240, 0.9);
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }

    .dashboard-sidebar__link:hover {
        background: rgba(148, 163, 184, 0.15);
        color: white;
        transform: translateX(2px);
    }

    .dashboard-sidebar__link.is-active {
        background: var(--accent-soft);
        color: white;
        box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 1024px) {
        .dashboard-sidebar {
            display: none;
        }
    }
</style>
