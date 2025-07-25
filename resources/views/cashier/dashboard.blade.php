@extends('layouts.master')

@section('title', 'Cashier Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold text-primary">Welcome, {{ Auth::user()->name }}</h1>
    <p class="text-muted">Manage student payments and view summary statistics.</p>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('cashier.dashboard') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="month" class="form-select rounded-pill" required>
                @foreach(range(1, 12) as $m)
                    <option value="{{ $m }}" {{ $m == $selectedMonth ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="year" class="form-select rounded-pill" required>
                @foreach(range(date('Y') - 5, date('Y') + 1) as $y)
                    <option value="{{ $y }}" {{ $y == $selectedYear ? 'selected' : '' }}>
                        {{ $y }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary rounded-pill w-100">
                <i class="fas fa-filter me-1"></i> Filter
            </button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Registered Students</h5>
                    <h2 class="fw-bold">{{ $registeredStudents }}</h2>
                    <p class="text-muted mb-0">As of {{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Paid</h5>
                    <h2 class="fw-bold">{{ $studentsPaid }}</h2>
                    <p class="text-muted mb-0">Selected Period</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Not Paid</h5>
                    <h2 class="fw-bold">{{ $studentsNotPaid }}</h2>
                    <p class="text-muted mb-0">Selected Period</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body text-center">
                    <h5 class="card-title text-warning">Total Collected</h5>
                    <h2 class="fw-bold">₱{{ number_format($monthlyTotal, 2) }}</h2>
                    <p class="text-muted mb-0">Selected Period</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
