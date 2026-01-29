<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3 mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Event RSVP</a>
        <a href="{{ url('/student/dashboard') }}" class="btn btn-light btn-sm text-primary">Back to Dashboard</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Upcoming Events</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($events as $event)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title text-primary mb-0">{{ $event->title }}</h5>
                        <small class="text-muted">{{ $event->event_date }}</small>
                    </div>
                    
                    <p class="card-text">{{ $event->description }}</p>
                    <p class="small text-muted">📍 {{ $event->location }}</p>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            @if(Auth::user()->eventsAttending->contains($event->event_id))
                                <span class="badge bg-success">✅ You are going!</span>
                            @else
                                <span class="badge bg-secondary">Not Registered</span>
                            @endif
                        </div>

                        <form action="{{ url('/student/events/'.$event->event_id.'/rsvp') }}" method="POST">
                            @csrf
                            @if(Auth::user()->eventsAttending->contains($event->event_id))
                                <button type="submit" class="btn btn-outline-danger btn-sm">Cancel RSVP</button>
                            @else
                                <button type="submit" class="btn btn-primary btn-sm">Attend Event</button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-muted">No events found.</p>
        </div>
        @endforelse
    </div>
</div>

</body>
</html>