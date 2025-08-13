@extends('layouts.master')
@section('title', 'Add Room')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 fw-bold text-primary">➕ Add Room</h1>
        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary btn-sm rounded-pill">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
    <div class="card shadow-sm rounded-4 p-4">
        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Dormitory</label>
                    <select name="dormitory_id" class="form-select rounded-pill" required>
                        <option value="">-- Select Dormitory --</option>
                        @foreach($dormitories as $dorm)
                            <option value="{{ $dorm->id }}">{{ $dorm->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Room Name</label>
                    <input type="text" name="name" class="form-control rounded-pill" placeholder="Enter room name" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Room Photo</label>
                    <input type="file" name="photo" class="form-control rounded-pill" accept="image/*">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Total Bed Space</label>
                    <input type="number" name="total_beds" class="form-control rounded-pill" placeholder="e.g., 6" required min="1">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Bed Type</label>
                    <select name="bed_type" id="bed_type" class="form-select rounded-pill" required>
                        <option value="">-- Select Bed Type --</option>
                        <option value="Single">Single</option>
                        <option value="Double Deck">Double Deck</option>
                    </select>
                </div>
                <div class="col-md-6" id="num_decks_field" style="display: none;">
                    <label class="form-label fw-semibold">Number of Decks</label>
                    <input type="number" name="num_decks" id="num_decks" class="form-control rounded-pill" placeholder="e.g., 2" min="1">
                </div>
            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fas fa-check me-2"></i>Add Room
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('bed_type').addEventListener('change', function () {
    const deckField = document.getElementById('num_decks_field');
    deckField.style.display = this.value === 'Double Deck' ? 'block' : 'none';
});
</script>
@endpush
@endsection

