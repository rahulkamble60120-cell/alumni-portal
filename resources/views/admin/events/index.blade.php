<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Events | Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #0d2c56; --accent-color: #d4af37; --bg-light: #f4f6f9; }
        body { font-family: 'Open Sans', sans-serif; background-color: var(--bg-light); overflow-x: hidden; }
        h1, h2, h3, h4, h5 { font-family: 'Montserrat', sans-serif; font-weight: 700; }
        .sidebar { background: linear-gradient(180deg, #0d2c56 0%, #05162b 100%); min-height: 100vh; width: 260px; position: fixed; color: white; z-index: 1000; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-left: 4px solid transparent; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.05); border-left: 4px solid var(--accent-color); }
        .main-content { margin-left: 260px; padding: 30px; }
        .custom-card { background: white; border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 25px; }
        .card-header-navy { background-color: var(--primary-color); color: white; padding: 15px 20px; font-weight: 600; }
        .event-item { border-left: 5px solid var(--accent-color); transition: transform 0.2s; }
        .event-item:hover { transform: translateX(5px); }
        .date-box { background: #f8f9fa; border-radius: 8px; padding: 10px; text-align: center; min-width: 70px; border: 1px solid #e9ecef; }
        .date-day { font-size: 1.5rem; font-weight: 700; line-height: 1; color: var(--primary-color); }
        .date-month { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; }
        .btn-navy { background-color: var(--primary-color); color: white; border-radius: 8px; padding: 10px; width: 100%; border: none; }
        .btn-navy:hover { background-color: #05162b; color: white; }
        @media (max-width: 768px) { .sidebar { width: 70px; } .main-content { margin-left: 70px; } .nav-link span { display: none; } }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="p-4 text-center border-bottom border-secondary border-opacity-25">
        <h4 class="m-0 text-white"><i class="fas fa-university me-2"></i>Admin</h4>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item"><a href="{{ url('/admin/dashboard') }}" class="nav-link"><i class="fas fa-th-large me-2"></i> <span>Dashboard</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/staff') }}" class="nav-link"><i class="fas fa-users-cog me-2"></i> <span>Manage Staff</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/events') }}" class="nav-link active"><i class="fas fa-calendar-check me-2"></i> <span>Events</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/news') }}" class="nav-link"><i class="fas fa-newspaper me-2"></i> <span>News</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/gallery') }}" class="nav-link"><i class="fas fa-images me-2"></i> <span>Gallery</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/jobs') }}" class="nav-link"><i class="fas fa-briefcase me-2"></i> <span>Jobs</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/alumni') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> <span>Alumni</span></a></li>
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span></a></li>
    </ul>
</nav>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Events</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-header-navy d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-alt me-2"></i> Upcoming Events</span>
                    @if(isset($events))
                        <span class="badge bg-light text-dark rounded-pill">{{ count($events) }} Events</span>
                    @endif
                </div>
                <div class="p-3">
                    @if(isset($events) && count($events) > 0)
                        @foreach($events as $event)
                        <div class="card mb-3 event-item shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="date-box me-3">
                                        <div class="date-day">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                        <div class="date-month">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h5 class="fw-bold mb-1">{{ $event->title }}</h5>
                                        <span class="badge bg-secondary mb-2">{{ ucfirst($event->type) }}</span>
                                        <div class="text-muted small mb-2">
                                            <i class="fas fa-map-marker-alt me-1 text-danger"></i> {{ $event->location ?? 'Campus Hall' }}
                                            <span class="mx-2">|</span>
                                            <i class="fas fa-clock me-1 text-primary"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                                        </div>
                                        <p class="mb-0 text-secondary small">{{ Str::limit($event->description, 100) }}</p>
                                    </div>
                                    <div class="ms-3">
                                        {{-- Delete Button --}}
                                        <button class="btn btn-outline-danger btn-sm rounded-circle"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i>
                            <p>No events scheduled yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-plus-circle me-2"></i> Create Event</div>
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/admin/events') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Event Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Annual Reunion 2024" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Event Type</label>
                            <select name="type" class="form-select" required>
                                <option value="" selected disabled>Select Type...</option>
                                <option value="reunion">Reunion</option>
                                <option value="webinar">Webinar</option>
                                <option value="workshop">Workshop</option>
                                <option value="meetup">Meetup</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Date & Time</label>
                            <input type="datetime-local" name="event_date" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="Main Auditorium" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Event details..." required></textarea>
                        </div>

                        <button type="submit" class="btn-navy mt-2">
                            <i class="fas fa-paper-plane me-2"></i> Publish Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>