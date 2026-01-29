<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Jobs | Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #0d2c56; --accent-color: #d4af37; --bg-light: #f4f6f9; }
        body { font-family: 'Open Sans', sans-serif; background-color: var(--bg-light); overflow-x: hidden; }
        .sidebar { background: linear-gradient(180deg, #0d2c56 0%, #05162b 100%); min-height: 100vh; width: 260px; position: fixed; color: white; z-index: 1000; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-left: 4px solid transparent; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.05); border-left: 4px solid var(--accent-color); }
        .main-content { margin-left: 260px; padding: 30px; }
        .custom-card { background: white; border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 25px; }
        .card-header-navy { background-color: var(--primary-color); color: white; padding: 15px 20px; font-weight: 600; }
        .btn-navy { background-color: var(--primary-color); color: white; border-radius: 8px; padding: 10px; width: 100%; border: none; }
        .btn-navy:hover { background-color: #05162b; color: white; }
        .job-item { border-left: 5px solid var(--accent-color); transition: 0.2s; }
        .job-item:hover { transform: translateX(5px); }
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
        <li class="nav-item"><a href="{{ url('/admin/events') }}" class="nav-link"><i class="fas fa-calendar-check me-2"></i> <span>Events</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/news') }}" class="nav-link"><i class="fas fa-newspaper me-2"></i> <span>News</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/gallery') }}" class="nav-link"><i class="fas fa-images me-2"></i> <span>Gallery</span></a></li>
        
        <li class="nav-item"><a href="{{ url('/admin/jobs') }}" class="nav-link active"><i class="fas fa-briefcase me-2"></i> <span>Jobs</span></a></li>
        
        <li class="nav-item"><a href="{{ url('/admin/alumni') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> <span>Alumni</span></a></li>
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span></a></li>
    </ul>
</nav>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Jobs</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-header-navy d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-list me-2"></i> Active Job Openings</span>
                    <span class="badge bg-light text-dark rounded-pill">{{ isset($jobs) ? count($jobs) : 0 }} Jobs</span>
                </div>
                <div class="p-3">
                    @forelse($jobs as $job)
                    <div class="card mb-3 job-item shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $job->title }}</h5>
                                    <div class="text-muted small mb-2">
                                        <i class="fas fa-building me-1"></i> {{ $job->company ?? 'Unknown Company' }}
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $job->location }}
                                        <span class="mx-2">|</span>
                                        <span class="badge bg-secondary">{{ $job->type }}</span>
                                    </div>
                                    <p class="mb-0 text-secondary small">{{ Str::limit($job->description, 100) }}</p>
                                </div>
                                <div>
                                    <a href="{{ url('/admin/jobs/'.$job->id.'/delete') }}" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Delete this job?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-briefcase fa-3x mb-3 opacity-50"></i>
                        <p>No job openings posted yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-plus-circle me-2"></i> Post New Job</div>
                <div class="p-4">
                    @if(session('success')) 
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div> 
                    @endif
                    
                    <form action="{{ url('/admin/jobs') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Job Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Software Engineer" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Company Name</label>
                            <input type="text" name="company" class="form-control" placeholder="Tech Corp" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Location</label>
                            <input type="text" name="location" class="form-control" placeholder="New York, Remote..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Job Type</label>
                            <select name="type" class="form-select" required>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Internship">Internship</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn-navy mt-2">Publish Job</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>