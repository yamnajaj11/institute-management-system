@extends('layouts.admin_app')

@section('title', __('admin.add_final_exam_mark'))

@section('content')

<div class="container py-4">
<div class="d-flex justify-content-between align-items-center mb-4">
<h1 class="h3 mb-0 fw-bold text-primary">{{ __('admin.add_final_exam_mark') }}</h1>
<a href="{{ route('admin.final_exam_marks.index') }}" class="btn btn-outline-primary fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
<i class="fas fa-arrow-left fa-sm me-2"></i> {{ __('admin.back_to_list') }}
</a>
</div>

@if($errors->any())
<div class="alert alert-danger rounded-4 shadow-sm mb-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4 p-md-5">
        <form action="{{ route('admin.final_exam_marks.bulkStore') }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="py-3 px-4">{{ __('admin.student') }}</th>
                            @foreach ($subjects as $subject)
                            <th class="py-3 px-4 text-nowrap">{{ $subject->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td class="py-3 px-4 text-nowrap">{{ $student->name }}</td>
                            @foreach ($subjects as $subject)
                            <td class="py-3 px-4">
                                @php
                                    // Find the mark for the current student and subject
                                    $markValue = $student->finalExamMarks->where('test.subject_id', $subject->id)->first()->mark ?? '';
                                @endphp
                                <input type="number"
                                    name="marks[{{ $student->id }}][{{ $subject->id }}]"
                                    class="form-control rounded-pill"
                                    min="0"
                                    max="100"
                                    value="{{ $markValue }}">
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-success fw-bold rounded-pill shadow-sm transition-transform duration-300 hover:-translate-y-1">
                    <i class="fas fa-save me-2"></i> {{ __('admin.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

</div>

@endsection