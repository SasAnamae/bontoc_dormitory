@extends('layouts.master')
@section('title', 'Payments Management')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">📦 Payments Submitted</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.logs') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                <i class="fas fa-clock me-1"></i> View Logs
            </a>
            <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </div>
    </div>

    @if($payments->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Occupant</th>
                    <th>Months</th>
                    <th>Amount</th>
                    <th>Dorm Fee</th>
                    <th>Appliances</th>
                    <th>Appliance Fee</th>
                    <th>OR Number</th>
                    <th>Paid At</th>
                    <th>Receipt</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->payment_month }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>₱{{ number_format($payment->dorm_fee, 2) }}</td>
                    <td>{{ $payment->appliances }}</td>
                    <td>₱{{ number_format($payment->appliance_fee, 2) }}</td>
                    <td>{{ $payment->or_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') }}</td>
                    <td>
                        @if($payment->receipt_photo)
                            <a href="{{ $payment->receipt_photo }}" target="_blank">
                                <img src="{{ $payment->receipt_photo }}" alt="Receipt" width="100">
                            </a>
                        @else
                            <span class="text-muted">No receipt uploaded</span>
                        @endif
                    <td>
                        <span class="badge bg-{{ $payment->status === 'verified' ? 'success' : ($payment->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>
                        @if($payment->status === 'pending')
                            <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">Verify</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
            No payment submissions found.
        </div>
    @endif
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
            inputPlaceholder: 'e.g. admin_payments_august',
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) return 'File name is required!';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const fileName = encodeURIComponent(result.value);
                window.location.href = `{{ route('admin.payments.export') }}?filename=${fileName}`;
            }
        });
    });
</script>
@endpush


