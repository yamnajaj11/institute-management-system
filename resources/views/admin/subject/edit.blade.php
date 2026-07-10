@extends('layouts.admin_app')

@section('title', __('admin.edit_subject'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('admin.edit_subject') }}</h1>

    <!-- عرض التنبيهات عند النجاح أو الخطأ -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('admin.subject_name') }}</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $subject->name }}" required>
        </div>



        <button type="submit" class="btn btn-primary">{{ __('admin.update_subject') }}</button>
    </form>
</div>
@endsection
