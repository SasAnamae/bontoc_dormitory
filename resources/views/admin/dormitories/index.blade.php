@extends('layouts.master')

@section('title', 'Dormitories')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary mb-0">🏠 Dormitories</h3>
        <a href="{{ route('admin.dormitories.create') }}" class="btn btn-sm btn-success rounded-pill">
            <i class="fas fa-plus"></i> Dormitory
        </a>
    </div>
    <div class="card shadow rounded-4 mx-auto" style="max-width: 800px;">
        <div class="table-responsive">
            <table class="table table-hover table-sm align-middle mb-0 text-center">
                <thead class="table-dark">
                    <tr>
                        <th class="py-2 px-3">Dormitory</th>
                        <th class="py-2">Photo</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dormitories as $dorm)
                    <tr>
                        <td class="fw-semibold">{{ $dorm->name }}</td>
                        <td>
                            @if($dorm->photo)
                            <img src="data:image/jpeg;base64,{{ $dorm->photo }}" class="rounded shadow-sm" style="width: 70px; height: 50px; object-fit: cover;">
                            @else
                            <span class="text-muted small">No Photo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.dormitories.edit', $dorm->id) }}" class="btn btn-sm btn-outline-primary rounded-pill me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.dormitories.destroy', $dorm->id) }}" method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        Swal.fire({
            title: 'Delete this dormitory?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then(result => {
            if (result.isConfirmed) btn.closest('form').submit();
        });
    });
});
</script>
@endsection
