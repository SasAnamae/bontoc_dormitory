@extends('layouts.master')
@section('title', 'Create Announcement')
@section('content')
<div class="container-fluid px-4 py-4">
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">➕ New Announcement</h4>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>
    <div class="card shadow-sm rounded-4">
        <div class="card-body px-4 py-4">
            <form action="{{ route('admin.announcements.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">📌 Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">💬 Message</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">👥 Audience</label>
                    <select name="audience" class="form-select" id="audience" required>
                        <option value="all_students">All Students</option>
                        <option value="selected_students">Selected Students</option>
                        <option value="cashier">Cashier</option>
                    </select>
                </div>
                <div class="mb-3 d-none" id="student-select">
                    <label class="form-label fw-semibold">🎯 Select Students</label>
                    <div class="row">
                        @foreach($students as $student)
                            <div class="col-md-4">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" name="students[]" value="{{ $student->id }}" id="student{{ $student->id }}">
                                    <label class="form-check-label" for="student{{ $student->id }}">
                                        {{ $student->name }} <small class="text-muted">({{ $student->email }})</small>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-success rounded-pill mt-3">
                    <i class="fas fa-paper-plane me-1"></i> Send
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const audience = document.getElementById('audience');
    const studentSelect = document.getElementById('student-select');
    audience.addEventListener('change', function () {
        studentSelect.classList.toggle('d-none', this.value !== 'selected_students');
    });
</script>
@endpush

