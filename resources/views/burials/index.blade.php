<x-app-layout>
    <x-slot name="header">Burial Records</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Burial Records</span>
            <div class="flex gap-2 items-center">
                <form method="GET" action="{{ route('burials.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by deceased name..." class="form-control" style="width:240px;padding:6px 12px;">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    @if(request('search'))
                        <a href="{{ route('burials.index') }}" class="btn btn-outline btn-sm">Clear</a>
                    @endif
                </form>
                <a href="{{ route('burials.create') }}" class="btn btn-primary btn-sm">+ Add Burial</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Deceased</th>
                        <th>Plot</th>
                        <th>Burial Date</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($burials as $burial)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $burial->deceased->full_name ?? 'N/A' }}</strong></td>
                            <td>{{ $burial->plot->plot_number ?? 'N/A' }} — {{ $burial->plot->section ?? '' }}</td>
                            <td>{{ $burial->burial_date->format('M d, Y') }}</td>
                            <td>{{ $burial->createdBy->name ?? 'N/A' }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('burials.show', $burial) }}" class="btn btn-outline btn-sm">View</a>
                                    <a href="{{ route('burials.edit', $burial) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('burials.destroy', $burial) }}" method="POST" onsubmit="return confirm('Delete this burial record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:#7a7a8a;padding:32px;">No burial records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            {{ $burials->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>