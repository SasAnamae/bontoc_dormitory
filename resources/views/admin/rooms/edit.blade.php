@extends('layouts.master')
@section('title', 'Edit Room')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 fw-bold text-primary">✏️ Edit Room</h1>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left"></i> Back to Rooms
        </a>
    </div>
    <div class="card shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dormitory</label>
                    <select name="dormitory_id" class="form-select rounded-pill" required>
                        @foreach($dormitories as $dorm)
                            <option value="{{ $dorm->id }}" {{ $room->dormitory_id == $dorm->id ? 'selected' : '' }}>
                                {{ $dorm->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Room Name</label>
                    <input type="text" name="name" class="form-control rounded-pill" value="{{ $room->name }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Room Photo</label>
                    <input type="file" name="photo" class="form-control rounded-pill" accept="image/*">
                    @if($room->photo)
                        <div class="mt-2">
                            <img src="data:image/jpeg;base64,{{ $room->photo }}" class="rounded shadow-sm" style="width: 90px; height: 60px; object-fit: cover;">
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Bed Space</label>
                    <input type="number" name="total_beds" class="form-control rounded-pill" value="{{ $room->total_beds }}" required min="1">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bed Type</label>
                    <select name="bed_type" id="bed_type" class="form-select rounded-pill" required>
                        <option value="Single" {{ $room->bed_type == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Double Deck" {{ $room->bed_type == 'Double Deck' ? 'selected' : '' }}>Double Deck</option>
                    </select>
                </div>
                <div class="col-md-6" id="num_decks_field" style="{{ $room->bed_type === 'Double Deck' ? '' : 'display:none;' }}">
                    <label class="form-label fw-semibold">Number of Decks</label>
                    <input type="number" name="num_decks" id="num_decks" class="form-control rounded-pill" value="{{ $room->num_decks }}" min="1">
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <i class="fas fa-save me-2"></i> Update Room
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const bedType = document.getElementById('bed_type');
    const decksField = document.getElementById('num_decks_field');
    const numDecksInput = document.getElementById('num_decks');

    function toggleDecksField() {
        if (bedType.value === 'Double Deck') {
            decksField.style.display = 'block';
            numDecksInput.removeAttribute('disabled');
            numDecksInput.setAttribute('required', 'required');
        } else {
            decksField.style.display = 'none';
            numDecksInput.removeAttribute('required');
            numDecksInput.setAttribute('disabled', 'disabled');
        }
    }

    bedType.addEventListener('change', toggleDecksField);
    toggleDecksField(); // On page load
});

</script>
@endpush
@endsection

