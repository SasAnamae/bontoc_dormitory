@extends('layouts.master')
@section('title', 'Student Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold text-primary mb-3">Welcome, {{ Auth::user()->name }}</h1>
    <p class="text-muted">This is your student dashboard. Here you can view your profile, reservations, payments, and more.</p>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Welcome!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    </script>
@endif

@if(!Auth::user()->agreed_to_terms)
<div id="termsOverlay" class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-75" style="z-index: 1050;">
    <div class="card shadow-lg rounded-4" style="max-width: 800px; width: 90%;">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0"><i class="fas fa-file-contract me-2"></i> Terms & Conditions</h4>
        </div>
        <div class="card-body p-4">
            <div class="border rounded-3 p-3 mb-4" style="height: 300px; overflow-y: auto; background-color: #f8f9fa;">
                <h5 class="fw-bold mb-3">Privacy Policy and Terms of Service</h5>
                <p><strong>1. Purpose</strong></p>
                <p>This system is designed to manage dormitory reservations and store essential information for the students and staff of SLSU Bontoc Campus. By using this system, you agree to adhere to its terms of use and privacy policies.</p>
                <p><strong>2. Data Privacy</strong></p>
                <p>Your personal data including but not limited to name, student ID, contact details, and dormitory preferences will be collected and stored securely in accordance with Republic Act No. 10173 (Data Privacy Act of 2012).</p>
                <p><strong>3. User Responsibilities</strong></p>
                <ul>
                    <li>Provide accurate and updated information when using the system.</li>
                    <li>Maintain confidentiality of your login credentials.</li>
                    <li>Unauthorized access, data tampering, or distribution of false information is strictly prohibited.</li>
                </ul>
                <p><strong>4. System Usage</strong></p>
                <p>The system is intended for registered students and authorized personnel only. Misuse may result in disciplinary action as per university regulations.</p>
                <p><strong>5. Updates to Policy</strong></p>
                <p>This policy may be updated periodically. Students are encouraged to review this page regularly for changes.</p>
                <p><strong>6. Consent</strong></p>
                <p>By clicking “I Agree”, you acknowledge that you have read, understood, and accepted these terms and conditions.</p>
            </div>
            <form id="agreeForm" method="POST" action="{{ route('student.terms.agree') }}" class="text-end">
                @csrf
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fas fa-check-circle me-1"></i> I Agree
                </button>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Prevent dashboard interaction if terms are not agreed
        if (!@json(Auth::user()->agreed_to_terms)) {
            document.body.style.overflow = 'hidden';
        }
    });
</script>
@endpush

