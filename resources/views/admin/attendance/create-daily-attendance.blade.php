@extends('layouts.admin_app')

@section('title', __('admin.collective_attendance_registration'))

@section('content')

<style>
/* ... Your existing CSS styles ... */
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center fw-bold mb-5 text-gray-800">{{ __('admin.collective_attendance_registration') }}</h2>

                    @if(session('success'))
                        <div class="alert alert-success text-center fw-bold rounded-3 mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger text-center fw-bold rounded-3 mb-4" role="alert">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div class="row g-2 align-items-center mb-4">
                        <div class="col-md">
                            <form action="{{ route('admin.attendances.create') }}" method="GET" class="d-flex align-items-center flex-wrap">
                                <div class="input-group rounded-pill shadow-sm overflow-hidden me-2 mb-2" style="max-width: 250px;">
                                    <span class="input-group-text bg-white border-0">{{ __('admin.course_name') }}</span>
                                    <select name="course_id" id="course-select" class="form-select border-0 ps-2">
                                        <option value="all" @if(request('course_id') === 'all' || !request('course_id')) selected @endif>{{ __('admin.all_courses') }}</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" @if(request('course_id') == $course->id) selected @endif>{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(request('search'))
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                @endif
                                <button type="submit" class="btn btn-primary px-4 transition-transform duration-300 hover:scale-105 rounded-pill shadow-sm">
                                    <i class="fas fa-filter me-2"></i> {{ __('admin.apply') }}
                                </button>
                            </form>
                        </div>

                        <div class="col-md-auto ms-auto">
                            <form action="{{ route('admin.attendances.create') }}" method="GET">
                                <div class="input-group rounded-pill shadow-sm overflow-hidden transition-all duration-300">
                                    <input type="text" name="search" id="search-input" class="form-control border-0 ps-4" placeholder="{{ __('admin.search_placeholder_attendance') }}" aria-label="{{ __('admin.search_by_name_id') }}" value="{{ request('search') }}">
                                    @if(request('course_id'))
                                        <input type="hidden" name="course_id" value="{{ request('course_id') }}">
                                    @endif
                                    <button type="submit" class="btn btn-primary px-4 transition-transform duration-300 hover:scale-105">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <form action="{{ route('admin.attendances.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="date" class="form-label fw-semibold">{{ __('admin.select_date') }}</label>
                            <input type="date" name="date" id="date" class="form-control rounded-pill shadow-sm" required value="{{ old('date', now()->format('Y-m-d')) }}">
                            @error('date')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card p-4 rounded-4 shadow-sm">
                            <h3 class="fs-5 fw-semibold text-gray-700 mb-4">{{ __('admin.students_list') }}</h3>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead class="bg-dark text-white">
                                        <tr>
                                            <th scope="col" class="text-end">{{ __('admin.student_id') }}</th>
                                            <th scope="col" class="text-end">{{ __('admin.student_name') }}</th>
                                            <th scope="col" class="text-center">{{ __('admin.present') }}</th>
                                            <th scope="col" class="text-center">{{ __('admin.absent') }}</th>
                                            <th scope="col" class="text-center">{{ __('admin.late') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($students as $student)
                                            <tr>
                                                <td class="text-end py-3">{{ $student->student_id }}</td>
                                                <td class="text-end py-3">{{ $student->name }}</td>
                                                <td class="text-center py-3">
                                                    <div class="form-check d-inline-block">
                                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="present" id="present_{{ $student->id }}" required>
                                                        <label class="form-check-label" for="present_{{ $student->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center py-3">
                                                    <div class="form-check d-inline-block">
                                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="absent" id="absent_{{ $student->id }}" required>
                                                        <label class="form-check-label" for="absent_{{ $student->id }}"></label>
                                                    </div>
                                                </td>
                                                <td class="text-center py-3">
                                                    <div class="form-check d-inline-block">
                                                        <input class="form-check-input" type="radio" name="attendance[{{ $student->id }}][status]" value="late" id="late_{{ $student->id }}" required>
                                                        <label class="form-check-label" for="late_{{ $student->id }}"></label>
                                                    </div>
                                                </td>
                                                <input type="hidden" name="attendance[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted py-4">
                                                    {{ __('admin.no_students_available') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-lg rounded-pill btn-primary-custom">{{ __('admin.save_attendance') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection