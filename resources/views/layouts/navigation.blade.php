@php
    $links = [
        ['label' => 'Plots', 'route' => 'plots.index', 'active' => 'plots.*'],
        ['label' => 'Owners', 'route' => 'owners.index', 'active' => 'owners.*'],
        ['label' => 'Deceased', 'route' => 'deceased.index', 'active' => 'deceased.*'],
        ['label' => 'Burials', 'route' => 'burials.index', 'active' => 'burials.*'],
        ['label' => 'Payments', 'route' => 'payments.index', 'active' => 'payments.*'],
    ];
@endphp

<nav class="border-b border-emerald-950 bg-emerald-950 text-emerald-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4 py-4">
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('dashboard') }}" class="mr-2 flex items-center gap-3 text-lg font-semibold tracking-tight text-white">
                    <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-700 text-sm font-bold shadow-sm">CS</span>
                    <span>Cemetery System</span>
                </a>

                @foreach ($links as $link)
                    <a href="{{ route($link['route']) }}" @class([
                        'rounded-md px-3 py-2 text-sm font-medium transition',
                        'bg-white text-emerald-950 shadow-sm' => request()->routeIs($link['active']),
                        'text-emerald-100 hover:bg-emerald-900 hover:text-white' => ! request()->routeIs($link['active']),
                    ])>
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center gap-3 text-sm">
                @auth
                    <span class="rounded-md bg-emerald-900 px-3 py-2 text-emerald-100">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="rounded-md border border-emerald-700 px-3 py-2 text-emerald-50 hover:bg-emerald-900">
                            Log Out
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-md bg-white px-3 py-2 font-medium text-emerald-950 hover:bg-emerald-50">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-md border border-emerald-700 px-3 py-2 text-emerald-50 hover:bg-emerald-900">
                            Register
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>
