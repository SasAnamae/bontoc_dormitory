@extends('layouts.master')  
@section('title', 'Student Dashboard')  

@section('content')  
<div class="container mt-4">
    <div class="mb-4">
        <h4 class="fw-bold text-primary">Welcome, {{ Auth::user()->name }} 👋</h4>
        <p class="text-muted fs-6 mb-0">Explore available dormitories and reserve your spot today.</p>
    </div>

    <div class="row">
        @forelse($dormitories as $dorm)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 dorm-card">
                    @if($dorm->photo)
                        <img src="data:image/jpeg;base64,{{ $dorm->photo }}" 
                             class="card-img-top rounded-top-4"
                             alt="{{ $dorm->name }}"
                             style="height: 160px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded-top-4"
                             style="height: 160px;">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

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
</style>
@endpush

