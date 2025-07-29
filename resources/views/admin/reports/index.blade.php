@extends('layouts.master')
@section('title', 'Student Reports')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="h3 fw-bold text-primary">📋 Student Reports</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>
    <div class="card shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="py-3 px-4">Title</th>
                            <th class="py-3">Student</th>
                            <th class="py-3">Course & Section</th>
                            <th class="py-3">Room Reserved</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Date Submitted</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($reports as $report)
                        @php
                            $student = $report->student;
                            $reservation = $student?->reservations?->first();
                            $room = $reservation?->room?->name;
                            $dorm = $reservation?->room?->dormitory?->name;
                            $course = $student?->occupantProfile?->course_section;
                        @endphp
                        <tr>
                            <td class="px-4 fw-semibold text-dark">{{ $report->title }}</td>
                            <td>{{ $student?->name ?? 'N/A' }}</td>
                            <td>{{ $course ?? '—' }}</td>
                            <td>
                                <span class="text-muted">
                                    {{ $room ? "$room - $dorm" : 'No Reservation' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-light
                                    @if($report->status === 'Resolved') bg-success
                                    @elseif($report->status === 'In Progress') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td>{{ $report->created_at->format('M d, Y') }}</td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="View">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="delete-form d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-button">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-1"></i> No reports found.
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

{{-- Style section --}}
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
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
</style>

{{-- Scripts --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Delete Report?',
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

