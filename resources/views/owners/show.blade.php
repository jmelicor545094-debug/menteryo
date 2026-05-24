<x-app-layout>
    <x-slot name="header">Owner — {{ $owner->full_name }}</x-slot>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Owner Information</span>
                <div class="flex gap-2">
                    <a href="{{ route('owners.edit', $owner) }}" class="btn btn-accent btn-sm">Edit</a>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('owners.destroy', $owner) }}" method="POST" onsubmit="return confirm('Delete this owner?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                    <a href="{{ route('owners.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div class="p-6 grid-2">
                <div><div class="text-muted text-sm">Full Name</div><div class="font-semibold">{{ $owner->full_name }}</div></div>
                <div><div class="text-muted text-sm">Contact Number</div><div class="font-semibold">{{ $owner->contact_number }}</div></div>
                <div class="col-span-2"><div class="text-muted text-sm">Address</div><div class="font-semibold">{{ $owner->address }}</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Assigned Plots</span></div>
            <div class="p-6">
                @forelse($owner->plots as $plot)
                    <div class="flex justify-between items-center" style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div class="font-medium">{{ $plot->plot_number }} — {{ $plot->section }}</div>
                        <div class="flex gap-2 items-center">
                            @php $cls = ['available'=>'badge-green','reserved'=>'badge-yellow','occupied'=>'badge-red']; @endphp
                            <span class="badge {{ $cls[$plot->status] }}">{{ ucfirst($plot->status) }}</span>
                            <span>₱{{ number_format($plot->price, 2) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">No plots assigned.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Payment History</span></div>
            <div class="p-6">
                @forelse($owner->payments as $payment)
                    <div class="flex justify-between items-center" style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div>
                            <div class="font-medium">{{ $payment->payment_date->format('M d, Y') }}</div>
                            <div class="text-muted text-sm">{{ ucfirst(str_replace('_',' ',$payment->payment_method)) }}</div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <strong>₱{{ number_format($payment->amount, 2) }}</strong>
                            <span class="badge {{ $payment->status === 'paid' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($payment->status) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="text-muted">No payments recorded.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>