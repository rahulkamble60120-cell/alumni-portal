<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Gallery | Admin Portal</title>
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
        
        /* Gallery Styles */
        .gallery-item { position: relative; border-radius: 8px; overflow: hidden; height: 180px; }
        .gallery-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s; }
        .gallery-item:hover .gallery-img { transform: scale(1.1); }
        .gallery-overlay {
            position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(13, 44, 86, 0.7);
            opacity: 0; transition: 0.3s;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
        }
        .gallery-item:hover .gallery-overlay { opacity: 1; }
        .caption { color: white; font-weight: 600; text-align: center; font-size: 0.9rem; margin-bottom: 10px; }
        
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
        
        <li class="nav-item"><a href="{{ url('/admin/gallery') }}" class="nav-link active"><i class="fas fa-images me-2"></i> <span>Gallery</span></a></li>
        
        <li class="nav-item"><a href="{{ url('/admin/jobs') }}" class="nav-link"><i class="fas fa-briefcase me-2"></i> <span>Jobs</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/alumni') }}" class="nav-link"><i class="fas fa-user-graduate me-2"></i> <span>Alumni</span></a></li>
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> <span>Logout</span></a></li>
    </ul>
</nav>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Gallery</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-header-navy d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-images me-2"></i> Photo Album</span>
                    <span class="badge bg-light text-dark rounded-pill">{{ isset($photos) ? count($photos) : 0 }} Photos</span>
                </div>
                <div class="p-4">
                    <div class="row g-3">
                        @forelse($photos as $photo)
                        <div class="col-md-4 col-sm-6">
                            <div class="gallery-item shadow-sm">
                                <img src="{{ asset('storage/'.$photo->image_path) }}" class="gallery-img" alt="Gallery">
                                <div class="gallery-overlay">
                                    <div class="caption">{{ Str::limit($photo->caption, 30) }}</div>
                                    <a href="{{ url('/admin/gallery/'.$photo->id.'/delete') }}" class="btn btn-outline-light btn-sm rounded-pill px-3" onclick="return confirm('Delete this photo?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center py-5 text-muted">
                            <i class="fas fa-camera-retro fa-3x mb-3 opacity-50"></i>
                            <p>No photos uploaded yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-cloud-upload-alt me-2"></i> Upload Photo</div>
                <div class="p-4">
                    @if(session('success')) 
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div> 
                    @endif
                    
                    <form action="{{ url('/admin/gallery') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Caption (Optional)</label>
                            <input type="text" name="caption" class="form-control" placeholder="Graduation Day 2024">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Select Image</label>
                            <input type="file" name="image" class="form-control" required>
                            <div class="form-text">Supports JPG, PNG (Max 2MB)</div>
                        </div>

                        <button type="submit" class="btn-navy mt-2">
                            <i class="fas fa-upload me-2"></i> Upload
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