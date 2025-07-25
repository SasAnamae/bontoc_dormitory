@extends('layouts.master')

@section('title', 'Add Dormitory')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary mb-0">🏠 Add Dormitory</h3>
        <a href="{{ route('admin.dormitories.index') }}" class="btn btn-sm btn-secondary rounded-pill">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow rounded-4 p-4" style="max-width: 700px; margin:auto;">
        <form action="{{ route('admin.dormitories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold small">Dormitory Name</label>
                    <input type="text" name="name" class="form-control rounded-pill" placeholder="Enter dormitory name" required>
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label fw-semibold small">Dormitory Photo</label>
                    <input type="file" name="photo" id="photoInput" class="form-control rounded-pill" accept="image/*" onchange="previewImage()">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label fw-semibold small">Photo Preview</label>
                <div class="border rounded shadow-sm p-2 text-center" style="max-width: 400px; margin:auto;">
                    <img id="photoPreview" src="https://placehold.co/300x200?text=Preview" alt="Photo Preview" class="img-fluid rounded" style="object-fit: cover; max-height: 200px;">
                </div>
            </div>

            <button type="submit" class="btn btn-success rounded-pill w-100 mt-4">
                <i class="fas fa-check-circle me-1"></i>Create Dormitory
            </button>
        </form>
    </div>
</div>

<script>
function previewImage() {
    const input = document.getElementById('photoInput');
    const preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => preview.src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = "https://placehold.co/300x200?text=Preview";
    }
}
</script>
@endsection
