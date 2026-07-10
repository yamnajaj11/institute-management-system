@extends('layouts.admin_app')

@section('title', __('admin.add_new_subject'))

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ __('admin.add_new_subject') }}</h1>

    <!-- عرض التنبيهات عند النجاح أو الخطأ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-lg p-4">
        <div class="card-body">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('admin.subject_name') }}</label>
                    <input type="text" class="form-control shadow-sm" id="name" name="name" required placeholder="{{ __('admin.enter_subject_name') }}">
                </div>

         
               
                <button type="submit" class="btn btn-primary w-100 shadow-sm">{{ __('admin.add_subject') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
