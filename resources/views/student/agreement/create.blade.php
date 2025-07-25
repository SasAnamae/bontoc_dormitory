@extends('layouts.master')
@section('title', 'Dormitory Agreement Form')
@section('content')
<div class="container mt-5">
    <div class="card shadow-sm rounded-4">
        <div class="card-body p-4">
            <h1 class="h4 fw-bold text-primary mb-3">📝 Dormitory Agreement Form</h1>
            <p class="text-muted mb-4">Please read carefully and confirm your agreement below after completing your Occupant’s Profile.</p>

            <form action="{{ route('student.agreement.store') }}" method="POST">
                @csrf

                @include('student.agreement.form', ['agreement' => null])
            </form>
        </div>
    </div>
</div>
@endsection
