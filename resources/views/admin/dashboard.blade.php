@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Welcome, {{ Auth::user()->name }}</h1>

    <div class="row">
        <!-- Total Dormitories -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body text-center">
                    <h5 class="card-title text-primary">Dormitories</h5>
                    <h2 class="card-text fw-bold">{{ $dormitoriesCount }}</h2>
                    <p class="mb-0 text-muted">Total</p>
                </div>
            </div>
        </div>

        <!-- Total Rooms -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body text-center">
                    <h5 class="card-title text-success">Rooms</h5>
                    <h2 class="card-text fw-bold">{{ $roomsCount }}</h2>
                    <p class="mb-0 text-muted">Available</p>
                </div>
            </div>
        </div>

        <!-- Available Beds -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-secondary">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary">Available Beds</h5>
                    <h2 class="card-text fw-bold">{{ $availableBeds }}</h2>
                    <p class="mb-0 text-muted">Beds Open</p>
                </div>
            </div>
        </div>

        <!-- Pending Reservations -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-info">
                <div class="card-body text-center">
                    <h5 class="card-title text-info">Pending Reservations</h5>
                    <h2 class="card-text fw-bold">{{ $reservationsCount }}</h2>
                    <p class="mb-0 text-muted">Pending</p>
                </div>
            </div>
        </div>

        <!-- Occupants Currently Living -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-secondary">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary">Occupants</h5>
                    <h2 class="card-text fw-bold">{{ $occupantsCount }}</h2>
                    <p class="mb-0 text-muted">Currently Living</p>
                </div>
            </div>
        </div>

        <!-- Monthly Payments -->
        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-danger">
                <div class="card-body text-center">
                    <h5 class="card-title text-danger">Monthly Payments</h5>
                    <h2 class="card-text fw-bold">
                        ₱{{ isset($monthlyPayments) ? number_format($monthlyPayments, 2) : '0.00' }}
                    </h2>
                    <p class="mb-0 text-muted">This Month</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
