<x-app-layout>
    <x-slot name="header">Add New Plot</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Plot Details</span>
            <a href="{{ route('plots.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('plots.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Plot Number</label>
                    <input type="text" name="plot_number" value="{{ old('plot_number') }}" class="form-control" placeholder="e.g. A-101">
                    @error('plot_number')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" value="{{ old('section') }}" class="form-control" placeholder="e.g. Section A">
                    @error('section')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                        <option value="reserved"  {{ old('status') === 'reserved'  ? 'selected' : '' }}>Reserved</option>
                        <option value="occupied"  {{ old('status') === 'occupied'  ? 'selected' : '' }}>Occupied</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" class="form-control" placeholder="e.g. 15000.00">
                    @error('price')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('plots.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Plot</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>