@extends('layouts.admin_app')

@section('title', __('admin.all_payments'))

@section('content')

<div class="container py-4">

    <!-- رأس الصفحة وزر الإضافة -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.all_payments') }}</h1>
        <a href="{{ route('admin.payments.create') }}" class="btn btn-lg btn-primary rounded-pill fw-bold shadow-sm">
            <i class="fas fa-plus fa-sm me-2"></i>{{ __('admin.add_new_payment') }}
        </a>
    </div>

    <!-- التنبيهات -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- قائمة الدفعات -->
    <ul class="list-group shadow rounded-4">
        @forelse($payments as $payment)
            <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 py-3 px-4">
                <div class="flex-grow-1">
                    <h5 class="mb-1">
                        <a href="{{ route('admin.students.show', $payment->student->id) }}" class="text-decoration-none text-primary fw-bold">
                            {{ $payment->student->name }}
                        </a>
                    </h5>
                    <div class="d-flex flex-wrap gap-3 text-muted small">
                        <div><strong>{{ __('admin.total_amount') }}:</strong> {{ $payment->total_amount }}</div>
                        <div><strong>{{ __('admin.paiding_amount') }}:</strong> <span class="text-success fw-bold">{{ $payment->paid_amount }}</span></div>
                        <div><strong>{{ __('admin.remaining_amount') }}:</strong> 
                            <span class="@if($payment->remaining_amount <= 0) text-success @else text-danger @endif fw-bold">
                                {{ $payment->remaining_amount }}
                            </span>
                        </div>
                        <div><strong>{{ __('admin.due_date') }}:</strong> {{ \Carbon\Carbon::parse($payment->due_date)->format('Y-m-d') }}</div>
                        <div><strong>{{ __('admin.status') }}:</strong> 
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

                <div class="d-flex gap-2 mt-3 mt-md-0 flex-wrap">
                    <a href="{{ route('admin.payments.history', $payment->id) }}" class="btn btn-sm btn-outline-info rounded-pill" title="{{ __('admin.view_history') }}">
                        <i class="fas fa-history fa-xs"></i>
                    </a>
                    @if($payment->remaining_amount > 0)
                        <a href="{{ route('admin.payments.apply', $payment->id) }}" class="btn btn-sm btn-outline-success rounded-pill" title="{{ __('admin.apply_payment') }}">
                            <i class="fas fa-money-bill-alt fa-xs"></i>
                        </a>
                    @endif
                    <a href="{{ route('admin.payments.edit', $payment->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="{{ __('admin.edit_payment') }}">
                        <i class="fas fa-edit fa-xs"></i>
                    </a>
                    <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟');"></form>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill" title="{{ __('admin.delete_payment') }}">
                            <i class="fas fa-trash-alt fa-xs"></i>
                        </button>
                    </form>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center text-muted py-5">
                <i class="fas fa-exclamation-circle fa-3x mb-3"></i>
                <p class="fs-5">{{ __('admin.no_payments_found') }}</p>
            </li>
        @endforelse
    </ul>

</div>

@endsection
