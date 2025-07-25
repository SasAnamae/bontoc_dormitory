@extends('layouts.master')

@section('title', 'My Reservations')

@section('content')
<div class="container mt-4">
    <h3 class="fw-bold text-primary">📋 My Reservations</h3>

    <div class="row">
        @forelse($reservations as $reservation)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 border-0 rounded-4 reservation-card">
                    @if($reservation->bed->room->photo)
                        <img src="data:image/jpeg;base64,{{ $reservation->bed->room->photo }}"
                             class="card-img-top rounded-top-4"
                             style="height: 160px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center rounded-top-4"
                             style="height: 160px;">
                            <i class="fas fa-bed fa-2x text-muted"></i>
                        </div>
                    @endif

                    <div class="card-body px-3 py-2">
                        <h6 class="fw-semibold mb-1 text-truncate">{{ $reservation->bed->room->name }}</h6>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-bed me-1"></i> {{ $reservation->bed->deck }} {{ $reservation->bed->position }}
                        </p>
                        <p class="text-muted small mb-1">
                            <i class="fas fa-calendar-alt me-1"></i> {{ $reservation->created_at->format('M d, Y') }}
                        </p>

                        <span class="badge rounded-pill bg-{{ 
                            $reservation->status === 'Approved' ? 'success' : 
                            ($reservation->status === 'Rejected' ? 'danger' : 'warning') }}">
                            {{ $reservation->status }}
                        </span>

                        <form action="{{ route('student.reservations.destroy', $reservation->id) }}" method="POST" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill w-100 cancel-btn">
                                Cancel Reservation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center rounded-3 shadow-sm">
                    <i class="fas fa-info-circle me-2"></i> You have no reservations.
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
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease-in-out;
    }
    .card-title, h6 {
        font-size: 0.95rem;
    }
    .card-text,
    .text-muted {
        font-size: 0.8rem;
    }
    .btn-outline-danger {
        font-size: 0.8rem;
        padding: 0.3rem 0.6rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.cancel-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Cancel Reservation?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, cancel it'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

