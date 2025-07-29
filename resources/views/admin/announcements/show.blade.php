@extends('layouts.master')
@section('title', 'View Announcement')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><i class="fas fa-bullhorn me-2 text-primary"></i>View Announcement</h4>
        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4" style="background-color: #eaf4ff;">
        <div class="card-body p-4">
            {{-- Title and Date --}}
            <div class="mb-4 border-bottom pb-2">
                <h4 class="fw-bold text-dark mb-1">
                    <i class="fas  me-2 text-info"></i>{{ $announcement->title }}
                </h4>
                <p class="text-muted mb-0">
                    <i class="fas fa-clock me-1"></i>
                    {{ $announcement->created_at->format('F j, Y \a\t h:i A') }}
                </p>
            </div>

            {{-- Message --}}
            <div class="mb-4">
                <label class="fw-semibold mb-2 d-block text-secondary">
                    <i class="fas fa-envelope-open-text me-1 text-warning"></i>Message
                </label>
                <div class="border-start border-4 border-warning bg-light p-3 rounded-3">
                    {!! nl2br(e($announcement->message)) !!}
                </div>
            </div>

            {{-- Audience --}}
            <div class="mb-4">
                <label class="fw-semibold mb-2 d-block text-secondary">
                    <i class="fas fa-users-cog me-1 text-success"></i>Audience
                </label>
                @php
                    $audienceText = [
                        'all_students' => ['label' => 'All Students', 'color' => 'success'],
                        'cashier' => ['label' => 'Cashier', 'color' => 'info'],
                        'selected_students' => ['label' => 'Selected Students', 'color' => 'warning'],
                    ];
                @endphp
                <span class="badge bg-{{ $audienceText[$announcement->audience]['color'] }} px-3 py-2 rounded-pill">
                    {{ $audienceText[$announcement->audience]['label'] }}
                </span>
            </div>

            {{-- Recipients --}}
            @if($announcement->audience === 'selected_students' && $announcement->users->count())
                <div class="mt-4">
                    <label class="fw-semibold mb-2 d-block text-secondary">
                        <i class="fas fa-user-check me-1 text-primary"></i>Recipients
                    </label>
                    <div class="border rounded-3">
                        <ul class="list-group list-group-flush">
                            @foreach($announcement->users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $user->name }}</span>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

