<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Alumni | Admin Portal</title>
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
        .alumni-avatar { width: 50px; height: 50px; background-color: #e9ecef; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-color); font-weight: bold; }
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
        <li class="nav-item"><a href="{{ url('/admin/jobs') }}" class="nav-link"><i class="fas fa-briefcase me-2"></i> <span>Jobs</span></a></li>
        
        <li class="nav-item"><a href="{{ url('/admin/alumni') }}" class="nav-link active"><i class="fas fa-user-graduate me-2"></i> <span>Alumni</span></a></li>
        
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span></a></li>
    </ul>
</nav>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Alumni</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-header-navy d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users me-2"></i> Alumni Directory</span>
                    <span class="badge bg-light text-dark rounded-pill">{{ isset($alumni) ? count($alumni) : 0 }} Members</span>
                </div>
                <div class="p-3">
                    @forelse($alumni as $alum)
                    <div class="d-flex align-items-center border-bottom py-3">
                        <div class="alumni-avatar me-3">
                            {{ substr($alum->name, 0, 1) }}
                        </div>
                        
                        <div class="flex-grow-1">
                            <h5 class="fw-bold mb-0">{{ $alum->name }}</h5>
                            <small class="text-muted">
                                Class of {{ $alum->graduation_year }} • {{ $alum->degree }} in {{ $alum->major }}
                            </small>
                            <div class="small text-secondary mt-1">
                                <i class="fas fa-envelope me-1"></i> {{ $alum->email }}
                            </div>
                        </div>

                        <div>
                            <a href="{{ url('/admin/alumni/'.$alum->id.'/delete') }}" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Remove this alumnus?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-graduate fa-3x mb-3 opacity-50"></i>
                        <p>No alumni records found.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-user-plus me-2"></i> Add Alumnus</div>
                <div class="p-4">
                    @if(session('success')) 
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div> 
                    @endif
                    
                    <form action="{{ url('/admin/alumni') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Grad Year</label>
                                <input type="number" name="graduation_year" class="form-control" placeholder="2023" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small fw-bold">Degree</label>
                                <select name="degree" class="form-select" required>
                                    <option value="B.Tech">B.Tech</option>
                                    <option value="B.Sc">B.Sc</option>
                                    <option value="MBA">MBA</option>
                                    <option value="M.Tech">M.Tech</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Major / Branch</label>
                            <input type="text" name="major" class="form-control" placeholder="Computer Science" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">LinkedIn URL (Optional)</label>
                            <input type="url" name="linkedin_url" class="form-control" placeholder="https://linkedin.com/in/...">
                        </div>
                        <button type="submit" class="btn-navy mt-2">Add Record</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>