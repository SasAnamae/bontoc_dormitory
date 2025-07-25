@extends('layouts.master')

@section('title', 'New Payment Schedule')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">➕ New Payment Schedule</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Payments
        </a>
    </div>

    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Schedule Name -->
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Schedule Name</label>
                        <input type="text" name="name" id="name" class="form-control rounded-pill"
                               placeholder="e.g., August 2025" value="{{ old('name') }}" required>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-6">
                        <label for="due_date" class="form-label fw-semibold">Due Date</label>
                        <input type="date" name="due_date" id="due_date" class="form-control rounded-pill"
                               value="{{ old('due_date') }}" required>
                    </div>

                    <!-- Default Rate -->
                    <div class="col-md-6">
                        <label for="default_rate" class="form-label fw-semibold">Base Rate (₱)</label>
                        <input type="number" name="default_rate" id="default_rate" class="form-control rounded-pill"
                               placeholder="e.g., 1500.00" step="0.01" min="0" value="{{ old('default_rate') }}" required>
                    </div>

                    <!-- Appliance Fee -->
                    <div class="col-md-6">
                        <label for="additional_fee" class="form-label fw-semibold">Appliance Fee (Optional)</label>
                        <input type="number" name="additional_fee" id="additional_fee"
                               class="form-control rounded-pill" step="0.01" min="0"
                               placeholder="e.g., 300.00">
                    </div>

                    <!-- Select Student -->
                    <div class="col-6">
                        <label for="student_id" class="form-label fw-semibold">Select Student</label>
                        <select name="student_id" id="student_id" class="form-select rounded-pill" required>
                            <option value="">-- Select a student --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">
                                    {{ $student->name }}
                                    @if($student->occupantProfile?->electrical_appliances)
                                        - Has appliances
                                    @endif
                                </option>
                            @endforeach
                        </select>

                    <!-- Total Due -->
                    <div class="col-12">
                        <label for="total_due" class="form-label fw-bold">Total Due (₱)</label>
                        <input type="number" class="form-control rounded-pill" id="total_due" name="total_due"
                               value="{{ old('total_due') }}" step="0.01" readonly>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Save Schedule
                    </button>
                    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateTotalDue() {
        const rate = parseFloat(document.getElementById('default_rate')?.value) || 0;
        const fee = parseFloat(document.getElementById('additional_fee')?.value) || 0;
        const total = rate + fee;
        document.getElementById('total_due').value = total.toFixed(2);
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('default_rate').addEventListener('input', updateTotalDue);
        document.getElementById('additional_fee').addEventListener('input', updateTotalDue);
        updateTotalDue(); // Run on load
    });
</script>
@endpush

