@extends('layouts.admin_app')

@section('title', __('admin.payment_history'))

@section('content')
<div class="container py-4">
    <!-- عنوان الصفحة وزر العودة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.payment_history') }}</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-lg btn-secondary rounded-pill fw-bold shadow-sm transition-transform duration-300 hover:scale-105 hover:shadow-lg">
            <i class="fas fa-arrow-left fa-sm me-2"></i>{{ __('admin.back_to_list') }}
        </a>
    </div>

    <!-- معلومات الدفعة الرئيسية -->
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body p-5">
            <h4 class="fw-bold mb-3 text-primary">{{ __('admin.payment_summary') }}</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.student_name') }}:</strong>
                    <span class="text-muted">{{ $payment->student->name ?? 'N/A' }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.total_amount') }}:</strong>
                    <span class="text-muted">{{ $payment->total_amount }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.paiding_amount') }}:</strong>
                    <span class="text-success fw-bold">{{ $payment->paid_amount }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.remaining_amount') }}:</strong>
                    <span class="text-danger fw-bold">{{ $payment->remaining_amount }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.due_date') }}:</strong>
                    <span class="text-muted">{{ \Carbon\Carbon::parse($payment->due_date)->format('Y-m-d') }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>{{ __('admin.status') }}:</strong>
                    @if($payment->status === 'paid')
                        <span class="badge bg-success">{{ __('admin.paid') }}</span>
                    @elseif($payment->status === 'pending')
                        <span class="badge bg-warning text-dark">{{ __('admin.pending') }}</span>
                    @else
                        <span class="badge bg-danger">{{ __('admin.overdue') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- سجل الدفعات الجزئية -->
    <h2 class="h4 mb-3 fw-bold">{{ __('admin.partial_payments_history') }}</h2>
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead class="bg-light text-muted">
                        <tr class="text-uppercase fw-bold">
                            <th scope="col" class="py-3 px-4">{{ __('admin.amount_paid') }}</th>
                            <th scope="col" class="py-3 px-4">{{ __('admin.payment_date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- عرض الدفعة الأساسية (الدفعة الأولى) --}}
                        <tr class="align-middle">
                            <td class="py-3 px-4">{{ $payment->paid_amount }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($payment->created_at)->format('Y-m-d') }}</td>
                        </tr>

                        {{-- عرض الدفعات الجزئية المضافة لاحقاً --}}
                        @forelse($payment->details as $detail)
                            <tr class="align-middle">
                                <td class="py-3 px-4">{{ $detail->amount }}</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($detail->payment_date)->format('Y-m-d') }}</td>
                            </tr>
                        @empty
                            {{-- لا تظهر رسالة لأن الدفعة الأساسية موجودة --}}
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
