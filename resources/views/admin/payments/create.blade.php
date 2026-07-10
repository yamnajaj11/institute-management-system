@extends('layouts.admin_app')

@section('title', __('admin.add_new_payment'))

@section('content')
<div class="container py-4">
    <!-- عنوان الصفحة وزر الرجوع -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.add_new_payment') }}</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-lg btn-outline-secondary rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
            <i class="fas fa-arrow-left fa-sm me-2"></i>{{ __('admin.back') }}
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


    <!-- بطاقة النموذج -->
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
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                
                <!-- حقل اختيار المستخدم -->
                <div class="mb-4">
                    <label for="student_id" class="form-label fw-bold">{{ __('admin.user_name') }}:</label>
                    <select name="student_id" id="student_id" class="form-select form-select-lg rounded-3 @error('student_id') is-invalid @enderror" required>
                        <option value="">-- {{ __('admin.select_user') }} --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- حقل المبلغ الإجمالي -->
                <div class="mb-4">
                    <label for="total_amount" class="form-label fw-bold">{{ __('admin.total_amount') }}:</label>
                    <input type="number" name="total_amount" id="total_amount" class="form-control form-control-lg rounded-3 @error('total_amount') is-invalid @enderror" placeholder="{{ __('admin.enter_total_amount') }}" step="0.01" required min="0.01">
                    @error('total_amount')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- حقل المبلغ المدفوع -->
                <div class="mb-4">
                    <label for="paid_amount" class="form-label fw-bold">{{ __('admin.paid_amount') }}:</label>
                    <input type="number" name="paid_amount" id="paid_amount" class="form-control form-control-lg rounded-3 @error('paid_amount') is-invalid @enderror" placeholder="{{ __('admin.enter_paid_amount') }}" step="0.01" min="0">
                    @error('paid_amount')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- حقل تاريخ الدفعة -->
                <div class="mb-4">
                    <label for="payment_date" class="form-label fw-bold">{{ __('admin.payment_date') }}:</label>
                    <input type="date" name="payment_date" id="payment_date" class="form-control form-control-lg rounded-3 @error('payment_date') is-invalid @enderror" required>
                    @error('payment_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- حقل تاريخ الاستحقاق -->
                <div class="mb-4">
                    <label for="due_date" class="form-label fw-bold">{{ __('admin.due_date') }}:</label>
                    <input type="date" name="due_date" id="due_date" class="form-control form-control-lg rounded-3 @error('due_date') is-invalid @enderror" required>
                    @error('due_date')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- حقل الحالة -->
                <div class="mb-4">
                    <label for="status" class="form-label fw-bold">{{ __('admin.status') }}:</label>
                    <select name="status" id="status" class="form-select form-select-lg rounded-3 @error('status') is-invalid @enderror" required>
                        <option value="pending">{{ __('admin.pending') }}</option>
                        <option value="paid">{{ __('admin.paid') }}</option>
                    </select>
                    @error('status')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- حقل الملاحظات -->
                <div class="mb-4">
                    <label for="notes" class="form-label fw-bold">{{ __('admin.notes') }}:</label>
                    <textarea name="notes" id="notes" class="form-control form-control-lg rounded-3 @error('notes') is-invalid @enderror" rows="3" placeholder="{{ __('admin.add_notes_here') }}"></textarea>
                    @error('notes')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold w-100 shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
                    {{ __('admin.add_new_payment') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
