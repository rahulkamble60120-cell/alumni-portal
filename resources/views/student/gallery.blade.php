<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alumni Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .gallery-img {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .gallery-item:hover .gallery-img {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/student/dashboard') }}">🎓 Alumni Portal</a>
        <div class="d-flex">
            <a href="{{ url('/student/dashboard') }}" class="btn btn-outline-light btn-sm me-2">Back to Dashboard</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4 text-center">📸 Photo Gallery</h2>
    <p class="text-center text-muted mb-5">Memories from Global events, your Chapter, and your Department.</p>

    <div class="row g-4">
        @forelse($photos as $photo)
            <div class="col-md-4 gallery-item">
                <div class="card shadow-sm h-100 border-0 overflow-hidden">
                    <img src="{{ asset('storage/' . $photo->image_path) }}" class="card-img-top gallery-img">
                    <div class="card-body">
                        @if($photo->title)
                            <h6 class="card-title fw-bold">{{ $photo->title }}</h6>
                        @endif
                        
                        <div class="mt-2">
                            @if($photo->chapter_id)
                                <span class="badge bg-warning text-dark">Chapter</span>
                            @elseif($photo->department_id)
                                <span class="badge bg-info">Department</span>
                            @else
                                <span class="badge bg-success">Global</span>
                            @endif
                            <small class="text-muted ms-2">{{ $photo->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-camera-retro fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">No photos available yet.</h4>
            </div>
        @endforelse
    </div>
</div>

</body>
</html>