@extends('layouts.admin_app')

@section('title', __('admin.edit_attendance'))

@section('content')
<style>
/* ... your existing CSS styles ... */
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center fw-bold mb-5 text-gray-800">{{ __('admin.edit_attendance') }}</h2>
                    <p class="text-center text-muted mb-4">
                        {{ __('admin.editing_record_for_student') }}
                        <span class="fw-bold">{{ $attendance->student->name }}</span> ({{ $attendance->student->student_id }})
                        {{ __('admin.on_date') }}
                        <span class="fw-bold">{{ $attendance->date }}</span>
                    </p>

                    @if($errors->any())
                        <div class="alert alert-danger text-center fw-bold rounded-3 mb-4" role="alert">
                            {{ __('admin.error_in_form') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.attendances.update', $attendance->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card p-4 rounded-4 shadow-sm mb-4">
                            <div class="row text-center d-flex justify-content-center">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="present" id="present" 
                                               {{ $attendance->status == 'present' ? 'checked' : '' }} required>
                                        <label class="form-check-label fw-semibold" for="present">
                                            {{ __('admin.present') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="absent" id="absent"
                                               {{ $attendance->status == 'absent' ? 'checked' : '' }} required>
                                        <label class="form-check-label fw-semibold" for="absent">
                                            {{ __('admin.absent') }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" value="late" id="late"
                                               {{ $attendance->status == 'late' ? 'checked' : '' }} required>
                                        <label class="form-check-label fw-semibold" for="late">
                                            {{ __('admin.late') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-lg rounded-pill btn-primary-custom">
                                {{ __('admin.save_changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection