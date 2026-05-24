<x-app-layout>
    <x-slot name="header">Add Payment</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Payment Details</span>
            <a href="{{ route('payments.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Owner</label>
                    <select name="owner_id" class="form-control">
                        <option value="">— Select Owner —</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id') == $owner->id ? 'selected' : '' }}>{{ $owner->full_name }}</option>
                        @endforeach
                    </select>
                    @error('owner_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Plot</label>
                    <select name="plot_id" id="plot_id" class="form-control">
                        <option value="" data-price="">— Select Plot —</option>
                        @foreach($plots as $plot)
                            <option value="{{ $plot->id }}" data-price="{{ $plot->price }}" {{ old('plot_id') == $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }} — {{ $plot->section }} ({{ ucfirst($plot->status) }}) — ₱{{ number_format($plot->price, 2) }}{{ $plot->owners->isNotEmpty() ? ' — Owner: ' . $plot->owners->pluck('full_name')->join(', ') : '' }}</option>
                        @endforeach
                    </select>

                    @error('plot_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Amount (₱)</label>
                    <input type="number" name="amount" value="{{ old('amount') }}" step="any" min="0.01" class="form-control" placeholder="e.g. 5000.00">
                    @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        <option value="">— Select Method —</option>
                        <option value="cash"          {{ old('payment_method') === 'cash'          ? 'selected' : '' }}>Cash</option>
                        <option value="gcash"         {{ old('payment_method') === 'gcash'         ? 'selected' : '' }}>GCash</option>
                        <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="check"         {{ old('payment_method') === 'check'         ? 'selected' : '' }}>Check</option>
                    </select>
                    @error('payment_method')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date') }}" class="form-control">
                    @error('payment_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid"    {{ old('status') === 'paid'    ? 'selected' : '' }}>Paid</option>
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('payments.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Payment</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const plotSelect = document.getElementById('plot_id');
            const amountInput = document.querySelector('input[name="amount"]');

            plotSelect.addEventListener('change', function () {
                const selected = plotSelect.options[plotSelect.selectedIndex];
                const price = selected ? selected.getAttribute('data-price') : '';
                if (price) {
                    amountInput.value = price;
                }
            });

            // Pre-fill on load if a plot is already selected
            if (plotSelect.value && !amountInput.value) {
                const selected = plotSelect.options[plotSelect.selectedIndex];
                const price = selected ? selected.getAttribute('data-price') : '';
                if (price) amountInput.value = price;
            }
        });
    </script>
</x-app-layout>