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
            <form action="{{ route('student.profile.update', $profile->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('student.profile.form', ['profile' => $profile])
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Save Changes
                    </button>
                    @if(Auth::user()->dormitoryAgreement)
                        <a href="{{ route('student.agreement.edit', Auth::user()->dormitoryAgreement->id) }}" class="btn btn-primary rounded-pill px-4">
                            Next: Dormitory Agreement
                        </a>
                    @else
                        <a href="{{ route('student.agreement.create') }}" class="btn btn-primary rounded-pill px-4">
                            Next: Dormitory Agreement
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

