<!DOCTYPE html>
<html lang="en">
<head>
    <title>Find a Mentor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/student/dashboard') }}">🎓 Alumni Portal</a>
        <a href="{{ url('/student/dashboard') }}" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4 text-center">🤝 Alumni Mentorship</h2>
    <p class="text-center text-muted mb-5">Connect with experienced alumni for career guidance.</p>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="row g-4">
        @forelse($mentors as $mentor)
            <div class="col-md-4">
                <div class="card shadow-sm h-100 text-center p-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-user-circle fa-4x text-secondary"></i>
                        </div>
                        <h5 class="card-title fw-bold">{{ $mentor->name }}</h5>
                        <p class="text-muted small">
                            {{ $mentor->graduation_year ?? 'Alumni' }} • {{ $mentor->department->name ?? 'Department' }}
                        </p>
                        <button type="button" class="btn btn-primary btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modal{{ $mentor->id }}">
                            Request Mentorship
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal{{ $mentor->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <form action="{{ url('/student/mentors') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Contact {{ $mentor->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="mentor_id" value="{{ $mentor->id }}">
                                <div class="mb-3">
                                    <label>Message</label>
                                    <textarea name="message" class="form-control" rows="3" placeholder="Hi, I am interested in your field..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Send Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted py-5">
                <h4>No alumni found available for mentorship.</h4>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>