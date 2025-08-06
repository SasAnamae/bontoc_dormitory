@extends('layouts.master')
@section('title', 'Process Payment')

@section('content')
<div class="container py-4">
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
                    <div class="col-md-6">
                        <label for="user_id" class="form-label fw-semibold">Student</label>
                        <select name="user_id" id="userSelect" class="form-select rounded-pill" required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="paid_at" class="form-label fw-semibold">Date Paid</label>
                        <input type="datetime-local" name="paid_at" class="form-control rounded-pill" required>
                    </div>

                    <div class="col-md-6">
                        <label for="amount" class="form-label fw-semibold">Amount (₱)</label>
                        <input type="number" name="amount" class="form-control rounded-pill" step="0.01" required>
                    </div>

                    <div class="col-md-6">
                        <label for="or_number" class="form-label fw-semibold">OR Number</label>
                        <input type="text" name="or_number" class="form-control rounded-pill" required>
                    </div>

                    <div class="col-12">
                        <label for="remarks" class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control rounded-3" rows="3"></textarea>
                    </div>
                </div>

                <!-- View Application Link -->
                <div class="mt-3" id="viewApplicationContainer" style="display: none;">
                    <a id="viewApplicationLink" href="#" class="btn btn-outline-info btn-sm">
                        📄 View Application
                    </a>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-save me-2"></i> Save
                    </button>
                    <a href="{{ route('cashier.payments.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const studentsWithApplications = @json($students->filter(fn($s) => $s->applicationForm)->pluck('id'));

    document.getElementById('userSelect').addEventListener('change', function () {
        const userId = this.value;
        const link = document.getElementById('viewApplicationLink');
        const container = document.getElementById('viewApplicationContainer');

        if (studentsWithApplications.includes(parseInt(userId))) {
            link.href = `/cashier/application/${userId}`;
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
</script>
@endpush

