@extends('layouts.admin_app')

@section('title', __('admin.edit_payment'))

@section('content')

<div class="container py-4">
    <!-- Page Header and Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.edit_payment') }}</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-lg btn-outline-secondary rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
            <i class="fas fa-arrow-left fa-sm me-2"></i>{{ __('admin.back') }}
        </a>
    </div>

    <!-- Form Card -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            @if ($errors->any())
                <div class="alert alert-danger rounded-4 shadow-sm mb-4">
                    <ul class="mb-0 list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Student Select Field -->
                <div class="mb-4">
                    <label for="student_id" class="form-label fw-bold">{{ __('admin.student_name') }}:</label>
                    <select name="student_id" id="student_id" class="form-select form-select-lg rounded-3 @error('student_id') is-invalid @enderror" required>
                        <option value="">-- {{ __('admin.select_student') }} --</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id', $payment->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Total Amount Field -->
                <div class="mb-4">
                    <label for="total_amount" class="form-label fw-bold">{{ __('admin.total_amount') }}:</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control form-control-lg rounded-3 bg-light @error('total_amount') is-invalid @enderror" placeholder="{{ __('admin.enter_total_amount') }}" value="{{ old('total_amount', $payment->total_amount) }}" step="0.01" required min="0.01" readonly>
                    @error('total_amount')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Paid Amount Field -->
                <div class="mb-4">
                    <label for="paid_amount" class="form-label fw-bold">{{ __('admin.paid_amount') }}:</label>
                    <input type="number" name="paid_amount" id="paid_amount" class="form-control form-control-lg rounded-3 @error('paid_amount') is-invalid @enderror" placeholder="{{ __('admin.enter_paid_amount') }}" value="{{ old('paid_amount', $payment->paid_amount) }}" step="0.01" min="0">
                    @error('paid_amount')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remaining Amount Field -->
                <div class="mb-4">
                    <label for="remaining_amount" class="form-label fw-bold">{{ __('admin.remaining_amount') }}:</label>
                    <input type="text" id="remaining_amount" class="form-control form-control-lg rounded-3 bg-light" value="{{ $payment->total_amount - $payment->paid_amount }}" readonly>
                </div>
                
                <!-- Payment Date Field -->
                <div class="mb-4">
                    <label for="payment_date" class="form-label fw-bold">{{ __('admin.payment_date') }}:</label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control form-control-lg rounded-3 @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '') }}" required>
                    @error('payment_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Due Date Field -->
                <div class="mb-4">
                    <label for="due_date" class="form-label fw-bold">{{ __('admin.due_date') }}:</label>
                    <input type="date" name="due_date" id="due_date" class="form-control form-control-lg rounded-3 @error('due_date') is-invalid @enderror" value="{{ old('due_date', $payment->due_date ? \Carbon\Carbon::parse($payment->due_date)->format('Y-m-d') : '') }}" required>
                    @error('due_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Field -->
                <div class="mb-4">
                    <label for="status" class="form-label fw-bold">{{ __('admin.status') }}:</label>
                    <select name="status" id="status" class="form-select form-select-lg rounded-3 @error('status') is-invalid @enderror" required>
                        <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>{{ __('admin.pending') }}</option>
                        <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>{{ __('admin.paid') }}</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Notes Field -->
                <div class="mb-4">
                    <label for="notes" class="form-label fw-bold">{{ __('admin.notes') }}:</label>
                    <textarea name="notes" id="notes" class="form-control form-control-lg rounded-3 @error('notes') is-invalid @enderror" rows="3" placeholder="{{ __('admin.add_notes_here') }}">{{ old('notes', $payment->notes) }}</textarea>
                    @error('notes')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between gap-3 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold w-50 shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                        <i class="fas fa-save me-2"></i> {{ __('admin.save_changes') }}
                    </button>
                    <button type="button" class="btn btn-danger btn-lg rounded-pill fw-bold w-50 shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash-alt me-2"></i> {{ __('admin.delete_payment') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4 rounded-4">
            <div class="modal-body">
                <div class="text-5xl text-danger mb-4">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-2xl font-bold mb-2">{{ __('admin.are_you_sure') }}</h2>
                <p class="text-gray-600 mb-4">{{ __('admin.delete_confirmation_text') }}</p>
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <button type="button" class="btn btn-secondary fw-bold rounded-pill" data-bs-dismiss="modal">{{ __('admin.cancel') }}</button>
                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger fw-bold rounded-pill">{{ __('admin.yes_delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const totalAmountInput = document.getElementById('total_amount');
        const paidAmountInput = document.getElementById('paid_amount');
        const remainingAmountInput = document.getElementById('remaining_amount');

        function calculateRemaining() {
            const total = parseFloat(totalAmountInput.value) || 0;
            const paid = parseFloat(paidAmountInput.value) || 0;
            const remaining = total - paid;
            
            remainingAmountInput.value = remaining.toFixed(2);
        }

        paidAmountInput.addEventListener('input', calculateRemaining);
        calculateRemaining(); // Initial calculation on page load
    });
</script>

@endsection
