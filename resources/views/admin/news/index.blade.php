<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage News | Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-color: #0d2c56; --accent-color: #d4af37; --bg-light: #f4f6f9; }
        body { font-family: sans-serif; background-color: var(--bg-light); }
        .sidebar { background: #0d2c56; min-height: 100vh; width: 260px; position: fixed; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; display: block; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.1); color: white; border-left: 4px solid var(--accent-color); }
        .main-content { margin-left: 260px; padding: 30px; }
        .btn-navy { background-color: var(--primary-color); color: white; width: 100%; border: none; padding: 10px; }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="p-4 text-center"><h4 class="text-white">Admin</h4></div>
    
    <a href="{{ url('/admin/dashboard') }}" class="nav-link">Dashboard</a>
    <a href="{{ url('/admin/staff') }}" class="nav-link">Staff</a>
    <a href="{{ url('/admin/events') }}" class="nav-link">Events</a>
    <a href="{{ url('/admin/news') }}" class="nav-link active">News</a>
    <a href="{{ url('/admin/gallery') }}" class="nav-link">Gallery</a>
    <a href="{{ url('/logout') }}" class="nav-link text-danger mt-5">Logout</a>
</nav>

<div class="main-content">
    <h2>Manage News</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card p-3">
                <h5>Published Articles</h5>
                @foreach($news as $article)
                    <div class="alert alert-light border d-flex justify-content-between">
                        <div>
                            <strong>{{ $article->title }}</strong><br>
                            <small class="text-muted">{{ $article->category }}</small>
                        </div>
                        <a href="{{ url('/admin/news/'.$article->id.'/delete') }}" class="btn btn-sm btn-outline-danger">Delete</a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Post News</h5>
                <form action="{{ url('/admin/news') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3"><label>Headline</label><input type="text" name="title" class="form-control" required></div>
                    <div class="mb-3">
                        <label>Category</label>
                        <select name="category" class="form-select">
                            <option value="general">General</option>
                            <option value="sports">Sports</option>
                        </select>
                    </div>
                    <div class="mb-3"><label>Image</label><input type="file" name="image" class="form-control"></div>
                    <div class="mb-3"><label>Content</label><textarea name="content" class="form-control" rows="3" required></textarea></div>
                    <button type="submit" class="btn-navy">Publish</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>