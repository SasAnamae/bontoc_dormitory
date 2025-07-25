@extends('layouts.master')
@section('title', 'Occupant Applications')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 fw-bold text-primary">📂 Occupant Applications</h4>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="row g-3">
        @forelse($students as $student)
            @php
                $status = $student->application_status ?? 'Pending';
                $badgeColor = $status === 'Approved' ? 'success' : ($status === 'Rejected' ? 'danger' : 'warning');
                $statusText = $status === 'Pending' ? 'Awaiting Approval' : $status;
            @endphp
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card shadow-sm rounded-4 h-100 position-relative">
                    <form method="POST" action="{{ route('admin.applications.destroy', $student->id) }}" class="delete-form position-absolute top-0 end-0 m-2">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger rounded-circle delete-btn" data-name="{{ $student->name }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <div class="card-body text-center">
                        <a href="{{ route('admin.applications.show', $student->id) }}" class="text-decoration-none">
                            <div class="folder-icon bg-{{ $badgeColor }} mb-3 mx-auto">
                                <i class="fas fa-folder fa-3x text-white"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">{{ $student->name }}</h6>
                            <span class="badge rounded-pill bg-{{ $badgeColor }}">{{ $statusText }}</span>
                        </a>
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

@push('styles')
<style>
.folder-icon {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.2s, box-shadow 0.2s;
}
.folder-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.delete-btn {
    border: none;
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
@endsection
