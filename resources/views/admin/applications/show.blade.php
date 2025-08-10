@extends('layouts.master')
@section('title', 'Student Application')
@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4 text-primary">📑 Full Student Application</h2>

    <!-- Back to Index Button -->
    <a href="{{ route('admin.applications.index') }}" class="btn btn-secondary mb-3">
        ← Back to Application Index
    </a>

    <ul class="nav nav-tabs mb-4" id="appTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="application-tab" data-bs-toggle="tab" data-bs-target="#application" type="button" role="tab">
                Application Form
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="agreement-tab" data-bs-toggle="tab" data-bs-target="#agreement" type="button" role="tab">
                Dormitory Agreement
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                Occupant Profile
            </button>
        </li>
    </ul>

    <div class="tab-content" id="appTabsContent">
        {{-- Tab 1: Application Form --}}
        <div class="tab-pane fade show active" id="application" role="tabpanel">
            @if ($application)
                @include('admin.applications.partials.application_form_print', ['application' => $application, 'user' => $user])
            @else
                <div class="alert alert-warning">No application form submitted.</div>
            @endif
        </div>

        {{-- Tab 2: Dormitory Agreement --}}
        <div class="tab-pane fade" id="agreement" role="tabpanel">
            @if ($agreement)
                @include('admin.applications.partials.dormitory_agreement_print', ['agreement' => $agreement])
            @else
                <div class="alert alert-info">No dormitory agreement submitted.</div>
            @endif
        </div>

         {{-- Tab 3: Occupant Profile --}}
        <div class="tab-pane fade" id="profile" role="tabpanel">
            @if ($profile)
                @include('admin.applications.partials.occupant_profile_print', ['profile' => $profile])
            @else
                <div class="alert alert-info">No occupant profile submitted.</div>
            @endif
        </div>
    </div>
</div>
@endsection

