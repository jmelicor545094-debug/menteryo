<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <style>
        .dash-wrap { display: flex; flex-direction: column; gap: 28px; }

        /* WELCOME BANNER */
        .welcome-banner {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #1a2a4a 100%);
            border-radius: 16px;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(201,168,76,0.12) 0%, transparent 70%);
            right: -40px; top: -40px;
            border-radius: 50%;
        }
        .welcome-left { z-index: 1; }
        .welcome-greeting {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }
        .welcome-name {
            font-family: 'Playfair Display', serif;
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 4px;
        }
        .welcome-name span { color: #c9a84c; }
        .welcome-sub { font-size: 13px; color: rgba(255,255,255,0.6); }
        .welcome-date { z-index: 1; text-align: right; }
        .welcome-date-day {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 700;
            color: #c9a84c;
            line-height: 1;
        }
        .welcome-date-month {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* SECTION TITLE */
        .section-title {
            font-size: 11px;
            font-weight: 600;
            color: #7a7a8a;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8e4dc;
        }

        /* STAT GRID */
        .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
        .stat-box {
            background: #ffffff;
            border: 1px solid #e8e4dc;
            border-radius: 12px;
            padding: 22px 20px;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-box:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .stat-box-accent { border-top: 3px solid #c9a84c; }
        .stat-box-green  { border-top: 3px solid #27ae60; }
        .stat-box-yellow { border-top: 3px solid #f59e0b; }
        .stat-box-red    { border-top: 3px solid #c0392b; }
        .stat-box-blue   { border-top: 3px solid #3b82f6; }
        .stat-box-purple { border-top: 3px solid #8b5cf6; }
        .stat-box-teal   { border-top: 3px solid #14b8a6; }

        .stat-box-num {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 700;
            color: #1a1a2e;
            line-height: 1;
            margin-bottom: 6px;
        }
        .stat-box-label {
            font-size: 13px;
            color: #4a4a5a;
            font-weight: 500;
        }
        .stat-box-link {
            display: inline-block;
            margin-top: 10px;
            font-size: 11px;
            color: #c9a84c;
            text-decoration: none;
            font-weight: 600;
        }
        .stat-box-link:hover { text-decoration: underline; }

        /* REVENUE CARD */
        .revenue-card {
            background: linear-gradient(135deg, #0f6e56, #0a4f3d);
            border-radius: 12px;
            padding: 22px 20px;
            color: #fff;
            border: none;
            position: relative;
            overflow: hidden;
        }
        .revenue-label {
            font-size: 11px;
            color: rgba(255,255,255,0.75);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        .revenue-amount {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }
        .revenue-sub {
            font-size: 12px;
            color: rgba(255,255,255,0.65);
            margin-top: 6px;
        }

        /* BOTTOM GRID */
        .bottom-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }

        /* ACTIVITY CARD */
        .activity-card {
            background: #ffffff;
            border: 1px solid #e8e4dc;
            border-radius: 12px;
            overflow: hidden;
        }
        .activity-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e8e4dc;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .activity-title {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 600;
            color: #1a1a2e;
        }
        .activity-link {
            font-size: 11px;
            color: #c9a84c;
            text-decoration: none;
            font-weight: 600;
        }
        .activity-link:hover { text-decoration: underline; }
        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 20px;
            border-bottom: 1px solid #f0ede8;
            transition: background 0.15s;
        }
        .activity-item:last-child { border-bottom: none; }
        .activity-item:hover { background: #fafaf8; }
        .activity-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }
        .dot-blue   { background: #3b82f6; }
        .dot-green  { background: #27ae60; }
        .dot-yellow { background: #f59e0b; }
        .activity-info { flex: 1; min-width: 0; }
        .activity-name {
            font-size: 13px;
            font-weight: 500;
            color: #1a1a2e;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .activity-meta {
            font-size: 11px;
            color: #7a7a8a;
            margin-top: 2px;
        }
        .activity-right { text-align: right; flex-shrink: 0; }
        .activity-amount {
            font-size: 13px;
            font-weight: 600;
            color: #1a1a2e;
        }
        .pay-badge {
            display: inline-block;
            font-size: 10px;
            padding: 2px 8px;
            border-radius: 99px;
            font-weight: 600;
            margin-top: 2px;
        }
        .pay-paid    { background: #f0fdf4; color: #166534; }
        .pay-pending { background: #fefce8; color: #854d0e; }
        .empty-state {
            padding: 32px 20px;
            text-align: center;
            color: #7a7a8a;
            font-size: 13px;
        }

        @media (max-width: 900px) {
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
            .bottom-grid { grid-template-columns: 1fr; }
            .welcome-date { display: none; }
        }
    </style>

    <div class="dash-wrap">

        {{-- WELCOME BANNER --}}
        <div class="welcome-banner">
            <div class="welcome-left">
                <div class="welcome-greeting">Welcome back</div>
                <div class="welcome-name">{{ auth()->user()->name }} <span>✦</span></div>
                <div class="welcome-sub">Here's what's happening in the cemetery today.</div>
            </div>
            <div class="welcome-date">
                <div class="welcome-date-day">{{ now()->format('d') }}</div>
                <div class="welcome-date-month">{{ now()->format('M Y') }}</div>
            </div>
        </div>

        {{-- PLOTS --}}
        <div>
            <div class="section-title">Plot Overview</div>
            <div class="stat-grid" style="grid-template-columns: repeat(2, 1fr);">
                <div class="stat-box stat-box-accent">
                    <div class="stat-box-num">{{ $totalPlots }}</div>
                    <div class="stat-box-label">Total Plots</div>
                    <a href="{{ route('plots.index') }}" class="stat-box-link">View all →</a>
                </div>
                <div class="stat-box stat-box-green">
                    <div class="stat-box-num">{{ $availablePlots }}</div>
                    <div class="stat-box-label">Available</div>
                    <a href="{{ route('plots.index', ['status' => 'available']) }}" class="stat-box-link">View →</a>
                </div>
            </div>
        </div>

        {{-- RECORDS --}}
        <div>
            <div class="section-title">Records Overview</div>
            <div class="stat-grid">
                <div class="stat-box stat-box-blue">
                    <div class="stat-box-num">{{ $totalOwners }}</div>
                    <div class="stat-box-label">Total Owners</div>
                    <a href="{{ route('owners.index') }}" class="stat-box-link">View all →</a>
                </div>
                <div class="stat-box stat-box-purple">
                    <div class="stat-box-num">{{ $totalDeceased }}</div>
                    <div class="stat-box-label">Deceased Records</div>
                    <a href="{{ route('deceased.index') }}" class="stat-box-link">View all →</a>
                </div>
                <div class="stat-box stat-box-teal">
                    <div class="stat-box-num">{{ $totalBurials }}</div>
                    <div class="stat-box-label">Burial Records</div>
                    <a href="{{ route('burials.index') }}" class="stat-box-link">View all →</a>
                </div>
                <div class="revenue-card">
                    <div class="revenue-label">Total Revenue</div>
                    <div class="revenue-amount">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="revenue-sub">{{ $paidPayments }} paid · {{ $pendingPayments }} pending</div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div>
            <div class="section-title">Recent Activity</div>
            <div class="bottom-grid">

                <div class="activity-card">
                    <div class="activity-header">
                        <div class="activity-title">Recent Burials</div>
                        <a href="{{ route('burials.index') }}" class="activity-link">View all →</a>
                    </div>
                    @forelse($recentBurials as $burial)
                        <div class="activity-item">
                            <div class="activity-dot dot-blue"></div>
                            <div class="activity-info">
                                <div class="activity-name">{{ $burial->deceased->full_name ?? 'N/A' }}</div>
                                <div class="activity-meta">
                                    {{ $burial->burial_date->format('M d, Y') }} &middot;
                                    Plot {{ $burial->plot->plot_number ?? 'N/A' }}
                                </div>
                            </div>
                            <div class="activity-right">
                                <div class="activity-meta">{{ $burial->createdBy->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">No burial records yet.</div>
                    @endforelse
                </div>

                <div class="activity-card">
                    <div class="activity-header">
                        <div class="activity-title">Recent Payments</div>
                        <a href="{{ route('payments.index') }}" class="activity-link">View all →</a>
                    </div>
                    @forelse($recentPayments as $payment)
                        <div class="activity-item">
                            <div class="activity-dot {{ $payment->status === 'paid' ? 'dot-green' : 'dot-yellow' }}"></div>
                            <div class="activity-info">
                                <div class="activity-name">{{ $payment->owner->full_name ?? 'N/A' }}</div>
                                <div class="activity-meta">
                                    {{ $payment->payment_date->format('M d, Y') }} &middot;
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </div>
                            </div>
                            <div class="activity-right">
                                <div class="activity-amount">₱{{ number_format($payment->amount, 2) }}</div>
                                <span class="pay-badge {{ $payment->status === 'paid' ? 'pay-paid' : 'pay-pending' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">No payment records yet.</div>
                    @endforelse
                </div>

            </div>
        </div>

    </div>
</x-app-layout>