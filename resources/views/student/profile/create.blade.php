@extends('layouts.master')
@section('title', 'Occupant Profile Form')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">📝 Occupant’s Profile Form</h1>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
    <p class="text-muted mb-4">Please complete all required fields to proceed with your dormitory application.</p>
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 900px;">
        <div class="card-body p-4">
            <form action="{{ route('student.profile.store') }}" method="POST">
                @csrf
                @include('student.profile.form')
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Submit Profile
                    </button>
                    <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

