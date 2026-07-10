@extends('layouts.admin_app')

@section('title', __('admin.edit_final_exam_mark'))

@section('content')

<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.edit_final_exam_mark') }}</h1>
<a href="{{ route('admin.final_exam_marks.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
<i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_list') }}
</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger rounded-pill shadow-sm mb-4">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.final_exam_marks.update', $mark->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Student -->
            <div class="mb-4">
                <label for="student_id" class="form-label fw-bold">{{ __('admin.student') }}</label>
                <select name="student_id" id="student_id" class="form-select rounded-pill shadow-sm" required>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @if($student->id == $mark->student_id) selected @endif>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Subject -->
            <div class="mb-4">
                <label for="subject_id" class="form-label fw-bold">{{ __('admin.subject') }}</label>
                <select name="subject_id" id="subject_id" class="form-select rounded-pill shadow-sm" required>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" @if($subject->id == $mark->subject_id) selected @endif>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Mark -->
            <div class="mb-4">
                <label for="mark" class="form-label fw-bold">{{ __('admin.mark') }}</label>
                <input type="number" name="mark" id="mark" class="form-control rounded-pill shadow-sm" value="{{ old('mark', $mark->mark) }}" required>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-warning fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
                    <i class="fas fa-save me-2"></i> {{ __('admin.update') }}
                </button>
            </div>
        </form>
    </div>
</div>

</div>

@endsection