@extends('layouts.app')

@section('title', __('auth.login_title'))

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="text-center mb-4 fw-bold">{{ __('auth.login_title') }}</h2>
                    <p class="text-center text-muted mb-4">{{ __('auth.welcome_message') }}</p>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-bold">{{ __('auth.student_id') }}</label>
                            <input type="text" name="student_id" id="student_id" class="form-control form-control-lg rounded-pill @error('student_id') is-invalid @enderror" value="{{ old('student_id') }}" required autocomplete="student_id" autofocus>
                            @error('student_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold">{{ __('auth.password') }}</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg rounded-pill @error('password') is-invalid @enderror" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill">{{ __('auth.login_button') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
