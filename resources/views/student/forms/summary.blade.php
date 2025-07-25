@extends('layouts.master')
@section('title', 'Forms Summary')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 fw-bold text-primary">📋 Review Your Forms</h1>
    <p class="text-muted">Please double-check all details before finalizing your submission. Once submitted, changes cannot be made.</p>

    <!-- Occupant’s Profile Card -->
    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <span>👤 Occupant’s Profile</span>
            <a href="{{ route('student.profile.edit', ['profile' => $profile->id]) }}" class="btn btn-light btn-sm rounded-pill">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><strong>Course & Section:</strong> {{ $profile->course_section }}</div>
                <div class="col-md-6"><strong>Home Address:</strong> {{ $profile->home_address }}</div>
                <div class="col-md-6"><strong>Cellphone:</strong> {{ $profile->cellphone }}</div>
                <div class="col-md-6"><strong>Email:</strong> {{ $profile->email }}</div>
                <div class="col-md-6"><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($profile->birthday)->format('F d, Y') }}</div>
                <div class="col-md-6"><strong>Religion:</strong> {{ $profile->religion }}</div>
                <!-- Add more fields if needed -->
            </div>
        </div>
    </div>

    <!-- Dormitory Agreement Card -->
    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
            <span>📄 Dormitory Agreement</span>
        </div>
        <div class="card-body">
            <div class="mb-3 border rounded-3 p-3" style="background-color: #f8f9fa;">
                <pre class="m-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: inherit;">
DORMITORY AGREEMENT

I, {{ Auth::user()->name }}, {{ Auth::user()->occupantProfile->course_section ?? '__________' }}, do hereby agree and conform to the following conditions of the privileges granted to me by the school authorities to reside in the SLSU dormitory.

1. That I shall abide by the dormitory rules, regulation or injunctions promulgated verbally or in writing by the authorities concerned.
2. That I shall pay my dormitory fee promptly and failure to pay for two (2) consecutive months means cancellation of the privilege to stay in the dormitory.
3. That I shall pay the association fee of P10.00 and submit the necessary documents or requirements before I could qualify to reside in the dormitory.
4. That I shall settle all my financial obligations to the dormitory on or before the final examinations of the current semester.
5. That I shall recognize the right of the dormitory authorities to inspect my room, locker or closet and personal belongings when circumstances warrant so.
6. That if I decide to leave the dormitory before the end of semester, I am obliged to pay 50% of the residence fee/rental for the remaining months of the semester.
7. That I shall help maintain the cleanliness & upkeep of the dormitory and its surroundings at all times.
8. In case of dismissal or expulsion from the dormitory, I shall forfeit whatever amount I shall have paid as dormitory fee or rental or in case I vacate the dormitory voluntarily.
9. That I shall be willing to accept whatever penalty the management or school authorities impose upon me and shall conform to the decision of the same for any violation or infraction of the dormitory rules and regulations.

In witness whereof, I hereby affix my signature on this {{ \Carbon\Carbon::parse($agreement->date_signed)->format('jS \\of F Y') }} at SLSU - Bontoc Campus, San Ramon, Bontoc, Southern Leyte.
                </pre>
            </div>
            <div>
                <p><strong>Date Signed:</strong> {{ \Carbon\Carbon::parse($agreement->date_signed)->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Finalize Button -->
    <div class="text-center mt-4">
        <button type="button" class="btn btn-danger btn-lg rounded-pill px-5" id="finalizeBtn">
            <i class="fas fa-check-circle me-2"></i> Finalize & Submit
        </button>
    </div>

    <form id="finalizeForm" action="{{ route('student.forms.finalize') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('finalizeBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Finalize & Submit?',
            text: "Once submitted, you cannot edit the forms.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, finalize it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('finalizeForm').submit();
            }
        });
    });
</script>
@endpush

