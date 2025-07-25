@extends('layouts.master')
@section('title', 'Payment Logs')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">📜 Payment Logs</h1>
        <div class="d-flex gap-2">
            <button id="downloadExcelBtn" class="btn btn-outline-success rounded-pill">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary rounded-pill">
                <i class="fas fa-arrow-left me-2"></i> Back to Payments
            </a>
        </div>
    </div>
    <div class="card shadow-sm rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Date Paid</th>
                            <th>Student</th>
                            <th>Course & Year</th>
                            <th>Room</th>
                            <th>Schedule</th>
                            <th>Amount (₱)</th>
                            <th>OR Number</th>
                            <th>Processed By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y H:i') }}</td>
                                <td>{{ $payment->student?->name ?? '—' }}</td>
                                <td>{{ $payment->student?->occupantProfile?->course_section ?? '—' }}</td>
                                <td>{{ $payment->student?->reservations->first()?->room?->name ?? '—' }}</td>
                                <td>{{ $payment->schedule?->name ?? '—' }}</td>
                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ $payment->or_number ?? '—' }}</td>
                                <td>{{ $payment->cashier?->name ?? 'System' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No payment history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $payments->links() }} <!-- Pagination -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('downloadExcelBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Download Excel',
            input: 'text',
            inputLabel: 'Enter file name',
            inputPlaceholder: 'e.g. payment_logs_july',
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'File name is required!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const fileName = encodeURIComponent(result.value);
                window.location.href = `{{ route('admin.payments.logs.export') }}?filename=${fileName}`;
            }
        });
    });
</script>
@endpush
