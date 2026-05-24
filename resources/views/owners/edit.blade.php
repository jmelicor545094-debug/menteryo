<x-app-layout>
    <x-slot name="header">Edit Owner</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Edit — {{ $owner->full_name }}</span>
            <a href="{{ route('owners.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('owners.update', $owner) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $owner->full_name) }}" class="form-control">
                    @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Number</label>
                    <input type="text" name="contact_number" value="{{ old('contact_number', $owner->contact_number) }}" class="form-control">
                    @error('contact_number')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <textarea name="address" rows="3" class="form-control">{{ old('address', $owner->address) }}</textarea>
                    @error('address')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                @if($plots->count())
                <div class="form-group">
                    <label class="form-label">Assign Plot(s) <span>(optional)</span></label>
                    <div style="border:1px solid var(--border);border-radius:8px;padding:12px;max-height:180px;overflow-y:auto;">
                        @foreach($plots as $plot)
                            <label style="display:flex;align-items:center;gap:8px;padding:6px 0;font-size:14px;cursor:pointer;">
                                <input type="checkbox" name="plot_ids[]" value="{{ $plot->id }}" {{ in_array($plot->id, old('plot_ids', $assignedPlotIds)) ? 'checked' : '' }}>
                                {{ $plot->plot_number }} — {{ $plot->section }} <span class="text-muted">({{ ucfirst($plot->status) }})</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('owners.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-accent">Update Owner</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>