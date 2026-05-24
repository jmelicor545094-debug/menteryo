<x-app-layout>
    <x-slot name="header">Payment — {{ $payment->owner->full_name ?? 'N/A' }}</x-slot>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Payment Information</span>
                <div class="flex gap-2">
                    <a href="{{ route('payments.edit', $payment) }}" class="btn btn-accent btn-sm">Edit</a>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Delete this payment?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                    <a href="{{ route('payments.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div class="p-6 grid-2">
                <div><div class="text-muted text-sm">Owner</div><div class="font-semibold">{{ $payment->owner->full_name ?? 'N/A' }}</div></div>
                <div><div class="text-muted text-sm">Plot</div><div class="font-semibold">{{ $payment->plot->plot_number ?? 'N/A' }} — {{ $payment->plot->section ?? '' }}</div></div>
                <div><div class="text-muted text-sm">Amount</div><div class="font-semibold">₱{{ number_format($payment->amount, 2) }}</div></div>
                <div><div class="text-muted text-sm">Payment Method</div><div class="font-semibold">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</div></div>
                <div><div class="text-muted text-sm">Payment Date</div><div class="font-semibold">{{ $payment->payment_date->format('F d, Y') }}</div></div>
                <div><div class="text-muted text-sm">Status</div>
                    <span class="badge {{ $payment->status === 'paid' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($payment->status) }}</span>
                </div>
                <div><div class="text-muted text-sm">Recorded By</div><div class="font-semibold">{{ $payment->createdBy->name ?? 'N/A' }}</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Owner Details</span></div>
            <div class="p-6">
                @if($payment->owner)
                    <div class="grid-2">
                        <div><div class="text-muted text-sm">Full Name</div><div class="font-semibold">{{ $payment->owner->full_name }}</div></div>
                        <div><div class="text-muted text-sm">Contact</div><div class="font-semibold">{{ $payment->owner->contact_number }}</div></div>
                        <div class="col-span-2"><div class="text-muted text-sm">Address</div><div class="font-semibold">{{ $payment->owner->address }}</div></div>
                    </div>
                @else
                    <div class="text-muted">No owner details found.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>