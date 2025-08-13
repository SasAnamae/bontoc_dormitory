@extends('layouts.master')

@section('title', 'Payments')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">📦 Payments Submitted</h4>
        <div class="d-flex gap-2">
            <!-- <a href="{{ route('admin.payments.logs') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                <i class="fas fa-clock me-1"></i> View Logs
            </a> -->
            <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Student</th>
                    <th>Month</th>
                    <th>Amount Paid</th>
                    <th>Room & Dormitory</th>
                    <th>Appliances</th>
                    <th>Appliance Fee</th>
                    <th>Expected Total</th>
                    <th>Balance</th>
                    <th>O.R. Number</th>
                    <th>Paid At</th>
                    <th>Receipt</th>
                    <th>Verification Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->payment_month }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->room_name ? "{$payment->room_name} - {$payment->dorm_name}" : 'No Reservation' }}</td>
                    <td>{{ $payment->appliances }}</td>
                    <td>₱{{ number_format($payment->appliance_fee, 2) }}</td>
                    <td>₱{{ number_format(500 + ($payment->appliance_fee ?? 0), 2) }}</td>
                    <td>
                        <span class="fw-bold text-{{ $payment->balance > 0 ? ($payment->payment_status === 'Overdue' ? 'danger' : 'warning') : 'success' }}">
                            ₱{{ number_format($payment->balance, 2) }}
                        </span>
                    </td>
                    <td>{{ $payment->or_number }}</td>
                    <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : '—' }}</td>
                    <td>
                        @if($payment->receipt_photo)
                            <a href="{{ $payment->receipt_photo }}" target="_blank">
                                <img src="{{ $payment->receipt_photo }}" alt="Receipt" width="50">
                            </a>
                        @else
                            <span class="text-muted">No receipt uploaded</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $payment->status === 'verified' ? 'success' : ($payment->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $payment->payment_status === 'Paid' ? 'success' : ($payment->payment_status === 'Overdue' ? 'danger' : 'warning') }}">
                            {{ $payment->payment_status }}
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

    {{ $payments->links() }}
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


