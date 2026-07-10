@extends('layouts.admin_app')

@section('title', __('admin.apply_payment'))

@section('content')

<div class="container py-4">

<!-- Section: Page Header and Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.apply_payment_to') }} {{ $payment->student->name }}</h1>
    <a href="{{ route('admin.payments.index') }}" class="btn btn-lg btn-outline-secondary rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
        <i class="fas fa-arrow-left fa-sm me-2"></i>{{ __('admin.back') }}
    </a>
</div>

<!-- Section: Payment Details Card -->
<div class="card shadow-lg border-0 rounded-4 mb-4">
    <div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-4">
                <p class="text-muted mb-0 fw-bold">{{ __('admin.total_amount') }}</p>
                <h5 class="text-dark fw-bold mb-0">{{ $payment->total_amount }}</h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-0 fw-bold">{{ __('admin.paiding_amount') }}</p>
                <h5 class="text-success fw-bold mb-0">{{ $payment->paid_amount }}</h5>
            </div>
            <div class="col-md-4">
                <p class="text-muted mb-0 fw-bold">{{ __('admin.remaining_amount') }}</p>
                <h5 class="text-danger fw-bold mb-0">{{ $payment->remaining_amount }}</h5>
            </div>
        </div>
    </div>
</div>

<!-- Section: Apply Payment Form -->
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
        
        <form action="{{ route('admin.payments.processApply', $payment->id) }}" method="POST">
            @csrf
            
            <!-- New Amount Field -->
            <div class="mb-4">
                <label for="new_amount" class="form-label fw-bold">{{ __('admin.amount_to_pay') }}:</label>
                <input type="number" name="new_amount" id="new_amount" class="form-control form-control-lg rounded-3 @error('new_amount') is-invalid @enderror" placeholder="{{ __('admin.enter_new_amount') }}" step="0.01" required min="0.01" max="{{ $payment->remaining_amount }}">
                @error('new_amount')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- New Payment Date Field -->
            <div class="mb-4">
                <label for="payment_date" class="form-label fw-bold">{{ __('admin.payment_date') }}:</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control form-control-lg rounded-3 @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}" required>
                @error('payment_date')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Hidden fields for the existing payment -->
            <input type="hidden" name="payment_id" value="{{ $payment->id }}">

            <!-- Submit Button -->
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-save me-2"></i> {{ __('admin.apply_payment_button') }}
                </button>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
