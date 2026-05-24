<x-app-layout>
    <x-slot name="header">Edit Payment</x-slot>

    <div class="card" style="max-width:640px;">
        <div class="card-header">
            <span class="card-title">Edit Payment</span>
            <a href="{{ route('payments.index') }}" class="btn btn-outline btn-sm">← Back</a>
        </div>
        <div class="p-6">
            <form action="{{ route('payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Owner</label>
                    <select name="owner_id" class="form-control">
                        <option value="">— Select Owner —</option>
                        @foreach($owners as $owner)
                            <option value="{{ $owner->id }}" {{ old('owner_id', $payment->owner_id) == $owner->id ? 'selected' : '' }}>{{ $owner->full_name }}</option>
                        @endforeach
                    </select>
                    @error('owner_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Plot</label>
                    <select name="plot_id" id="plot_id" class="form-control">
                        <option value="" data-price="">— Select Plot —</option>
                        @foreach($plots as $plot)
                            <option value="{{ $plot->id }}" data-price="{{ $plot->price }}" {{ old('plot_id', $payment->plot_id) == $plot->id ? 'selected' : '' }}>{{ $plot->plot_number }} — {{ $plot->section }} ({{ ucfirst($plot->status) }}) — ₱{{ number_format($plot->price, 2) }}{{ $plot->owners->isNotEmpty() ? ' — Owner: ' . $plot->owners->pluck('full_name')->join(', ') : '' }}</option>
                        @endforeach
                    </select>

                    @error('plot_id')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Amount (₱)</label>
                    <input type="number" name="amount" value="{{ old('amount', $payment->amount) }}" step="any" min="0.01" class="form-control">
                    @error('amount')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Method</label>
                    <select name="payment_method" class="form-control">
                        @foreach(['cash','gcash','bank_transfer','check'] as $method)
                            <option value="{{ $method }}" {{ old('payment_method', $payment->payment_method) === $method ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$method)) }}</option>
                        @endforeach
                    </select>
                    @error('payment_method')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" value="{{ old('payment_date', $payment->payment_date->format('Y-m-d')) }}" class="form-control">
                    @error('payment_date')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        @foreach(['pending','paid'] as $s)
                            <option value="{{ $s }}" {{ old('status', $payment->status) === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('payments.index') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-accent">Update Payment</button>
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
        });
    </script>
</x-app-layout>