@extends('layouts.admin_app')

@section('title', __('admin.select_subject_for_marks'))

@section('content')
<div class="container py-4">
    <h1>{{ __('admin.select_subject_for_marks') }}</h1>

    <div class="list-group">
        @foreach($subjects as $subject)
            <a href="{{ route('admin.marks.add_bulk', ['subjectId' => $subject->id]) }}" class="list-group-item list-group-item-action">
                {{ $subject->name }}
            </a>
        @endforeach
    </div>
</div>
@endsection
