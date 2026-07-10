@extends('layouts.students.student-layout')

@section('title', __('dashboard.attendance_title'))

@section('student_content')
<div class="container-xl py-5 px-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg rounded-xl overflow-hidden border border-gray-200">
                <div class="card-body p-5 bg-white">
                    <h3 class="card-title text-center text-primary-600 mb-5 fs-2 fw-bold">
                        {{ __('dashboard.attendance_schedule') }}
                    </h3>
                    <div class="table-responsive">
                        @if(count($attendances) > 0)
                        <table class="table table-striped table-hover align-middle border-collapse w-100">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th scope="col" class="py-3 px-4 text-center fs-5 fw-semibold rounded-top-start">
                                        {{ __('dashboard.date') }}
                                    </th>
                                    <th scope="col" class="py-3 px-4 text-center fs-5 fw-semibold rounded-top-end">
                                        {{ __('dashboard.status') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $attendance)
                                <tr class="border-bottom hover-bg-light">
                                    <td class="py-3 px-4 text-center fs-6 text-secondary">
                                        {{ $attendance['date'] }}
                                    </td>
                                    <td class="py-3 px-4 text-center fs-6">
                                        @if($attendance['status'] === 'present')
                                            <span class="badge bg-success px-3 py-1.5 rounded-pill fs-6">{{ __('dashboard.present') }}</span>
                                        @elseif($attendance['status'] === 'late')
                                            <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fs-6">{{ __('dashboard.late') }}</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-1.5 rounded-pill fs-6">{{ __('dashboard.absent') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <div class="text-center py-8">
                            <p class="text-muted fs-5">{{ __('dashboard.no_attendance_records') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
