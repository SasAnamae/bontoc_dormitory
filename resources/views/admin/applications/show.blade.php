@extends('layouts.master')
@section('title', 'Application Details')
@section('content')
<div class="container mt-5">
    <h1 class="fw-bold text-primary mb-4">📑 Application Details</h1>

    <!-- Occupant’s Profile Card -->
    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top-4">
            <span>👤 Occupant’s Profile</span>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $application->name }}</div>
                <div class="col-md-6"><strong>Email:</strong> {{ $application->email }}</div>
                <div class="col-md-6"><strong>Course & Section:</strong> {{ $application->occupantProfile->course_section ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Home Address:</strong> {{ $application->occupantProfile->home_address ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Cellphone:</strong> {{ $application->occupantProfile->cellphone ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Birthday:</strong> 
                    {{ $application->occupantProfile->birthday ? \Carbon\Carbon::parse($application->occupantProfile->birthday)->format('F d, Y') : 'N/A' }}
                </div>
                <div class="col-md-6"><strong>Age:</strong> {{ $application->occupantProfile->age ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Religion:</strong> {{ $application->occupantProfile->religion ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Scholarship:</strong> {{ $application->occupantProfile->scholarship ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Blood Type:</strong> {{ $application->occupantProfile->blood_type ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Allergies:</strong> {{ $application->occupantProfile->allergies ?? 'N/A' }}</div>
            </div>

            <!-- Parents Info -->
            <h6 class="fw-bold text-primary mt-4">👪 Parents Information</h6>
            <div class="row g-3">
                <div class="col-md-6"><strong>Father’s Full Name:</strong> {{ $application->occupantProfile->father_fullname ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Father’s Contact Number:</strong> {{ $application->occupantProfile->father_phone ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Mother’s Full Name:</strong> {{ $application->occupantProfile->mother_fullname ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Mother’s Contact Number:</strong> {{ $application->occupantProfile->mother_phone ?? 'N/A' }}</div>
            </div>

            <!-- Additional Details -->
            <h6 class="fw-bold text-primary mt-4">🔌 Additional Details</h6>
            <div class="row g-3">
                <div class="col-md-12">
                    <strong>Electrical Appliances:</strong>
                    @php
                        $appliances = $application->occupantProfile->electrical_appliances 
                            ? explode(',', $application->occupantProfile->electrical_appliances) 
                            : [];
                    @endphp
                    @if(count($appliances))
                        <div class="mt-2">
                            @foreach($appliances as $item)
                                <span class="badge bg-secondary me-1 mb-1">{{ trim($item) }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No appliances listed.</p>
                    @endif
                </div>
                <div class="col-md-6"><strong>Total Monthly Income:</strong> ₱{{ number_format($application->occupantProfile->total_monthly, 2) ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Dormitory Agreement Card -->
    <div class="card shadow-sm rounded-4 mb-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
            <span>📄 Dormitory Agreement</span>
        </div>
        <div class="card-body">
            @if($application->dormitoryAgreement)
                <div class="mb-3 border rounded-3 p-3" style="background-color: #f8f9fa; height: 350px; overflow-y: auto;">
<pre class="m-0" style="white-space: pre-wrap; word-wrap: break-word; font-family: inherit;">
DORMITORY AGREEMENT
I, {{ $application->name }}, {{ $application->occupantProfile->course_section ?? '__________' }}, do hereby agree and conform to the following conditions of the privileges granted to me by the school authorities to reside in the SLSU dormitory.
1. That I shall abide by the dormitory rules, regulation or injunctions promulgated verbally or in writing by the authorities concerned.
2. That I shall pay my dormitory fee promptly and failure to pay for two (2) consecutive months means cancellation of the privilege to stay in the dormitory.
3. That I shall pay the association fee of P10.00 and submit the necessary documents or requirements before I could qualify to reside in the dormitory.
4. That I shall settle all my financial obligations to the dormitory on or before the final examinations of the current semester.
5. That I shall recognize the right of the dormitory authorities to inspect my room, locker or closet and personal belongings when circumstances warrant so.
6. That if I decide to leave the dormitory before the end of semester, I am obliged to pay 50% of the residence fee/rental for the remaining months of the semester.
7. That I shall help maintain the cleanliness & upkeep of the dormitory and its surroundings at all times.
8. In case of dismissal or expulsion from the dormitory, I shall forfeit whatever amount I shall have paid as dormitory fee or rental or in case I vacate the dormitory voluntarily.
9. That I shall be willing to accept whatever penalty the management or school authorities impose upon me and shall conform to the decision of the same for any violation or infraction of the dormitory rules and regulations.
In witness whereof, I hereby affix my signature on this {{ $application->dormitoryAgreement->date_signed ? \Carbon\Carbon::parse($application->dormitoryAgreement->date_signed)->format('jS \\of F Y') : '__________' }} at SLSU - Bontoc Campus, San Ramon, Bontoc, Southern Leyte.
</pre>
                </div>
                <p><strong>Date Signed:</strong> {{ \Carbon\Carbon::parse($application->dormitoryAgreement->date_signed)->format('F d, Y') }}</p>
            @else
                <div class="alert alert-warning rounded-pill text-center">
                    <i class="fas fa-exclamation-circle me-2"></i> Dormitory Agreement not submitted yet.
                </div>
            @endif
        </div>
    </div>

    <!-- Approve/Reject Buttons -->
    <div class="d-flex gap-2">
        <form action="{{ route('admin.applications.approve', $application->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success rounded-pill px-4">
                <i class="fas fa-check-circle me-1"></i> Approve
            </button>
        </form>
        <form action="{{ route('admin.applications.reject', $application->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger rounded-pill px-4">
                <i class="fas fa-times-circle me-1"></i> Reject
            </button>
        </form>
        <a href="{{ route('admin.applications.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
</div>
@endsection

