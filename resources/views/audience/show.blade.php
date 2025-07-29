@extends('layouts.master')

@section('title', '📢 Announcement')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body p-4">
                    <h2 class="card-title fw-bold mb-3 text-primary">
                        <i class="fas fa-bullhorn me-2"></i>{{ $announcement->title }}
                    </h2>

                    <p class="text-muted small mb-4">
                        📅 Posted on {{ \Carbon\Carbon::parse($announcement->created_at)->format('F j, Y • h:i A') }}
                    </p>

                    <div class="alert alert-light border-start border-4 border-primary" style="white-space: pre-wrap; font-size: 1rem; line-height: 1.7;">
                        {!! nl2br(e($announcement->message)) !!}
                    </div>

                    <a href="{{ url()->previous() }}" class="btn btn-outline-primary rounded-pill mt-4">
                        ← Back
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
