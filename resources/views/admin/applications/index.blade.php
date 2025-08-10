@extends('layouts.master')
@section('title', 'Occupant Applications')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-primary">📂 Occupant Applications</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

   <div class="row g-4">
    @forelse($students as $student)
            @php
            $hasApplication = $student->applicationForm !== null;
            $hasAgreement = $student->dormitoryAgreement !== null;
            $hasProfile = $student->occupantProfile !== null;
            $hasVerifiedPayment = $student->payments->where('status', 'verified')->isNotEmpty();

            if (!$hasApplication) {
                $status = 'No Application';
                $badgeColor = 'secondary';

            } elseif (!$hasVerifiedPayment) {
                $status = 'Waiting: Payment Verification';
                $badgeColor = 'warning';

            } elseif ($student->application_status === 'Rejected') {
                $status = 'Rejected';
                $badgeColor = 'danger';

            } elseif ($student->application_status === 'Pending') {
                $status = 'Awaiting Approval';
                $badgeColor = 'info';

            } elseif ($student->application_status === 'Approved' && $hasProfile && $hasAgreement) {
                $status = 'Fully Approved';
                $badgeColor = 'success';

            } elseif ($student->application_status === 'Approved' && !$hasProfile) {
                $status = 'Waiting: Profile';
                $badgeColor = 'warning';

            } elseif ($student->application_status === 'Approved' && $hasProfile && !$hasAgreement) {
                $status = 'Waiting: Agreement';
                $badgeColor = 'warning';
            } else {
                $status = 'Awaiting Approval';
                $badgeColor = 'info';
            }

        @endphp



        <div class="col-6 col-sm-4 col-md-3 col-lg-2 text-center">
            <div class="folder-wrapper position-relative">
                <!-- Delete Button -->
                <form method="POST" action="{{ route('admin.applications.destroy', $student->id) }}"
                    class="delete-form position-absolute top-0 end-0">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-sm btn-danger rounded-circle delete-btn" data-name="{{ $student->name }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>

                <!-- Folder Icon Link -->
                <a href="{{ route('admin.applications.show', $student->id) }}" class="text-decoration-none d-block">
                    <div class="folder-icon mx-auto">
                        <i class="fas fa-folder fa-3x text-{{ $badgeColor }}"></i>
                    </div>
                </a>

                <!-- Student Info -->
                <div class="student-info mt-2">
                    <h6 class="fw-semibold text-dark mb-1">{{ $student->name }}</h6>
                    <span class="badge rounded-pill bg-{{ $badgeColor }}">{{ $status }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center rounded-pill shadow-sm">
                No student applications submitted yet.
            </div>
        </div>
    @endforelse
</div>
</div>
@endsection

@push('styles')
<style>
.folder-icon {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s ease;
    background-color: transparent; /* remove background */
}
.folder-icon:hover {
    transform: scale(1.05);
}
.folder-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('.delete-form');
        const studentName = this.dataset.name;
        Swal.fire({
            title: `Delete ${studentName}'s Application?`,
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush

