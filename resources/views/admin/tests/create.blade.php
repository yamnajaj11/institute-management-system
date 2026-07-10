@extends('layouts.admin_app')

@section('title', __('admin.add_new_test'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('admin.add_new_test') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.tests.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="subject_id" class="form-label">{{ __('admin.subject') }}</label>
            <select class="form-control" id="subject_id" name="subject_id" required>
                <option value="">{{ __('admin.select_subject') }}</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('admin.test_name') }}</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="mb-3">
            <label for="test_date" class="form-label">{{ __('admin.test_date') }}</label>
            <input type="date" class="form-control" id="test_date" name="test_date">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
    </form>
</div>
@endsection
