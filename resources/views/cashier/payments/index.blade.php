@extends('layouts.master')
@section('title', 'Process Payments')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('cashier.payments.create') }}" class="btn btn-success rounded-pill">
            <i class="fas fa-plus"></i> New Payment
        </a>
        <form action="{{ route('cashier.payments.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-1">
            <input type="text" name="name" class="form-control form-control-sm rounded-pill" placeholder="Student Name" value="{{ request('name') }}" style="max-width: 160px;">
            <input type="text" name="or_number" class="form-control form-control-sm rounded-pill" placeholder="OR Number" value="{{ request('or_number') }}" style="max-width: 140px;">
            <button type="submit" class="btn btn-sm btn-primary rounded-pill d-flex align-items-center">
                <i class="fas fa-search me-1"></i> Search
            </button>
             <button type="button" id="downloadExcelBtn" class="btn btn-sm btn-outline-success rounded-pill d-flex align-items-center">
                <i class="fas fa-file-excel me-1"></i> Download
            </button>
        </form>
    </div>

    @if($payments->count())
    <div class="table-responsive shadow rounded-4">
        <table class="table table-striped align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>OR Number</th>
                    <th>Amount</th>
                    <th>Paid At</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->user->name }}</td>
                    <td>{{ $payment->or_number }}</td>
                    <td>₱{{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : '—' }}</td>
                    <td>{{ $payment->remarks ?? '—' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('cashier.payments.edit', $payment->id) }}" class="btn btn-sm btn-primary rounded-pill">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('cashier.payments.destroy', $payment->id) }}" method="POST" class="d-inline delete-payment-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger rounded-pill delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
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
    <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
        No payments found.
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
            inputPlaceholder: 'e.g. payments_july',
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
                window.location.href = `{{ route('cashier.payments.download') }}?filename=${fileName}`;
            }
        });
    });
</script>
@endpush