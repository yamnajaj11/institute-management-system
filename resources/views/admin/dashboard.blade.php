@extends('layouts.admin_app')

@section('title', __('messages.dashboard_title'))

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="card bg-light shadow-sm border-0">
                <div class="card-body">
                    <h1 class="card-title text-center">{{ __('messages.welcome_message') }}</h1>
                    <p class="text-center text-muted">{{ __('messages.welcome_info') }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h3 class="card-title mb-3">{{ __('messages.overview_title') }}</h3>
                    <img src="https://placehold.co/800x400/E5E7EB/4B5563?text=لوحة+التحكم" class="img-fluid rounded mb-4" alt="لوحة تحكم النظام">
                    <p class="text-muted">{{ __('messages.overview_text') }}</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

