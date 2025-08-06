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
            {{-- NOTE: $isEdit = false by default --}}
            @include('student.profile.form', ['isEdit' => false])
        </div>
    </div>
</div>
@endsection
