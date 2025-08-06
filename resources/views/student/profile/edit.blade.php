@extends('layouts.master')
@section('title', 'Edit Occupant Profile')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">✏️ Edit Occupant’s Profile</h1>
        <a href="{{ route('student.dashboard') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
        </a>
    </div>
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 900px;">
        <div class="card-body p-4">
            {{-- $profile is passed, $isEdit = true --}}
            @include('student.profile.form', ['isEdit' => true, 'profile' => $profile])
        </div>
    </div>
</div>
@endsection
