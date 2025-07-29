@extends('layouts.master')
@section('title', 'Announcements')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="h3 fw-bold text-primary">📢 Announcements</h3>
        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> New Announcement
        </a>
    </div>

    <div class="card shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="py-3 px-4" style="width: 40%;">Title</th>
                            <th class="py-3" style="width: 20%;">Audience</th>
                            <th class="py-3" style="width: 25%;">Created At</th>
                            <th class="py-3 text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($announcements as $announcement)
                        <tr>
                            <td class="px-4 fw-semibold text-dark text-truncate" style="max-width: 300px;">
                                {{ $announcement->title }}
                            </td>
                            <td style="max-width: 150px;">
                                @if($announcement->audience === 'students')
                                    All Students
                                @elseif($announcement->audience === 'cashier')
                                    Cashier
                                @else
                                    Selected Students
                                @endif
                            </td>
                            <td>{{ $announcement->created_at->format('M d, Y h:i A') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-button">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-1"></i> No announcements found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Style --}}
<style>
    .badge {
        font-size: 0.85rem;
        font-weight: 500;
    }
    .card {
        border: none;
        background: #ffffff;
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
    .text-truncate {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

{{-- SweetAlert Delete Confirmation --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Delete Announcement?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

