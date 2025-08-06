<li class="px-3 py-2 d-flex justify-content-between align-items-center">
    <span class="fw-bold text-primary">🔔 Notifications</span>
    @if(auth()->user()->notifications->count())
        <form action="{{ route('notifications.destroyAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-outline-danger rounded-pill">🗑 Clear All</button>
        </form>
    @endif
</li>

<li><hr class="dropdown-divider"></li>

@forelse(auth()->user()->notifications as $notification)
    <li class="px-2">
        <div class="d-flex justify-content-between align-items-start border rounded p-2 mb-2 {{ $notification->read_at ? 'bg-light' : 'bg-white shadow-sm' }}">
            <div class="flex-grow-1 me-2">
                <a href="{{ route('notifications.read', $notification->id) }}"
                   class="text-decoration-none {{ $notification->read_at ? 'text-muted' : 'fw-bold text-dark' }}">
                    <div class="small text-secondary">
                        {{ $notification->data['message'] ?? 'No message' }}
                    </div>
                    @if(isset($notification->data['student_name']))
                        <div class="small text-muted">From: {{ $notification->data['student_name'] }}</div>
                    @endif
                    <div class="small text-muted mt-1">{{ $notification->created_at->diffForHumans() }}</div>
                </a>
            </div>

            <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="ms-1">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-link text-danger p-0" style="font-size: 0.9rem;" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </li>
@empty
    <li>
        <span class="dropdown-item text-muted small">No notifications yet</span>
    </li>
@endforelse

</ul>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchNotifications() {
        $.ajax({
            url: "{{ route('notifications.fetch') }}",
            method: 'GET',
            success: function (response) {
                $('#notificationBadge').toggleClass('d-none', response.count === 0);
                $('#notificationBadge').text(response.count);
                $('#notificationList').html(response.html);
            },
            error: function (xhr) {
                console.error("Notification fetch failed", xhr);
            }
        });
    }
</script>