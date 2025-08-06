@extends('layouts.master') {{-- or your student layout --}}

@section('title', 'My Reports')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between mb-3">
        <h4 class="h3 fw-bold text-primary mb-0">📋 Reports</h4>
        <a href="{{ route('student.report.create') }}" class="btn btn-sm btn-success rounded-pill">
            <i class="fas fa-plus-circle"></i> New Report
        </a>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        </script>
    @endif
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @forelse ($reports as $report)
            <div class="col">
                <div class="card shadow-sm rounded-4 border-0 h-100" style="background-color: #e7f1fb;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title mb-0">{{ $report->title }}</h5>
                            <div class="d-flex gap-1">
                                <a href="{{ route('student.report.show', $report->id) }}" class="btn btn-sm btn-outline-primary rounded-pill" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('student.report.destroy', $report->id) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger rounded-pill delete-button" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <p class="text-muted small mb-1"><strong>Status:</strong> 
                            <span class="badge bg-{{ 
                                $report->status === 'Resolved' ? 'success' : 
                                ($report->status === 'In Progress' ? 'warning' : 'secondary') 
                            }}">
                                {{ $report->status }}
                            </span>
                        </p>

                        <p class="card-text small">{{ Str::limit($report->message, 150) }}</p>

                        <p class="text-muted small mb-0">Submitted: {{ $report->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info rounded-pill text-center shadow-sm mt-4">
               You haven’t submitted any reports yet.
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('scripts')
<script>
    // SweetAlert Delete Handler
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');
            Swal.fire({
                title: 'Delete Report?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush

