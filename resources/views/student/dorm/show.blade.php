@extends('layouts.master')

@section('title', $dorm->name . ' - Details')

@section('content')
<div class="container-fluid px-4 py-5">
    <a href="{{ route('student.dashboard') }}" class="btn btn-secondary rounded-pill mb-3">
        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
    </a>

    <div class="card shadow-sm rounded-4 mb-4">
        @if($dorm->photo)
            <img src="data:image/jpeg;base64,{{ $dorm->photo }}" class="card-img-top rounded-top-4"
                 alt="{{ $dorm->name }}" style="height: 280px; object-fit: cover;">
        @endif
        <div class="card-body">
            <h2 class="fw-bold text-primary">{{ $dorm->name }}</h2>
            <p class="text-muted mb-0">Select a room and reserve your bed.</p>
        </div>
    </div>

    <h4 class="fw-semibold mb-3">Available Rooms</h4>
    <div class="row">
        @forelse($dorm->rooms as $room)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body">
                    <h5 class="fw-semibold">{{ $room->name }}</h5>
                    <p class="text-muted small mb-2">{{ $room->bed_type }} · {{ $room->available_beds }} beds left</p>
                    <div class="mb-2">
                        @foreach($room->beds as $bed)
                            <span class="badge rounded-pill {{ $bed->is_occupied ? 'bg-danger' : 'bg-success' }}">
                                {{ $bed->deck }}{{ $bed->position ? " ($bed->position)" : '' }}
                            </span>
                        @endforeach
                    </div>
                    <a href="{{ route('student.room.show', $room->id) }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill mt-2">
                        View Beds
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center rounded-pill shadow-sm">
                <i class="fas fa-info-circle me-1"></i> No rooms available.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

