<!-- @extends('layouts.master')
@section('title', 'Edit Payment Schedule')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary">✏️ Edit Payment Schedule</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Payments
        </a>
    </div>

    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.payments.update', $schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Schedule Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill" 
                           value="{{ old('name', $schedule->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="rate" class="form-label fw-semibold">Rate (₱)</label>
                    <input type="number" name="rate" id="rate" class="form-control rounded-pill" 
                           value="{{ old('rate', $schedule->rate) }}" required step="0.01" min="0">
                </div>

                <div class="mb-3">
                    <label for="due_date" class="form-label fw-semibold">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control rounded-pill" 
                           value="{{ old('due_date', \Carbon\Carbon::parse($schedule->due_date)->format('Y-m-d')) }}" required>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Update Schedule
                    </button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection -->
