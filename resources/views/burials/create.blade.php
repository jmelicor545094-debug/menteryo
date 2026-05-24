<x-app-layout>
    <x-slot name="header">Add Burial Record</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Burial Details</span>
            <a href="{{ route('burials.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('burials.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Deceased</label>
                    <select name="deceased_id" class="form-control">
                        <option value="">— Select Deceased —</option>
                        @foreach($deceaseds as $deceased)
                            <option value="{{ $deceased->id }}" {{ old('deceased_id') == $deceased->id ? 'selected' : '' }}>{{ $deceased->full_name }}</option>
                        @endforeach
                    </select>
                    @error('deceased_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Plot</label>
                    <select name="plot_id" class="form-control">
                        <option value="">— Select Plot —</option>
                        @foreach($plots as $plot)
                            <option value="{{ $plot->id }}" {{ old('plot_id') == $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }} — {{ $plot->section }} ({{ ucfirst($plot->status) }}){{ $plot->owners->isNotEmpty() ? ' — Owner: ' . $plot->owners->pluck('full_name')->join(', ') : '' }}</option>
                        @endforeach
                    </select>
                    @error('plot_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Burial Date</label>
                    <input type="date" name="burial_date" value="{{ old('burial_date') }}" class="form-control">
                    @error('burial_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Notes <span>(optional)</span></label>
                    <textarea name="notes" rows="3" class="form-control" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
                    @error('notes')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('burials.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Burial</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>