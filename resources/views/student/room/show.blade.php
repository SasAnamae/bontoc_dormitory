@extends('layouts.master')

@section('title', $room->name . ' - Select Bed')

@section('content')
<div class="container-fluid px-4 py-5">
    <a href="{{ route('student.dorm.show', $room->dormitory_id) }}" class="btn btn-secondary rounded-pill mb-3">
        <i class="fas fa-arrow-left me-1"></i> Back to Dormitory
    </a>

    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <h2 class="fw-bold text-primary">{{ $room->name }}</h2>
            <p class="text-muted mb-3">{{ $room->bed_type }} · {{ $room->available_beds }} beds available</p>

            <h5 class="fw-semibold mb-3">Available Beds</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($room->beds as $bed)
                    @if(!$bed->is_occupied)
                        <form action="{{ route('student.reserve.bed', $bed->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                Reserve {{ $bed->deck }} {{ $bed->position ? "($bed->position)" : '' }}
                            </button>
                        </form>
                    @else
                        <button class="btn btn-secondary btn-sm rounded-pill" disabled>
                            {{ $bed->deck }} {{ $bed->position ? "($bed->position)" : '' }} (Occupied)
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

