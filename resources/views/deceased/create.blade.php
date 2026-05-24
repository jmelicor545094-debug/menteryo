<x-app-layout>
    <x-slot name="header">Add Deceased Record</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Deceased Details</span>
            <a href="{{ route('deceased.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('deceased.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="form-control" placeholder="e.g. Maria Santos">
                    @error('full_name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Birth Date</label>
                    <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
                    @error('birth_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Death Date</label>
                    <input type="date" name="death_date" value="{{ old('death_date') }}" class="form-control">
                    @error('death_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="flex gap-2 justify-end">
                    <a href="{{ route('deceased.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>