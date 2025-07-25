@extends('layouts.master')
@section('title', 'View All Occupants')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">👥 Occupant Payments</h4>
        <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill">
            <i class="fas fa-file-excel me-1"></i> Download
        </button>
    </div>

    @if($occupants->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Room Reserved</th>
                    <th>Total Due</th>
                    <th>Total Paid</th>
                    <th>Balance</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($occupants as $student)
                    @foreach($student->paymentSchedules as $schedule)
                        @php
                            $pivot = $schedule->pivot;
                            $additionalFee = $pivot->additional_fee ?? 0;
                            $baseRate = $schedule->rate;
                            $totalDue = $pivot->total_due ?? ($baseRate + $additionalFee);
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
                            $reservation = $student->reservations->first();
                            $roomName = $reservation?->room?->name;
                            $dormName = $reservation?->room?->dormitory?->name;
                            $roomDisplay = $roomName ? "$roomName - $dormName" : 'No Reservation';
                        @endphp
                        <tr>
                            <td class="fw-semibold">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->occupantProfile->course_section ?? '—' }}</td>
                            <td><span class="text-muted">{{ $roomDisplay }}</span></td>
                            <td>₱{{ number_format($totalDue, 2) }}</td>
                            <td>₱{{ number_format($totalPaid, 2) }}</td>
                            <td>₱{{ number_format($balance, 2) }}</td>
                            <td><span class="badge bg-{{ $badge }}">{{ $status }}</span></td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No approved occupants found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
        No occupants found.
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
            inputPlaceholder: 'e.g. occupant_payments_july',
            showCancelButton: true,
            confirmButtonText: 'Download',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) return 'File name is required!';
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const fileName = encodeURIComponent(result.value);
                window.location.href = `{{ route('cashier.occupants.export') }}?filename=${fileName}`;
            }
        });
    });
</script>
@endpush

