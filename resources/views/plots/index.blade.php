<x-app-layout>
    <x-slot name="header">Plot Management</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Plots</span>
            <div class="flex gap-2 items-center">
                <a href="{{ route('plots.index') }}" class="btn btn-outline btn-sm {{ !request('status') ? 'active' : '' }}">All</a>
                <a href="{{ route('plots.index', ['status' => 'available']) }}" class="btn btn-outline btn-sm {{ request('status') === 'available' ? 'active' : '' }}">Available</a>
                <a href="{{ route('plots.index', ['status' => 'reserved']) }}" class="btn btn-outline btn-sm {{ request('status') === 'reserved' ? 'active' : '' }}">Reserved</a>
                <a href="{{ route('plots.index', ['status' => 'occupied']) }}" class="btn btn-outline btn-sm {{ request('status') === 'occupied' ? 'active' : '' }}">Occupied</a>
                <a href="{{ route('plots.create') }}" class="btn btn-primary btn-sm">+ Add Plot</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Plot No.</th>
                        <th>Section</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plots as $plot)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $plot->plot_number }}</strong></td>
                            <td>{{ $plot->section }}</td>
                            <td>
                                @php
                                    $cls = ['available' => 'badge-green', 'reserved' => 'badge-yellow', 'occupied' => 'badge-red'];
                                @endphp
                                <span class="badge {{ $cls[$plot->status] }}">{{ ucfirst($plot->status) }}</span>
                            </td>
                            <td>₱{{ number_format($plot->price, 2) }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('plots.show', $plot) }}" class="btn btn-outline btn-sm">View</a>
                                    <a href="{{ route('plots.edit', $plot) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('plots.destroy', $plot) }}" method="POST" onsubmit="return confirm('Delete this plot?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" style="text-align:center;color:#7a7a8a;padding:32px;">No plots found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            {{ $plots->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>