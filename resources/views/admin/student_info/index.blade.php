@extends('layouts.master')
@section('title', 'Occupant Information')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary">🎓 Occupant Information</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Course & Section</th>
                            <th class="py-3">Application Status</th>
                            <th class="py-3">Room Reserved</th>
                            <th class="py-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                        <tr>
                            <td class="px-4 fw-semibold text-dark">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->occupantProfile->course ?? '—' }}-{{ $student->occupantProfile->year_section ?? '—' }}</td>
                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-light 
                                    @if($student->application_status === 'Approved') bg-success 
                                    @elseif($student->application_status === 'Rejected') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ $student->application_status ?? 'Pending' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $reservation = $student->reservations->first();
                                    $roomName = $reservation?->room?->name;
                                    $dormName = $reservation?->room?->dormitory?->name;
                                @endphp
                                <span class="text-muted">
                                    {{ $roomName ? "$roomName - $dormName" : 'No Reservation' }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.applications.show', $student->id) }}" 
                                   class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-user-slash me-2"></i> No students found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

<!-- Custom Styling -->
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

