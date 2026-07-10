@extends('layouts.admin_app')

@section('title', __('admin.add_marks'))

@section('content')
<div class="container py-4">
    <h1>{{ __('admin.add_marks') }}</h1>
    <p>{{ __('admin.subject') }}: {{ $subject->name }}</p>
    <p>{{ __('admin.test') }}: {{ $test->name }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.marks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="subjectId" value="{{ $subject->id }}">
        <input type="hidden" name="testId" value="{{ $test->id }}">

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-nowrap">{{ __('admin.student_name') }}</th>
                        <th class="text-nowrap">{{ __('admin.mark') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        <tr>
                            <td class="text-nowrap">{{ $student->name }}</td>
                            <td>
                                <input type="number" 
                                       name="marks[{{ $student->id }}]" 
                                       class="form-control" 
                                       min="0" 
                                       max="100" 
                                       required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-success">{{ __('admin.save_marks') }}</button>
    </form>
</div>
@endsection
