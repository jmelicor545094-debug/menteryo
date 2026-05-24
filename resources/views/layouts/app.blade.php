<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Cemetery Management') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary: #1a1a2e;
            --secondary: #16213e;
            --accent: #c9a84c;
            --accent-light: #e8c97a;
            --surface: #ffffff;
            --surface-2: #f8f7f4;
            --border: #e8e4dc;
            --text: #1a1a2e;
            --text-muted: #7a7a8a;
            --danger: #c0392b;
            --success: #27ae60;
            --warning: #d4a017;
            --sidebar-w: 260px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface-2);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            font-size: 15px;
        }

        /* SIDEBAR */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--primary);
            min-height: 100vh;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            box-shadow: 4px 0 24px rgba(0,0,0,0.15);
        }
        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar-logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: 0.3px;
            line-height: 1.2;
        }
        .sidebar-logo p {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            margin-top: 3px;
            letter-spacing: 0.8px;
            text-transform: uppercase;
        }
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        /* Dashboard direct link */
        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 15px;
            font-weight: 400;
            transition: all 0.2s;
            margin-bottom: 2px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-link.active { background: var(--accent); color: var(--primary); font-weight: 600; }
        .nav-icon { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; }
        .nav-link.active .nav-icon { opacity: 1; }

        /* DROPDOWN GROUP */
        .nav-group { margin-bottom: 2px; }
        .nav-group-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 8px;
            color: rgba(255,255,255,0.65);
            font-size: 15px;
            font-weight: 400;
            cursor: pointer;
            transition: all 0.2s;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-family: 'DM Sans', sans-serif;
        }
        .nav-group-btn:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-group-btn.open { color: #fff; background: rgba(255,255,255,0.05); }
        .nav-group-btn.has-active { color: var(--accent); }
        .nav-group-label { flex: 1; }
        .nav-group-arrow {
            width: 14px;
            height: 14px;
            opacity: 0.5;
            transition: transform 0.25s;
            flex-shrink: 0;
        }
        .nav-group-btn.open .nav-group-arrow { transform: rotate(180deg); }
        .nav-group-icon { width: 18px; height: 18px; opacity: 0.7; flex-shrink: 0; }
        .nav-group-btn.has-active .nav-group-icon { opacity: 1; }

        /* DROPDOWN CHILDREN */
        .nav-children {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s ease;
            padding-left: 14px;
        }
        .nav-children.open { max-height: 300px; }
        .nav-child {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 6px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            margin-bottom: 1px;
            border-left: 2px solid rgba(255,255,255,0.08);
        }
        .nav-child:hover { color: #fff; background: rgba(255,255,255,0.06); border-left-color: rgba(255,255,255,0.2); }
        .nav-child.active { color: var(--accent); border-left-color: var(--accent); background: rgba(201,168,76,0.08); font-weight: 500; }
        .nav-child-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: currentColor;
            opacity: 0.6;
            flex-shrink: 0;
        }
        .nav-child.active .nav-child-dot { opacity: 1; }

        /* SIDEBAR FOOTER */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,0.06);
        }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 14px; font-weight: 700;
            color: var(--primary);
            flex-shrink: 0;
        }
        .user-info { flex: 1; min-width: 0; }
        .user-name { font-size: 14px; font-weight: 500; color: #fff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-role { font-size: 11px; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.6px; }
        .role-badge { font-size: 10px; padding: 2px 7px; border-radius: 99px; font-weight: 600; letter-spacing: 0.4px; }
        .role-admin { background: rgba(201,168,76,0.2); color: var(--accent); }
        .role-staff { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.6); }
        .logout-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 8px 12px; margin-top: 6px;
            border-radius: 6px;
            color: rgba(255,255,255,0.4);
            font-size: 12px; cursor: pointer;
            transition: all 0.2s;
            background: none; border: none;
            width: 100%; text-align: left;
            font-family: 'DM Sans', sans-serif;
        }
        .logout-btn:hover { color: #ff6b6b; background: rgba(255,107,107,0.08); }

        /* MAIN */
        .main-wrapper { margin-left: var(--sidebar-w); flex: 1; min-height: 100vh; display: flex; flex-direction: column; }
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .page-title { font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 600; color: var(--primary); }
        .topbar-right { display: flex; align-items: center; gap: 12px; }
        .main-content { flex: 1; padding: 32px; }

        /* CARDS */
        .card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; }
        .card-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-family: 'Playfair Display', serif; font-size: 16px; font-weight: 600; color: var(--primary); }

        /* BUTTONS */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 7px; font-size: 13px; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--secondary); }
        .btn-accent { background: var(--accent); color: var(--primary); }
        .btn-accent:hover { background: var(--accent-light); }
        .btn-outline { background: transparent; border: 1px solid var(--border); color: var(--text-muted); }
        .btn-outline:hover { border-color: var(--text-muted); color: var(--text); }
        .btn-danger { background: #fef2f2; color: var(--danger); }
        .btn-danger:hover { background: var(--danger); color: #fff; }
        .btn-warning { background: #fffbeb; color: #92400e; }
        .btn-warning:hover { background: #f59e0b; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        thead th { padding: 12px 20px; text-align: left; font-size: 13px; font-weight: 600; color: var(--text-muted); letter-spacing: 0.8px; text-transform: uppercase; background: var(--surface-2); border-bottom: 1px solid var(--border); }
        tbody td { padding: 14px 20px; font-size: 15px; border-bottom: 1px solid var(--border); color: var(--text); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #fafaf8; }

        /* BADGES */
        .badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; letter-spacing: 0.3px; }
        .badge-green  { background: #f0fdf4; color: #166534; }
        .badge-yellow { background: #fefce8; color: #854d0e; }
        .badge-red    { background: #fef2f2; color: #991b1b; }
        .badge-blue   { background: #eff6ff; color: #1e40af; }
        .badge-gray   { background: #f9fafb; color: #374151; border: 1px solid #e5e7eb; }

        /* FORMS */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: var(--text); margin-bottom: 6px; }
        .form-label span { color: var(--text-muted); font-weight: 400; }
        .form-control { width: 100%; padding: 9px 14px; border: 1px solid var(--border); border-radius: 8px; font-size: 13.5px; font-family: 'DM Sans', sans-serif; color: var(--text); background: var(--surface); transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
        .form-control:focus { border-color: var(--accent); box-shadow: 0 0 0 3px rgba(201,168,76,0.12); }
        .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: 13.5px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* STAT CARDS */
        .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: 12px; padding: 20px 24px; display: flex; flex-direction: column; gap: 6px; }
        .stat-label { font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.8px; }
        .stat-value { font-family: 'Playfair Display', serif; font-size: 32px; font-weight: 700; color: var(--primary); line-height: 1; }
        .stat-sub { font-size: 12px; color: var(--text-muted); }
        .stat-accent { border-top: 3px solid var(--accent); }
        .stat-green  { border-top: 3px solid var(--success); }
        .stat-yellow { border-top: 3px solid var(--warning); }
        .stat-red    { border-top: 3px solid var(--danger); }
        .stat-blue   { border-top: 3px solid #3b82f6; }
        .stat-purple { border-top: 3px solid #8b5cf6; }

        /* GRID */
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .col-span-2 { grid-column: span 2; }
        .flex { display: flex; } .items-center { align-items: center; } .justify-between { justify-content: space-between; }
        .gap-2 { gap: 8px; } .gap-3 { gap: 12px; }
        .mt-1 { margin-top: 4px; } .mt-4 { margin-top: 16px; }
        .mb-4 { margin-bottom: 16px; } .mb-6 { margin-bottom: 24px; }
        .p-6 { padding: 24px; }
        .text-sm { font-size: 13px; } .text-xs { font-size: 11px; }
        .text-muted { color: var(--text-muted); }
        .font-medium { font-weight: 500; } .font-semibold { font-weight: 600; }
        .space-y-6 > * + * { margin-top: 24px; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <h1>⚜ Cemetery</h1>
            <p>Management System</p>
        </div>

        <nav class="sidebar-nav">

            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}"
               class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            {{-- SECTION A: Plot Management --}}
            @php $sectionA = request()->routeIs('plots.*') || request()->routeIs('owners.*'); @endphp
            <div class="nav-group">
                <button class="nav-group-btn {{ $sectionA ? 'open has-active' : '' }}"
                        onclick="toggleGroup(this)">
                    <svg class="nav-group-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <span class="nav-group-label">Section A — Plots</span>
                    <svg class="nav-group-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-children {{ $sectionA ? 'open' : '' }}">
                    <a href="{{ route('plots.index') }}"
                       class="nav-child {{ request()->routeIs('plots.*') ? 'active' : '' }}">
                        <span class="nav-child-dot"></span> Plot Management
                    </a>
                    <a href="{{ route('owners.index') }}"
                       class="nav-child {{ request()->routeIs('owners.*') ? 'active' : '' }}">
                        <span class="nav-child-dot"></span> Owner Management
                    </a>
                </div>
            </div>

            {{-- SECTION B: Records --}}
            @php $sectionB = request()->routeIs('deceased.*') || request()->routeIs('burials.*'); @endphp
            <div class="nav-group">
                <button class="nav-group-btn {{ $sectionB ? 'open has-active' : '' }}"
                        onclick="toggleGroup(this)">
                    <svg class="nav-group-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="nav-group-label">Section B — Records</span>
                    <svg class="nav-group-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-children {{ $sectionB ? 'open' : '' }}">
                    <a href="{{ route('deceased.index') }}"
                       class="nav-child {{ request()->routeIs('deceased.*') ? 'active' : '' }}">
                        <span class="nav-child-dot"></span> Deceased Records
                    </a>
                    <a href="{{ route('burials.index') }}"
                       class="nav-child {{ request()->routeIs('burials.*') ? 'active' : '' }}">
                        <span class="nav-child-dot"></span> Burial Records
                    </a>
                </div>
            </div>

            {{-- SECTION C: Finance --}}
            @php $sectionC = request()->routeIs('payments.*'); @endphp
            <div class="nav-group">
                <button class="nav-group-btn {{ $sectionC ? 'open has-active' : '' }}"
                        onclick="toggleGroup(this)">
                    <svg class="nav-group-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="nav-group-label">Section C — Finance</span>
                    <svg class="nav-group-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="nav-children {{ $sectionC ? 'open' : '' }}">
                    <a href="{{ route('payments.index') }}"
                       class="nav-child {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <span class="nav-child-dot"></span> Payment Records
                    </a>
                </div>
            </div>

        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ auth()->user()->role }}</div>
                </div>
                <span class="role-badge {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-staff' }}">
                    {{ auth()->user()->isAdmin() ? 'Admin' : 'Staff' }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            @isset($header)
                <div class="page-title">{{ $header }}</div>
            @else
                <div class="page-title">Cemetery Management</div>
            @endisset
            <div class="topbar-right">
                <span style="font-size:13px;color:#7a7a8a;">{{ now()->format('D, M d Y') }}</span>
            </div>
        </header>

        <main class="main-content">
            {{ $slot }}
        </main>
    </div>

    <script>
        function toggleGroup(btn) {
            const isOpen = btn.classList.contains('open');
            const children = btn.nextElementSibling;

            if (isOpen) {
                btn.classList.remove('open');
                children.classList.remove('open');
            } else {
                btn.classList.add('open');
                children.classList.add('open');
            }
        }
    </script>

</body>
</html>