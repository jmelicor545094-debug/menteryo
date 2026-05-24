<x-app-layout>
    <x-slot name="header">Burial — {{ $burial->deceased->full_name ?? 'N/A' }}</x-slot>

    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Burial Information</span>
                <div class="flex gap-2">
                    <a href="{{ route('burials.edit', $burial) }}" class="btn btn-accent btn-sm">Edit</a>
                    @if(auth()->user()->isAdmin())
                        <form action="{{ route('burials.destroy', $burial) }}" method="POST" onsubmit="return confirm('Delete this burial record?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    @endif
                    <a href="{{ route('burials.index') }}" class="btn btn-outline btn-sm">← Back</a>
                </div>
            </div>
            <div class="p-6 grid-2">
                <div><div class="text-muted text-sm">Deceased</div><div class="font-semibold">{{ $burial->deceased->full_name ?? 'N/A' }}</div></div>
                <div><div class="text-muted text-sm">Burial Date</div><div class="font-semibold">{{ $burial->burial_date->format('F d, Y') }}</div></div>
                <div><div class="text-muted text-sm">Plot</div><div class="font-semibold">{{ $burial->plot->plot_number ?? 'N/A' }} — {{ $burial->plot->section ?? '' }}</div></div>
                <div><div class="text-muted text-sm">Recorded By</div><div class="font-semibold">{{ $burial->createdBy->name ?? 'N/A' }}</div></div>
                @if($burial->notes)
                    <div class="col-span-2"><div class="text-muted text-sm">Notes</div><div class="font-semibold">{{ $burial->notes }}</div></div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-title">Deceased Details</span></div>
            <div class="p-6">
                @if($burial->deceased)
                    <div class="grid-2">
                        <div><div class="text-muted text-sm">Full Name</div><div class="font-semibold">{{ $burial->deceased->full_name }}</div></div>
                        <div><div class="text-muted text-sm">Age at Death</div><div class="font-semibold">{{ $burial->deceased->age }} years old</div></div>
                        <div><div class="text-muted text-sm">Birth Date</div><div class="font-semibold">{{ $burial->deceased->birth_date->format('F d, Y') }}</div></div>
                        <div><div class="text-muted text-sm">Death Date</div><div class="font-semibold">{{ $burial->deceased->death_date->format('F d, Y') }}</div></div>
                    </div>
                @else
                    <div class="text-muted">No deceased details found.</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>