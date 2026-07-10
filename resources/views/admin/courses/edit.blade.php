@extends('layouts.admin_app')

@section('title', __('admin.edit_course') . ': ' . $course->name)

@section('content')

<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.edit_course') }}: {{ $course->name }}</h1>
<a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill shadow-sm">
<i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_list') }}
</a>
</div>

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-bold">{{ __('admin.course_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill shadow-sm" value="{{ old('name', $course->name) }}" required>
                    @error('name')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

          
                
                <div class="col-md-6">
                    <label for="subjects" class="form-label fw-bold">{{ __('admin.subjects') }}</label>
                    <select name="subjects[]" id="subjects" multiple class="form-select rounded-4 shadow-sm" size="5">
                        @php
                            $currentSubjectIds = $course->subjects->pluck('id')->toArray();
                        @endphp
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ in_array($subject->id, old('subjects', $currentSubjectIds)) ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">{{ __('admin.multiple_subjects_tip') }}</small>
                    @error('subjects')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4 text-end">
                    <button type="submit" class="btn btn-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:scale-105">
                        <i class="fas fa-save me-2"></i> {{ __('admin.save_changes') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>
@endsection