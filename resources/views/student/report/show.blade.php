@extends('layouts.master')

@section('title', 'View Report')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📄 Report Details</h4>
        <a href="{{ route('student.report.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="d-flex justify-content-center">
        <div class="w-100" style="max-width: 1000px;">
            <div class="row g-4">
                {{-- Report Card (Smaller) --}}
                <div class="col-md-4">
                    <div class="card shadow-sm rounded-4 h-100 bg-light border-12">
                        <div class="card-body p-4">
                            <h5 class="mb-2 text-primary"><i class="fas fa-paper-plane me-2"></i>Sent Report</h5>
                            <p class="text-muted small mb-2">
                                <strong>Status:</strong>
                                <span class="badge bg-{{ 
                                    $report->status === 'Resolved' ? 'success' : 
                                    ($report->status === 'In Progress' ? 'warning' : 'secondary') 
                                }}">
                                    {{ $report->status }}
                                </span>
                            </p>
                            <hr class="mb-2">
                            <p class="mb-3">{{ $report->message }}</p>
                            <p class="text-muted small mb-0">
                                Submitted: {{ $report->created_at->format('F j, Y • h:i A') }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Admin Response Card (Bigger) --}}
                <div class="col-md-8">
                    <div class="card shadow-sm rounded-4 h-100 bg-white border-12">
                        <div class="card-body p-4">
                            <h5 class="mb-3 text-success"><i class="fas fa-reply me-2"></i>Admin Response</h5>
                            @if($report->admin_response)
                                <p class="mb-3">{{ $report->admin_response }}</p>
                                <p class="text-muted small mb-0">
                                    Responded: {{ $report->updated_at->format('F j, Y • h:i A') }}
                                </p>
                            @else
                                <p class="text-muted fst-italic mb-0">No response yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection

