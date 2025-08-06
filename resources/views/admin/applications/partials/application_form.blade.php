@extends('layouts.master')
@section('title', 'Application for Residency')

@section('content')
@endsection

<!-- Top Buttons -->
<div class="top-controls">
    <a href="{{ route('admin.applications.index') }}" style="background-color: #ddd;">← Back to Applications</a>
    <div>
        <button onclick="window.print()" style="background-color: #4CAF50; color: white;">🖨️ Print</button>

        @php
            $approvalStatus = $application->admin_approved ?? 'Pending';
        @endphp

        @if ($approvalStatus !== 'Approved' && $approvalStatus !== 'Rejected')
            <form action="{{ route('admin.applications.approve', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background-color: #28a745; color: white;">✅ Approve</button>
            </form>
            <form action="{{ route('admin.applications.reject', $user->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" style="background-color: #dc3545; color: white;">❌ Reject</button>
            </form>
        @else
            <span style="margin-left: 10px;">
                <strong>Status:</strong>
                <span style="color: {{ $approvalStatus == 'Approved' ? 'green' : 'red' }};">
                    {{ $approvalStatus }}
                </span>
            </span>
        @endif
    </div>
</div>

<!-- Form Border -->
<div class="form-border">
    <div class="center">
        <img src="{{ asset('images/header.png') }}" style="width: 100%; max-width: 700px;">
    </div>
    <p class="center"><strong>OFFICE OF STUDENTS AFFAIRS & SERVICES</strong></p>
    <p class="center"><strong>Application for Residency</strong></p>
    <p class="center">(Good for one term/Semester Only)</p>
    <p>The Dormitory In-Charge</p>
    <p>Office of Students Affairs & Services</p>
    <p>SLSU-Bontoc Campus, Bontoc, So. Leyte</p>
    <p>Madame:</p>
    <p style="text-indent: 36pt;">
        The undersigned wishes to apply as occupant/resident in the SLSU Dormitory during the semester of SY
        <input type="text" value="{{ $application->school_year }}" class="short-input" readonly>.
        I am fully aware of the terms and conditions relative to dormitory occupancy and those stipulated in the contract.
    </p>
    <p class="truly">Very truly yours,</p>
    <input type="text" value="{{ $user->name }}" class="signature-input" readonly>
    <p class="signature-label">Signature over printed name</p>
    <input type="text" value="{{ $application->course }}-{{ $application->year_section }}" class="signature-input" readonly>
    <p class="label-course">Course / Year / Section</p>

    <div class="d-flex justify-content-between align-items-start mt-4">
        <p class="pt-2">In case of emergency, please contact:</p>
        <div class="text-end">
            <input type="text" value="{{ $application->emergency_contact_name }}" class="signature-input" readonly>
            <p class="label-name">Name</p>
            <input type="text" value="{{ $application->emergency_contact_address }}" class="signature-input" readonly>
            <p class="label-address">Address</p>
            <input type="text" value="{{ $application->emergency_contact_number }}" class="signature-input" readonly>
            <p class="label-contact">Contact Number</p>
        </div>
    </div>

    <div class="mt-1" style="text-align: left;">
        <p style="vertical-align: top; margin-right: 10px;">Please check your present status:</p>
        <ul class="checkbox-list">
            <li><input type="radio" disabled {{ $application->present_status == 'new_student' ? 'checked' : '' }}> New student / new applicant</li>
            <li><input type="radio" disabled {{ $application->present_status == 'old_new' ? 'checked' : '' }}> Old student but new applicant</li>
            <li><input type="radio" disabled {{ $application->present_status == 'returnee' ? 'checked' : '' }}> Old student / returnee</li>
        </ul>
    </div>

    <p class="mt-4">Noted:</p>
    <p><strong><u>BASILIDES O. GERALDO</u></strong><br>Cashier/Disbursing Officer</p>
    <p class="approved">APPROVED:</p>
    <p class="rights"><strong><u>PETER JUNE D. DADIOS, PhD</u></strong></p>
    <p class="right">Head, Student and Auxiliary Services</p>

    <div class="flex-footer">
        <img src="{{ asset('images/footerl.png') }}" alt="Footer Left" style="height: 60px; margin-top: 15px;">
        <img src="{{ asset('images/footerr.png') }}" alt="Footer Right" style="height: 90px;">
    </div>
</div>