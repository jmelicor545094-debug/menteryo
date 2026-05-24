<x-app-layout>
    <x-slot name="header">Deceased — {{ $deceased->full_name }}</x-slot>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Personal Information</span>
                <div class="flex gap-2">
                    <a href="{{ route('deceased.edit', $deceased) }}" class="btn btn-accent btn-sm">Edit</a>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('deceased.destroy', $deceased) }}" method="POST" onsubmit="return confirm('Delete this record?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                    <a href="{{ route('deceased.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div class="p-6 grid-2">
                <div><div class="text-muted text-sm">Full Name</div><div class="font-semibold">{{ $deceased->full_name }}</div></div>
                <div><div class="text-muted text-sm">Age at Death</div><div class="font-semibold">{{ $deceased->age }} years old</div></div>
                <div><div class="text-muted text-sm">Birth Date</div><div class="font-semibold">{{ $deceased->birth_date->format('F d, Y') }}</div></div>
                <div><div class="text-muted text-sm">Death Date</div><div class="font-semibold">{{ $deceased->death_date->format('F d, Y') }}</div></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Assigned Plot</span></div>
            <div class="p-6">
                @if($deceased->plot)
                    <div class="grid-2">
                        <div><div class="text-muted text-sm">Plot Number</div><div class="font-semibold">{{ $deceased->plot->plot_number }}</div></div>
                        <div><div class="text-muted text-sm">Section</div><div class="font-semibold">{{ $deceased->plot->section }}</div></div>
                        <div><div class="text-muted text-sm">Price</div><div class="font-semibold">₱{{ number_format($deceased->plot->price, 2) }}</div></div>
                    </div>
                @else
                    <div class="text-muted">No plot assigned yet.</div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Burial Record</span></div>
            <div class="p-6">
                @if($deceased->burial)
                    <div class="grid-2">
                        <div><div class="text-muted text-sm">Burial Date</div><div class="font-semibold">{{ \Carbon\Carbon::parse($deceased->burial->burial_date)->format('F d, Y') }}</div></div>
                        <div><div class="text-muted text-sm">Recorded By</div><div class="font-semibold">{{ $deceased->burial->createdBy->name ?? 'N/A' }}</div></div>
                        @if($deceased->burial->notes)
                            <div class="col-span-2"><div class="text-muted text-sm">Notes</div><div class="font-semibold">{{ $deceased->burial->notes }}</div></div>
                        @endif
                    </div>
                @else
                    <div class="text-muted">No burial record yet.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>