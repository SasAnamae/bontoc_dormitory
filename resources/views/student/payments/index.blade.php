@extends('layouts.master')
@section('title', 'My Payments')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">💳 My Payment History</h4>
        <form id="downloadForm" action="{{ route('student.payments.download') }}" method="GET">
            <input type="hidden" id="filenameInput" name="filename" value="my_payments_log">
            <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill d-flex align-items-center">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </form>
    </div>

    @if($schedules->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Schedule</th>
                    <th>Base Rate</th>
                    <th>Appliance Fee</th>
                    <th>Total Due</th>
                    <th>Total Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedules as $i => $schedule)
                    @php
                        $pivot = $schedule->students->firstWhere('id', auth()->id())?->pivot;
                        $baseRate = $schedule->rate;
                        $applianceFee = $pivot?->additional_fee ?? 0;
                        $totalDue = $pivot?->total_due ?? ($baseRate + $applianceFee);
                        $totalPaid = $schedule->payments->where('user_id', auth()->id())->sum('amount');
                        $balance = max($totalDue - $totalPaid, 0);

                        if ($totalPaid >= $totalDue) {
                            $status = 'Paid';
                            $badge = 'success';
                        } elseif ($totalPaid > 0 && now()->lt($schedule->due_date)) {
                            $status = 'Partial';
                            $badge = 'warning';
                        } elseif (now()->gt($schedule->due_date) && $totalPaid < $totalDue) {
                            $status = 'Overdue';
                            $badge = 'danger';
                        } else {
                            $status = 'Pending';
                            $badge = 'secondary';
                        }
                    @endphp

                    <tr class="{{ $status === 'Overdue' ? 'table-danger' : '' }}">
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $schedule->name }}</td>
                        <td>₱{{ number_format($baseRate, 2) }}</td>
                        <td>₱{{ number_format($applianceFee, 2) }}</td>
                        <td>₱{{ number_format($totalDue, 2) }}</td>
                        <td>₱{{ number_format($totalPaid, 2) }}</td>
                        <td>₱{{ number_format($balance, 2) }}</td>
                        <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                    </tr>

                    @if($schedule->payments->where('user_id', auth()->id())->count())
                    <tr>
                        <td colspan="8" class="p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="text-center">OR Number</th>
                                            <th>Amount</th>
                                            <th>Paid At</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schedule->payments->where('user_id', auth()->id())->sortByDesc('paid_at') as $payment)
                                            <tr>
                                                <td class="text-center">{{ $payment->or_number ?? '—' }}</td>
                                                <td>₱{{ number_format($payment->amount, 2) }}</td>
                                                <td>{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y H:i') : '—' }}</td>
                                                <td>{{ $payment->remarks ?? '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info text-center mt-4 rounded-pill shadow-sm">
        No payment logs found.
    </div>
    @endif
</div>

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
@endsection

