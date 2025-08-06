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
            <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </div>
    </div>

    @if($students->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Student</th>
                    <th>Course & Year</th>
                    <th>Room</th>
                    <th>Total Payments</th>
                    <th>Latest OR No.</th>
                    <th>Latest Payment</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        $totalPaid = $student->payments->sum('amount');
                        $latest = $student->payments->sortByDesc('paid_at')->first();
                    @endphp
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->applicationForm->course?? '—' }}-{{ $student->applicationForm->year_section?? '—' }}</td>
                        <td>{{ $student->reservations->first()?->room?->name ?? '—' }}</td>
                        <td>₱{{ number_format($totalPaid, 2) }}</td>
                        <td>{{ $latest?->or_number ?? '—' }}</td>
                        <td>{{ $latest?->paid_at ? \Carbon\Carbon::parse($latest->paid_at)->format('M d, Y') : '—' }}</td>
                        <td>{{ $latest?->remarks ?? '—' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
            No student payments found.
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

