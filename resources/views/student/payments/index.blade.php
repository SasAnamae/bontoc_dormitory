@extends('layouts.master')
@section('title', 'My Payments')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">💳 My Payment History</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('student.payments.create') }}" class="btn btn-sm btn-primary rounded-pill">
                <i class="fas fa-plus-circle me-1"></i> Pay
            </a>
            <form id="downloadForm" action="{{ route('student.payments.download') }}" method="GET">
                <input type="hidden" id="filenameInput" name="filename" value="my_payments_log">
                <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill d-flex align-items-center">
                    <i class="fas fa-file-excel me-1"></i> Download
                </button>
            </form>
        </div>
    </div>

    @if($payments->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>For Month Of</th>
                    <th>Amount</th>
                    <th>Dorm Fee</th>
                    <th>Appliances Fee</th>
                    <th>OR Number</th>
                    <th>Paid At</th>
                    <th>Receipt</th>
                    <th>Remarks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $i => $payment)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $payment->payment_month ?? '—' }}</td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td>₱500.00</td>
                        <td>{{ $payment->appliance_fee ?? '—' }}</td>
                        <td>{{ $payment->or_number ?? '—' }}</td>
                        <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y H:i') : '—' }}</td>
                        <td>
                          @if($payment->receipt_photo)
                                <a href="{{ $payment->receipt_photo }}" target="_blank">
                                    <img src="{{ $payment->receipt_photo }}" alt="Receipt" width="50">
                                </a>
                            @else
                                <p>No receipt uploaded.</p>
                            @endif
                        </td>
                        <td>{{ $payment->remarks ?? '—' }}</td>
                        <td>
                            <span class="badge bg-success">
                                {{ ucfirst($payment->status ?? 'Confirmed') }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $payments->links() }}
    </div>
    @else
    <div class="alert alert-info text-center mt-4 rounded-pill shadow-sm">
        No payment logs found.
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
            inputPlaceholder: 'e.g. my_payments',
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
                window.location.href = `{{ route('student.payments.download') }}?filename=${fileName}`;
            }
        });
    });
</script>
@endpush

