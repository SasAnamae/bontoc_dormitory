@extends('layouts.master')

@section('title', 'Submit Payment')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold text-primary mb-4">💸 Submit Payment</h4>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    <form action="{{ route('student.payments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Form 1: Payment Info -->
            <div class="col-md-6">
                <div class="border p-4 rounded shadow-sm mb-3">
                    <h6 class="fw-bold mb-3">Payment Details</h6>

                    <!-- Occupant Name (Readonly) -->
                    <div class="mb-3">
                        <label class="form-label">Occupant Name</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>

                   <!-- Payment for the Month -->
                    <div class="mb-3">
                        <label class="form-label">Payment for the Month(s)</label>
                        <div class="row">
                            @php
                                $months = [
                                    'January', 'February', 'March', 'April', 'May', 'June',
                                    'July', 'August', 'September', 'October', 'November', 'December'
                                ];
                            @endphp
                            @foreach ($months as $month)
                                <div class="col-6 col-md-4">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="months[]"
                                            value="{{ $month }}"
                                            id="month_{{ $month }}"
                                            {{ is_array(old('months')) && in_array($month, old('months')) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="month_{{ $month }}">
                                            {{ $month }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @error('months')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="mb-3">
                        <label class="form-label">Amount (₱)</label>
                        <input type="number" name="amount" class="form-control" step="0.01" required>
                    </div>

                    <!-- Dorm Fee -->
                    <div class="mb-3">
                        <label for="dorm_fee" class="form-label">Dormitory Rental Fee</label>
                        <input
                            type="number"
                            step="0.01"
                            name="dorm_fee"
                            id="dorm_fee"
                            class="form-control @error('dorm_fee') is-invalid @enderror"
                            value="{{ old('dorm_fee', 500) }}" {{-- default to 500 --}}
                            required
                        >
                        @error('dorm_fee')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Appliances -->
                    <div class="mb-3">
                        <label class="form-label">Appliances Used</label>
                        <textarea name="appliances" class="form-control" rows="3" placeholder="List appliances used..." required></textarea>
                    </div>
                   
                    <!-- Appliances_fee -->
                    <div class="mb-3">
                        <label class="form-label">Appliance Fee (₱)</label>
                        <input type="number" name="appliance_fee" class="form-control" step="0.01" required>
                    </div>
                    
                    <!-- Noted & Received By -->
                    <div class="mt-4">
                        <p class="mb-1"><strong>Noted by:</strong> KATHLYN Y. MORALES<br><small class="text-muted">Dorm Adviser</small></p>
                        <p><strong>Received by:</strong> GRACE MAYE O. OBBUS<br><small class="text-muted">Cashier-Designated</small></p>
                    </div>
                </div>
            </div>

            <!-- Form 2: Receipt -->
            <div class="col-md-6">
                <div class="border p-4 rounded shadow-sm mb-3">
                    <h6 class="fw-bold mb-3">Payment Proof</h6>

                    <!-- OR Number -->
                    <div class="mb-3">
                        <label class="form-label">Official Receipt Number</label>
                        <input type="text" name="or_number" class="form-control" required>
                    </div>

                    <!-- Paid Date -->
                    <div class="mb-3">
                        <label class="form-label">Paid At</label>
                        <input type="datetime-local" name="paid_at" class="form-control" required>
                    </div>

                    <!-- Receipt Photo -->
                    <div class="mb-3">
                        <label class="form-label">Upload Receipt (Image Only)</label>
                        <input type="file" name="receipt_photo" class="form-control" accept="image/*" required>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100">
                            Submit Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Hardcoded Appliance Table -->
    <div class="mt-5">
        <h6 class="fw-bold mb-3">📌 Dormitory Rental & Appliance Fee Table</h6>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Item</th>
                        <th>Rate (₱)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Dormitory Rental</td><td>500.00</td></tr>
                    <tr><td>Electricity - Laptop</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Rice Cooker</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Electric Fan</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Iron</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Heater</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Teapot</td><td>50.00/month</td></tr>
                    <tr><td>Electricity - Cellphone</td><td>20.00/month</td></tr>
                    <tr><td>Electricity - Power Bank</td><td>20.00/month</td></tr>
                    <tr><td>Electricity - Rechargeable Fan</td><td>20.00/month</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

