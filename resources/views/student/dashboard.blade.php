@extends('layouts.master')
@section('title', 'Student Dashboard')

@section('content')
<div class="container mt-4">
    <div class="mb-4">
        <h4 class="fw-bold text-primary">Welcome, {{ Auth::user()->name }} 👋</h4>
        <p class="text-muted fs-6 mb-0">Explore available dormitories and reserve your spot today.</p>
    </div>

  <div class="mb-5">
    <h6 class="fw-bold mb-4 text-secondary">📋 Application Progress</h6>
    <div class="d-flex justify-content-between align-items-center position-relative progress-tracker">
        @foreach ($steps as $index => $step)
            <div class="position-relative text-center flex-fill step-wrapper">
                @if (!$loop->first)
                    <div class="progress-line {{ $steps[$index - 1]['complete'] ? 'active' : '' }}"></div>
                @endif

                <div class="step-circle mx-auto {{ $step['complete'] ? 'completed' : '' }}">
                    @if ($step['complete'])
                        <i class="fas fa-check"></i>
                    @else
                        <i class="fas fa-hourglass-half"></i>
                    @endif
                </div>

                <div class="mt-2 small fw-semibold text-muted">
                    {{ $index + 1 }}. {{ $step['label'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>



    {{-- Dormitories --}}
    <div class="row">
        @forelse($dormitories as $dorm)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 dorm-card">
                    @if($dorm->photo)
                        <img src="data:image/jpeg;base64,{{ $dorm->photo }}" class="card-img-top rounded-top-4" alt="{{ $dorm->name }}" style="height: 160px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded-top-4" style="height: 160px;">
                            <i class="fas fa-bed fa-2x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body px-3 py-2">
                        <h6 class="card-title fw-semibold mb-1 text-truncate" title="{{ $dorm->name }}">{{ $dorm->name }}</h6>
                        <p class="card-text text-muted small mb-2">Comfortable and secure for students.</p>
                        <a href="{{ route('student.dorm.show', $dorm->id) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill">View Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center rounded-3 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> No dormitories available at the moment.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection


@push('styles')
<style>
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        transition: 0.2s ease-in-out;
    }

    .card-title {
        font-size: 0.95rem;
    }

    .card-text {
        font-size: 0.8rem;
    }

    .btn-outline-primary {
        border-color: #0d6efd;
        color: #0d6efd;
        font-size: 0.85rem;
        padding: 0.3rem 0.75rem;
        transition: 0.3s;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }

    
       .progress-tracker {
        position: relative;
        margin-top: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .step-wrapper {
        position: relative;
        flex: 1;
    }
    .step-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        border: 2px solid #ccc;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #6c757d;
        background-color: #f8f9fa;
        z-index: 2;
        position: relative;
        margin-bottom: 4px;
    }
    .step-circle.completed {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
    .progress-line {
        position: absolute;
        top: 22px;
        left: -50%;
        width: 100%;
        height: 4px;
        background-color: #ccc;
        z-index: 1;
    }
    .progress-line.active {
        background-color: #0d6efd;
    }
</style>
@endpush
