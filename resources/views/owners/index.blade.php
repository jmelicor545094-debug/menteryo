<x-app-layout>
    <x-slot name="header">Owner Management</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Owners</span>
            <div class="flex gap-2 items-center">
                <form method="GET" action="{{ route('owners.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or contact..." class="form-control" style="width:240px;padding:6px 12px;">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    @if(request('search'))
                        <a href="{{ route('owners.index') }}" class="btn btn-outline btn-sm">Clear</a>
                    @endif
                </form>
                <a href="{{ route('owners.create') }}" class="btn btn-primary btn-sm">+ Add Owner</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Plots Owned</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($owners as $owner)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $owner->full_name }}</strong></td>
                            <td>{{ $owner->contact_number }}</td>
                            <td>{{ Str::limit($owner->address, 40) }}</td>
                            <td><span class="badge badge-blue">{{ $owner->plots_count }} plot(s)</span></td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('owners.show', $owner) }}" class="btn btn-outline btn-sm">View</a>
                                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('owners.destroy', $owner) }}" method="POST" onsubmit="return confirm('Delete this owner?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:#7a7a8a;padding:32px;">No owners found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            {{ $owners->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>