@extends('layouts.app')

@section('title', __('about.title'))

@section('content')
    <section class="about-section py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold text-primary">{{ __('about.heading') }}</h1>
                <p class="lead text-secondary">{{ __('about.description') }}</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="card mb-4 shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title text-primary mb-3">
                                <i class="bi bi-eye-fill me-2"></i> {{ __('about.vision_title') }}
                            </h3>
                            <p class="card-text">{{ __('about.vision_text') }}</p>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h3 class="card-title text-primary mb-3">
                                <i class="bi bi-bullseye me-2"></i> {{ __('about.mission_title') }}
                            </h3>
                            <p class="card-text">{{ __('about.mission_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
