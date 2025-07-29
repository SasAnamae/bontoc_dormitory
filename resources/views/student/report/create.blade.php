@extends('layouts.master')

@section('title', 'Submit Report')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-primary mb-0">📋 Submit Report</h1>
        <a href="{{ route('student.report.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-2"></i> Back to Reports
        </a>
    </div>

    <div class="card shadow-sm rounded-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4">
            <form action="{{ route('student.report.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <!-- Report Title -->
                    <div class="col-12">
                        <label for="title" class="form-label fw-semibold">Report Title</label>
                        <input type="text" name="title" id="title" class="form-control rounded-pill" required>
                    </div>

                    <!-- Message -->
                    <div class="col-12">
                        <label for="message" class="form-label fw-semibold">Message</label>
                        <textarea name="message" id="message" rows="5" class="form-control rounded-3" required></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <button type="submit" class="btn btn-success rounded-pill px-4">
                        <i class="fas fa-paper-plane me-2"></i> Submit Report
                    </button>
                    <a href="{{ route('student.report.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

