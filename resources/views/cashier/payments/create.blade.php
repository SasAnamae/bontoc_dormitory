@extends('layouts.master')
@section('title', 'Process Payment')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">💳 New Payment</h1>
        <a href="{{ route('cashier.payments.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Payments
        </a>
    </div>
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <form action="{{ route('cashier.payments.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Student -->
                    <div class="col-md-6">
                        <label for="user_id" class="form-label fw-semibold">Student</label>
                        <select name="user_id" id="user_id" class="form-select rounded-pill" required>
                            <option value="">Select a Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Schedule -->
                    <div class="col-md-6">
                        <label for="schedule_id" class="form-label fw-semibold">Payment Schedule</label>
                        <select name="schedule_id" id="schedule_id" class="form-select rounded-pill" required>
                            <option value="">Select a Schedule</option>
                            @foreach($students as $student)
                                <optgroup label="{{ $student->name }}" data-student="{{ $student->id }}">
                                    @foreach($student->schedules as $schedule)
                                        <option value="{{ $schedule->id }}" data-student="{{ $student->id }}">
                                            {{ $schedule->name }} (₱{{ number_format($schedule->pivot->total_due, 2) }}) - Due {{ \Carbon\Carbon::parse($schedule->due_date)->format('M d, Y') }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <!-- Amount -->
                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
                        <input type="number" name="amount" class="form-control rounded-pill" step="0.01" required>
                    </div>
                    <!-- OR Number -->
                    <div class="col-md-6">
                        <label for="or_number" class="form-label fw-semibold">OR Number</label>
                        <input type="text" name="or_number" class="form-control rounded-pill" required>
                    </div>
                    <!-- Remarks -->
                    <div class="col-12">
                        <label for="remarks" class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control rounded-3" rows="3" placeholder="Optional..."></textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Save Payment
                    </button>
                    <a href="{{ route('cashier.payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
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
    document.addEventListener('DOMContentLoaded', function () {
        const studentSelect = document.getElementById('user_id');
        const scheduleSelect = document.getElementById('schedule_id');

        function filterSchedulesByStudent(studentId) {
            const optgroups = scheduleSelect.querySelectorAll('optgroup');
            let firstVisibleOption = null;

            // Hide all optgroups
            optgroups.forEach(group => group.style.display = 'none');

            // Show only matching student's group
            optgroups.forEach(group => {
                if (group.getAttribute('data-student') == studentId) {
                    group.style.display = 'block';

                    const visibleOptions = group.querySelectorAll('option');

                    if (visibleOptions.length === 1) {
                        // Auto-select if only one schedule exists
                        scheduleSelect.value = visibleOptions[0].value;
                    } else {
                        scheduleSelect.value = '';
                    }
                }
            });
        }

        studentSelect.addEventListener('change', function () {
            const studentId = this.value;
            filterSchedulesByStudent(studentId);
        });

        if (studentSelect.value) {
            filterSchedulesByStudent(studentSelect.value);
        }
    });
</script>
@endpush

