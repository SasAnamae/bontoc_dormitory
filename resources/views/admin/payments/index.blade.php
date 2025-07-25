@extends('layouts.master')

@section('title', 'Payments Management')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">📦 Payments Overview</h4>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.logs') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                <i class="fas fa-clock me-1"></i> View Logs
            </a>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-sm btn-success rounded-pill">
                <i class="fas fa-plus me-1"></i> New Payment Schedule
            </a>
            <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </div>
    </div>
    @if($paymentSchedules->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Student</th>
                    <th>Course & Year</th>
                    <th>Room</th>
                    <th>Schedule</th>
                    <th>Rate</th>
                    <th>Appliance Fee</th>
                    <th>Total Due</th>
                    <th>Total Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                    <th>OR No.</th>
                    <th>Paid At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentSchedules as $schedule)
                    @foreach($schedule->students as $student)
                        @php
                            $pivot = $student->pivot;
                            $additionalFee = $pivot->additional_fee ?? 0;
                            $baseRate = $schedule->rate;
                            $totalDue = $pivot->total_due ?? $baseRate + $additionalFee;
                            $payments = $student->payments->where('schedule_id', $schedule->id);
                            $totalPaid = $payments->sum('amount');
                            $balance = max($totalDue - $totalPaid, 0);

                            $status = 'Pending';
                            $badge = 'secondary';

                            if ($totalPaid >= $totalDue) {
                                $status = 'Paid';
                                $badge = 'success';
                            } elseif ($totalPaid > 0) {
                                $status = 'Partial';
                                $badge = 'info';
                            } elseif (now()->gt($schedule->due_date)) {
                                $status = 'Overdue';
                                $badge = 'danger';
                            }

                            $latestPayment = $payments->sortByDesc('paid_at')->first();
                        @endphp
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->occupantProfile->course_section ?? '—' }}</td>
                            <td>{{ $student->reservations->first()?->room?->name ?? '—' }}</td>
                            <td>{{ $schedule->name }}</td>
                            <td>₱{{ number_format($baseRate, 2) }}</td>
                            <td>₱{{ number_format($additionalFee, 2) }}</td>
                            <td>₱{{ number_format($totalDue, 2) }}</td>
                            <td>₱{{ number_format($totalPaid, 2) }}</td>
                            <td>₱{{ number_format($balance, 2) }}</td>
                            <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                            <td>{{ $latestPayment?->or_number ?? '—' }}</td>
                            <td>{{ $latestPayment?->paid_at ? \Carbon\Carbon::parse($latestPayment->paid_at)->format('M d, Y') : '—' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.payments.destroy', $schedule->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-btn">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
            No schedules or student payments found.
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Are you sure?',
                text: "This payment schedule will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.getElementById('downloadExcelBtn').addEventListener('click', function () {
        Swal.fire({
            title: 'Download Excel',
            input: 'text',
            inputLabel: 'Enter file name',
            inputPlaceholder: 'e.g. admin_payments_july',
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
