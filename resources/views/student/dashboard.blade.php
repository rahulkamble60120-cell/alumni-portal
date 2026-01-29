<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alumni Dashboard | {{ $user->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hover-shadow:hover { 
            transform: translateY(-3px); 
            transition: 0.3s; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; 
        }
        .navbar-brand { font-weight: 700; letter-spacing: 0.5px; }
    </style>
</head>
<body class="bg-light">

{{-- --- NAVIGATION --- --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/student/dashboard') }}">🎓 Alumni Portal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/student/dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="{{ url('/student/gallery') }}">
                        <i class="fas fa-camera me-1"></i> Gallery
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/student/jobs') }}">Jobs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/student/events') }}">Events</a>
                </li>
            </ul>
            
            {{-- Redirect to Public Page Button --}}
            <a href="{{ url('/school/1') }}" class="btn btn-outline-info btn-sm me-3 rounded-pill">
                <i class="fas fa-external-link-alt me-1"></i> Public Site
            </a>

            <span class="text-white me-3 d-none d-lg-inline">Welcome, <strong>{{ $user->name }}</strong></span>
            <a href="{{ url('/logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    {{-- --- QUICK ACTIONS --- --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <a href="{{ url('/school/1') }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 hover-shadow p-3">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary text-white rounded-circle p-3 me-3">
                            <i class="fas fa-university fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">Institution Home</h6>
                            <p class="small text-muted mb-0">View latest public updates</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- --- LATEST NEWS --- --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0"><i class="fas fa-newspaper me-2"></i>Latest News</h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($news_list) && $news_list->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($news_list as $news)
                                <div class="list-group-item list-group-item-action py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1 fw-bold text-primary">{{ $news->title }}</h6>
                                        {{-- FIXED: Correct method name diffForHumans() --}}
                                        <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1 text-secondary">{{ Str::limit($news->content, 150) }}</p>
                                    <div class="mt-2">
                                        @if($news->chapter_id) <span class="badge bg-warning text-dark">Chapter Update</span>
                                        @elseif($news->department_id) <span class="badge bg-info">Department News</span>
                                        @else <span class="badge bg-success">Global Update</span> @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-info-circle fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No news updates available at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- --- EVENTS & JOBS --- --}}
    <div class="row">
        {{-- Events Section --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-bottom fw-bold py-3">
                    <i class="fas fa-calendar-alt text-primary me-2"></i> Upcoming Events
                </div>
                <div class="card-body">
                    @forelse($events as $event)
                        <div class="border-bottom pb-3 mb-3 last-child-no-border">
                            <h6 class="mb-1 fw-bold">{{ $event->title }}</h6>
                            <small class="text-muted d-block mb-2">
                                <i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                            </small>
                            <a href="{{ url('/student/events') }}" class="btn btn-sm btn-outline-primary px-3">View Details</a>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted small">No upcoming events found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Jobs Section --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-header bg-white border-bottom fw-bold py-3">
                    <i class="fas fa-briefcase text-success me-2"></i> Career Board
                </div>
                <div class="card-body">
                    @forelse($jobs as $job)
                        <div class="border-bottom pb-3 mb-3">
                            <h6 class="mb-1 fw-bold">{{ $job->title }}</h6>
                            <div class="text-muted small mb-2">
                                <span><i class="fas fa-building me-1"></i> {{ $job->company }}</span> | 
                                <span><i class="fas fa-map-marker-alt me-1"></i> {{ $job->location }}</span>
                            </div>
                            <a href="{{ route('jobs.index') }}" class="btn btn-sm btn-success rounded-pill px-4">Apply Now</a>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted small">No active job listings.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>