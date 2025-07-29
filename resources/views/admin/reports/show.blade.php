@extends('layouts.master')

@section('title', 'Report Details')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0 text-primary">📄 Report Details</h4>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    {{-- Report Info --}}
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-2">{{ $report->title }}</h5>

                    <p class="text-muted small mb-1">
                        <strong>Submitted by:</strong> {{ $report->student->name ?? 'Unknown'  }}
                    </p>
                    <p class="text-muted small mb-1">
                        <strong>Submitted:</strong> {{ $report->created_at->format('F j, Y • h:i A') }}
                    </p>
                    <p class="text-muted small mb-1">
                        <strong>Email:</strong> {{ $report->student->email ?? 'N/A' }}
                    </p>

                    <p class="text-muted small mb-1">
                        <strong>Course & Section:</strong> {{ $report->student->occupantProfile->course_section ?? '—' }}
                    </p>

                    @php
                        $reservation = $report->student->reservations->first();
                        $room = $reservation?->room?->name;
                        $dorm = $reservation?->room?->dormitory?->name;
                    @endphp

                    <p class="text-muted small mb-3">
                        <strong>Room Reserved:</strong> {{ $room ? "$room - $dorm" : 'No Reservation' }}
                    </p>

                    <p class="text-muted small mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ 
                            $report->status === 'Resolved' ? 'success' : 
                            ($report->status === 'In Progress' ? 'warning text-dark' : 'secondary') 
                        }}">
                            {{ $report->status }}
                        </span>
                    </p>

                    <hr>

                    <p class="mb-0">{{ $report->message }}</p>
                </div>
            </div>
        </div>

        {{-- Admin Response Form --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h5 class="mb-3 text-success fw-bold">🛠 Admin Response</h5>

                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="admin_response" class="form-label">Response</label>
                            <textarea name="admin_response" id="admin_response" class="form-control rounded-3" rows="4" required>{{ old('admin_response', $report->admin_response) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select name="status" id="status" class="form-select rounded-3" required>
                                <option value="Pending" {{ $report->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                <option value="In Progress" {{ $report->status === 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Resolved" {{ $report->status === 'Resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill w-100">
                            <i class="fas fa-paper-plane me-1"></i> Submit Response
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

