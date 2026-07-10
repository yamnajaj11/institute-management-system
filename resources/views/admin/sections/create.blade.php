@extends('layouts.admin_app')

@section('title', __('admin.add_new_section'))

@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.add_new_section') }}</h1>
        <a href="{{ route('admin.sections.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
            <i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_list') }}
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            @if(session('error'))
                <div class="alert alert-danger rounded-pill shadow-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.sections.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">{{ __('admin.section_name') }}</label>
                    <input type="text" class="form-control rounded-pill @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="subject_id" class="form-label fw-bold">{{ __('admin.subject') }}</label>
                    <select class="form-control rounded-pill @error('subject_id') is-invalid @enderror" id="subject_id" name="subject_id" required>
                        <option value="">{{ __('admin.select_subject') }}</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="max_students" class="form-label fw-bold">{{ __('admin.max_students') }}</label>
                    <input type="number" class="form-control rounded-pill @error('max_students') is-invalid @enderror" id="max_students" name="max_students" value="{{ old('max_students', 0) }}" min="0" required>
                    @error('max_students')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
                        <i class="fas fa-save me-2"></i> {{ __('admin.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection