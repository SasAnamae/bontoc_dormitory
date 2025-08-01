@extends('layouts.master')
@section('title', 'Edit Payment')
@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">✏️ Edit Payment</h1>
        <a href="{{ route('cashier.payments.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Payments
        </a>
    </div>
    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <form action="{{ route('cashier.payments.update', $payment->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <!-- Student -->
                    <div class="col-md-6">
                        <label for="user_id" class="form-label fw-semibold">Student</label>
                        <select name="user_id" id="user_id" class="form-select rounded-pill" required>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $payment->user_id == $student->id ? 'selected' : '' }}>
                                    {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Payment Schedule -->
                    <div class="col-md-6">
                        <label for="schedule_id" class="form-label fw-semibold">Payment Schedule</label>
                        <select name="schedule_id" id="schedule_id" class="form-select rounded-pill" required>
                            @foreach($schedules as $schedule)
                                <option value="{{ $schedule->id }}" {{ $payment->schedule_id == $schedule->id ? 'selected' : '' }}>
                                    {{ $schedule->name }} (₱{{ number_format($schedule->rate, 2) }}) - Due {{ \Carbon\Carbon::parse($schedule->due_date)->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Amount -->
                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
                        <input type="number" name="amount" class="form-control rounded-pill" step="0.01" required value="{{ $payment->amount }}">
                    </div>
                    <!-- OR Number -->
                    <div class="col-md-6">
                        <label for="or_number" class="form-label fw-semibold">OR Number</label>
                        <input type="text" name="or_number" class="form-control rounded-pill" required value="{{ old('or_number', $payment->or_number) }}">
                    </div>
                    <!-- Remarks -->
                    <div class="col-12">
                        <label for="remarks" class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control rounded-3" rows="3">{{ $payment->remarks }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Update Payment
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

