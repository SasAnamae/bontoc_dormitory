@extends('layouts.master')

@section('title', 'Manage Reservations')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary mb-0">🛏️ Manage Reservations</h4>
    </div>

    <div class="row g-3">
        @forelse($reservations as $reservation)
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 h-100" style="font-size: 0.85rem;">
                    {{-- Room Photo --}}
                    @if($reservation->bed->room->photo)
                        <img src="data:image/jpeg;base64,{{ $reservation->bed->room->photo }}"
                             class="card-img-top rounded-top-4"
                             alt="{{ $reservation->bed->room->name }}"
                             style="height: 130px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded-top-4" style="height: 130px;">
                            <i class="fas fa-bed fa-2x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body p-3">
                        <h6 class="fw-semibold text-primary mb-1" style="font-size: 0.95rem;">{{ $reservation->bed->room->name }}</h6>
                        <p class="mb-1 text-muted"><i class="fas fa-user me-1"></i>{{ $reservation->user->name }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-bed me-1"></i>{{ $reservation->bed->deck }} {{ $reservation->bed->position }}</p>
                        <p class="mb-1 text-muted"><i class="fas fa-calendar-alt me-1"></i>{{ $reservation->created_at->format('M d, Y') }}</p>

                        <span class="badge bg-{{ $reservation->status === 'Approved' ? 'success' : ($reservation->status === 'Rejected' ? 'danger' : 'warning') }} rounded-pill mb-2">
                            {{ $reservation->status }}
                        </span>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @if($reservation->status === 'Pending')
                                <form method="POST" action="{{ route('admin.reservations.updateStatus', [$reservation->id, 'Approved']) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm rounded-pill">
                                        <i class="fas fa-check me-1"></i> Approve
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.reservations.updateStatus', [$reservation->id, 'Rejected']) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-pill">
                                        <i class="fas fa-times me-1"></i> Reject
                                    </button>
                                </form>
                            @endif

                            <form method="POST" action="{{ route('admin.reservations.destroy', $reservation->id) }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center rounded-pill shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> No reservations found.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection

