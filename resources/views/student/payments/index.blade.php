@extends('layouts.students.student-layout')

@section('title', __('dashboard.payments_link'))

@section('student_content')
<div class="container-xl py-5">
    <h2 class="mb-4 fs-1">{{ __('dashboard.payments_link') }}</h2>

    @if($payments->isEmpty())
        <div class="alert alert-info fs-5">{{ __('dashboard.no_payments_found') }}</div>
    @else
        @foreach($payments as $payment)
            <div class="card mb-5 shadow-sm">
                <div class="card-header bg-primary text-white fs-5">
                    {{ __('dashboard.payment_due_date') }}: 
                    {{ $payment->due_date ? $payment->due_date->format('Y-m-d') : '-' }}
                </div>
                <div class="card-body fs-5">
                    <p><strong>{{ __('dashboard.total_amount') }}:</strong> {{ number_format($payment->total_amount, 2) }} {{ __('dashboard.currency') }}</p>
                    <p><strong>{{ __('dashboard.paid_amount') }}:</strong> {{ number_format($payment->paid_amount, 2) }} {{ __('dashboard.currency') }}</p>
                    <p><strong>{{ __('dashboard.remaining_amount') }}:</strong> {{ number_format($payment->remaining_amount, 2) }} {{ __('dashboard.currency') }}</p>
                    <p><strong>{{ __('dashboard.status') }}:</strong> 
                        @if($payment->status == 'paid')
                            <span class="badge bg-success fs-6">{{ __('dashboard.paid') }}</span>
                        @else
                            <span class="badge bg-warning text-dark fs-6">{{ __('dashboard.pending') }}</span>
                        @endif
                    </p>

                    <h5 class="mt-4">{{ __('dashboard.payment_details') }}:</h5>
                    @if($payment->details->isEmpty())
                        <p>{{ __('dashboard.no_payment_details') }}</p>
                    @else
                        <ul class="fs-5">
                            @foreach($payment->details as $detail)
                                <li>
                                    {{ __('dashboard.amount') }}: {{ number_format($detail->amount, 2) }} {{ __('dashboard.currency') }} ,
                                    {{ __('dashboard.payment_date') }}: 
                                    {{ $detail->payment_date ? \Carbon\Carbon::parse($detail->payment_date)->format('Y-m-d') : '-' }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
