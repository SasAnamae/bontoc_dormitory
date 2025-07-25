@extends('layouts.master')
@section('title', 'Rooms Management')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 fw-bold text-primary">🛏️ Rooms</h1>
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Room
        </a>
    </div>

    <div class="card shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Photo</th>
                            <th>Dormitory</th>
                            <th>Name</th>
                            <th>Total Beds</th>
                            <th>Occupied</th>
                            <th>Available</th>
                            <th>Bed Type</th>
                            <th>Decks</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rooms as $room)
                        <tr>
                            <td style="width: 100px;">
                                @if($room->photo)
                                    <img src="data:image/jpeg;base64,{{ $room->photo }}" class="rounded shadow-sm" style="width: 90px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="text-muted small">No Photo</div>
                                @endif
                            </td>
                            <td>{{ $room->dormitory->name }}</td>
                            <td>{{ $room->name }}</td>
                            <td>{{ $room->total_beds }}</td>
                            <td>{{ $room->occupied_beds }}</td>
                            <td>{{ $room->available_beds }}</td>
                            <td>{{ $room->bed_type }}</td>
                            <td>{{ $room->bed_type === 'Double Deck' ? $room->num_decks : 'N/A' }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const form = btn.closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This room and all beds will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection

