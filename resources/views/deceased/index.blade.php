<x-app-layout>
    <x-slot name="header">Deceased Records</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Deceased Records</span>
            <div class="flex gap-2 items-center">
                <form method="GET" action="{{ route('deceased.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="form-control" style="width:220px;padding:6px 12px;">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    @if(request('search'))
                        <a href="{{ route('deceased.index') }}" class="btn btn-outline btn-sm">Clear</a>
                    @endif
                </form>
                <a href="{{ route('deceased.create') }}" class="btn btn-primary btn-sm">+ Add Record</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Birth Date</th>
                        <th>Death Date</th>
                        <th>Age</th>

                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deceaseds as $deceased)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $deceased->full_name }}</strong></td>
                            <td>{{ $deceased->birth_date->format('M d, Y') }}</td>
                            <td>{{ $deceased->death_date->format('M d, Y') }}</td>
                            <td>{{ $deceased->age }} yrs</td>

                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('deceased.show', $deceased) }}" class="btn btn-outline btn-sm">View</a>
                                    <a href="{{ route('deceased.edit', $deceased) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('deceased.destroy', $deceased) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:#7a7a8a;padding:32px;">No deceased records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            {{ $deceaseds->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>