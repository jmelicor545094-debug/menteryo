<x-app-layout>
    <x-slot name="header">Edit Plot</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Edit Plot — {{ $plot->plot_number }}</span>
            <a href="{{ route('plots.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('plots.update', $plot) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Plot Number</label>
                    <input type="text" name="plot_number" value="{{ old('plot_number', $plot->plot_number) }}" class="form-control">
                    @error('plot_number')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" value="{{ old('section', $plot->section) }}" class="form-control">
                    @error('section')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        @foreach(['available','reserved','occupied'] as $s)
                            <option value="{{ $s }}" {{ old('status', $plot->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Price (₱)</label>
                    <input type="number" name="price" value="{{ old('price', $plot->price) }}" step="0.01" min="0" class="form-control">
                    @error('price')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('plots.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-accent">Update Plot</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>