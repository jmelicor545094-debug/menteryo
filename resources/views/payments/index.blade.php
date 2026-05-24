<x-app-layout>
    <x-slot name="header">Payments</x-slot>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">All Payments</span>
            <div class="flex gap-2 items-center">
                <form method="GET" action="{{ route('payments.index') }}" class="flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by owner name..." class="form-control" style="width:220px;padding:6px 12px;">
                    <select name="status" class="form-control" style="width:140px;padding:6px 12px;">
                        <option value="">All Status</option>
                        <option value="paid"    {{ request('status') === 'paid'    ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                    @if(request('search') || request('status'))
                        <a href="{{ route('payments.index') }}" class="btn btn-outline btn-sm">Clear</a>
                    @endif
                </form>
                <a href="{{ route('payments.create') }}" class="btn btn-primary btn-sm">+ Add Payment</a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Owner</th>
                        <th>Plot</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $payment->owner->full_name ?? 'N/A' }}</strong></td>
                            <td>{{ $payment->plot->plot_number ?? 'N/A' }} — {{ $payment->plot->section ?? '' }}</td>
                            <td><strong>₱{{ number_format($payment->amount, 2) }}</strong></td>
                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                            <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                            <td>
                                <span class="badge {{ $payment->status === 'paid' ? 'badge-green' : 'badge-yellow' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2">
                                    <a href="{{ route('payments.show', $payment) }}" class="btn btn-outline btn-sm">View</a>
                                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-warning btn-sm">Edit</a>
                                    @if(auth()->user()->isAdmin())
                                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" style="text-align:center;color:#7a7a8a;padding:32px;">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding:16px 20px;border-top:1px solid var(--border);">
            {{ $payments->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>