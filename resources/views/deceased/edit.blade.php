<x-app-layout>
    <x-slot name="header">Edit Deceased Record</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Edit — {{ $deceased->full_name }}</span>
            <a href="{{ route('deceased.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('deceased.update', $deceased) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $deceased->full_name) }}" class="form-control">
                    @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date', $deceased->birth_date->format('Y-m-d')) }}" class="form-control">
                    @error('birth_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Death Date</label>
                    <input type="date" name="death_date" value="{{ old('death_date', $deceased->death_date->format('Y-m-d')) }}" class="form-control">
                    @error('death_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-2 justify-end">
                    <a href="{{ route('deceased.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-accent">Update Record</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>