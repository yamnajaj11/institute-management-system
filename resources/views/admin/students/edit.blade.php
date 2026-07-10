@extends('layouts.admin_app')

@section('title', __('admin.edit_student'))

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.edit_student') }}</h1>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
            <i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_list') }}
        </a>
    </div>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4 p-md-5">
            <h5 class="card-title fw-bold mb-3">{{ __('admin.edit_student') }}</h5>
            
            @if ($errors->any())
                <div class="alert alert-danger rounded-pill shadow-sm mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="student_id" class="form-label fw-bold">{{ __('admin.student_id') }}</label>
                    <input type="text" name="student_id" id="student_id" class="form-control form-control-lg rounded-pill @error('student_id') is-invalid @enderror" value="{{ old('student_id', $student->student_id) }}" required autocomplete="off" maxlength="255">
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">{{ __('admin.student_name') }}</label>
                    <input type="text" name="name" id="name" class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror" value="{{ old('name', $student->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="father_name" class="form-label fw-bold">{{ __('admin.father_name') }}</label>
                    <input type="text" name="father_name" id="father_name" class="form-control form-control-lg rounded-pill @error('father_name') is-invalid @enderror" value="{{ old('father_name', $student->father_name) }}" required>
                    @error('father_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="mother_name" class="form-label fw-bold">{{ __('admin.mother_name') }}</label>
                    <input type="text" name="mother_name" id="mother_name" class="form-control form-control-lg rounded-pill @error('mother_name') is-invalid @enderror" value="{{ old('mother_name', $student->mother_name) }}" required>
                    @error('mother_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="address" class="form-label fw-bold">{{ __('admin.address') }}</label>
                    <input type="text" name="address" id="address" class="form-control form-control-lg rounded-pill @error('address') is-invalid @enderror" value="{{ old('address', $student->address) }}" required>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label fw-bold">{{ __('admin.phone_number') }}</label>
                    <input type="tel" name="phone" id="phone" class="form-control form-control-lg rounded-pill @error('phone') is-invalid @enderror" value="{{ old('phone', $student->phone) }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-bold">{{ __('admin.gender') }}</label>
                    <div class="d-flex align-items-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender', $student->gender) === 'male' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="male">{{ __('admin.male') }}</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender', $student->gender) === 'female' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="female">{{ __('admin.female') }}</label>
                        </div>
                    </div>
                    @error('gender')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="courses" class="form-label fw-bold">{{ __('admin.courses') }}</label>
                    <select name="courses" id="courses" class="form-select form-select-lg **rounded-pill** @error('courses') is-invalid @enderror">
                        <option value="" disabled selected>{{ __('admin.select_courses') }}</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $student->courses->contains($course->id) ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('courses')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill">{{ __('admin.update_student') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection