<?php
// هذا الملف مصمم لإدخال علامات الطلاب في جميع الاختبارات الخاصة بمادة معينة.
// لقد قمنا بتعديله لإضافة قائمة منسدلة في الأعلى تسمح بتصفية الجدول حسب الاختبار.
?>
@extends('layouts.admin_app')

@section('title', __('admin.add_marks'))

@section('content')
<div class="container py-4">
    <h1 class="mb-4">{{ __('admin.add_marks') }}</h1>
    <p class="mb-3">{{ __('admin.subject') }}: {{ $subject->name }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-4">
        <label for="testFilter" class="form-label">{{ __('admin.filter_by_test') }}</label>
        <select id="testFilter" class="form-select w-25">
            <option value="all">{{ __('admin.all_tests') }}</option>
            @foreach($tests as $test)
                <option value="{{ $test->id }}">{{ $test->name }}</option>
            @endforeach
        </select>
    </div>

    <form action="{{ route('admin.marks.bulk_store') }}" method="POST">
        @csrf
        <input type="hidden" name="subject_id" value="{{ $subject->id }}">

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="marksTable">
                <thead>
                    <tr>
                        <th class="text-nowrap student-name-col">{{ __('admin.student_name') }}</th>
                        @foreach($tests as $test)
                            <th class="text-nowrap test-col test-{{ $test->id }}">{{ $test->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="text-nowrap student-name-col">{{ $student->name }}</td>
                            @foreach($tests as $test)
                                <td class="test-col test-{{ $test->id }}">
                                    <input type="number" 
                                           name="marks[{{ $student->id }}][{{ $test->id }}]" 
                                           class="form-control" 
                                           min="0" 
                                           max="100" 
                                           value="{{ optional($student->marks->where('test_id', $test->id)->first())->mark }}">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-success">{{ __('admin.save_marks') }}</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const testFilter = document.getElementById('testFilter');
    const marksTable = document.getElementById('marksTable');
    
    testFilter.addEventListener('change', function () {
        const selectedTestId = this.value;
        const testCols = marksTable.querySelectorAll('.test-col');
        
        testCols.forEach(col => {
            if (selectedTestId === 'all' || col.classList.contains(`test-${selectedTestId}`)) {
                col.style.display = ''; // إظهار العمود
            } else {
                col.style.display = 'none'; // إخفاء العمود
            }
        });
    });
});
</script>
@endsection
