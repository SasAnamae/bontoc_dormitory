@extends('layouts.master')
@section('title', 'Show Payment')

@section('content')
<div class="container mt-5">
    <h4 class="mb-3">🧾 Payment Details</h4>
    <div class="card shadow p-4">
        <p><strong>Student:</strong> {{ $payment->user->name }}</p>
        <p><strong>For Month Of:</strong> {{ $payment->payment_month }}</p>
        <p><strong>Amount:</strong> ₱{{ number_format($payment->amount) }}</p>
        <p><strong>Dorm Fee:</strong> ₱{{ number_format($payment->dorm_fee, 2) }}</p>
        <p><strong>Appliances Fee:</strong> ₱{{ number_format($payment->appliance_fee, 2) }}</p>
        <p><strong>Paid Date:</strong> {{ \Carbon\Carbon::parse($payment->paid_at)->format('F d, Y') }}</p>
        <p><strong>OR Number:</strong> {{ $payment->or_number }}</p>

        <p><strong>Receipt:</strong></p>
        @if($payment->receipt_photo)
            <a href="data:image/png;base64,{{ $payment->receipt_photo }}" target="_blank">
                <img src="data:image/png;base64,{{ $payment->receipt_photo }}" alt="Receipt" width="200">
            </a>
        @endif

        <p><strong>Status:</strong> 
            @if($payment->status == 'pending')
                <span class="badge bg-warning">Pending</span>
            @elseif($payment->status == 'approved')
                <span class="badge bg-success">Approved</span>
            @else
                <span class="badge bg-danger">Rejected</span>
            @endif
        </p>

        @if($payment->status == 'pending')
        <div class="mt-4 d-flex gap-2">
            <form method="POST" action="{{ route('admin.payments.approve', $payment->id) }}">
                @csrf
                <button class="btn btn-success" onclick="return confirm('Approve this payment?')">✅ Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.payments.reject', $payment->id) }}">
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Reject this payment?')">❌ Reject</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection

