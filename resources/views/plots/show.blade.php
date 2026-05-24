<x-app-layout>
    <x-slot name="header">Plot — {{ $plot->plot_number }}</x-slot>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Plot Information</span>
                <div class="flex gap-2">
                    <a href="{{ route('plots.edit', $plot) }}" class="btn btn-accent btn-sm">Edit</a>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('plots.destroy', $plot) }}" method="POST" onsubmit="return confirm('Delete this plot?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                    <a href="{{ route('plots.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div class="p-6 grid-2">
                <div><div class="text-muted text-sm">Plot Number</div><div class="font-semibold">{{ $plot->plot_number }}</div></div>
                <div><div class="text-muted text-sm">Section</div><div class="font-semibold">{{ $plot->section }}</div></div>
                <div><div class="text-muted text-sm">Status</div>
                    @php $cls = ['available'=>'badge-green','reserved'=>'badge-yellow','occupied'=>'badge-red']; @endphp
                    <span class="badge {{ $cls[$plot->status] }}">{{ ucfirst($plot->status) }}</span>
                </div>
                <div><div class="text-muted text-sm">Price</div><div class="font-semibold">₱{{ number_format($plot->price, 2) }}</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Owners</span></div>
            <div class="p-6">
                @forelse($plot->owners as $owner)
                    <div style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div class="font-medium">{{ $owner->full_name }}</div>
                        <div class="text-muted text-sm">{{ $owner->contact_number }}</div>
                    </div>
                @empty
                    <div class="text-muted">No owners assigned.</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Deceased</span></div>
            <div class="p-6">
                @if($plot->deceased)
                    <div class="font-medium">{{ $plot->deceased->full_name }}</div>
                    <div class="text-muted text-sm">Born: {{ $plot->deceased->birth_date->format('M d, Y') }} · Died: {{ $plot->deceased->death_date->format('M d, Y') }}</div>
                @else
                    <div class="text-muted">No deceased record linked.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Payments</span></div>
            <div class="p-6">
                @forelse($plot->payments as $payment)
                    <div class="flex justify-between items-center" style="padding:8px 0;border-bottom:1px solid var(--border);">
                        <div>
                            <div class="font-medium">{{ $payment->payment_date->format('M d, Y') }} — {{ ucfirst(str_replace('_',' ',$payment->payment_method)) }}</div>
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