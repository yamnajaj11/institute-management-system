@extends('layouts.admin_app')

@section('title', __('admin.add_student'))

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center fw-bold mb-4">{{ __('admin.add_student') }}</h2>

                    @if(Session::has('success'))
                        <div class="alert alert-success text-center mb-4" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.students.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-bold">{{ __('admin.student_id') }}</label>
                            <input type="text" name="student_id" id="student_id" class="form-control form-control-lg rounded-pill @error('student_id') is-invalid @enderror" value="{{ old('student_id') }}" required autocomplete="off" maxlength="255">
                            @error('student_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">{{ __('admin.student_name') }}</label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg rounded-pill @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="father_name" class="form-label fw-bold">{{ __('admin.father_name') }}</label>
                            <input type="text" name="father_name" id="father_name" class="form-control form-control-lg rounded-pill @error('father_name') is-invalid @enderror" value="{{ old('father_name') }}" required>
                            @error('father_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mother_name" class="form-label fw-bold">{{ __('admin.mother_name') }}</label>
                            <input type="text" name="mother_name" id="mother_name" class="form-control form-control-lg rounded-pill @error('mother_name') is-invalid @enderror" value="{{ old('mother_name') }}" required>
                            @error('mother_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold">{{ __('admin.address') }}</label>
                            <input type="text" name="address" id="address" class="form-control form-control-lg rounded-pill @error('address') is-invalid @enderror" value="{{ old('address') }}" required>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="form-label fw-bold">{{ __('admin.phone_number') }}</label>
                            <input type="tel" name="phone" id="phone" class="form-control form-control-lg rounded-pill @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">{{ __('admin.password') }}</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-bold">{{ __('admin.confirm_password') }}</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg rounded-pill" required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">{{ __('admin.gender') }}</label>
                            <div class="d-flex align-items-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" {{ old('gender') === 'male' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="male">{{ __('admin.male') }}</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female" {{ old('gender') === 'female' ? 'checked' : '' }} required>
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
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                            @error('courses')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">{{ __('admin.add_student_button') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection