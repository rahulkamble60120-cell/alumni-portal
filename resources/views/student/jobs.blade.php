<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3 mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Career Center</a>
        <a href="{{ url('/student/dashboard') }}" class="btn btn-light btn-sm text-primary">Back to Dashboard</a>
    </div>
</nav>

<div class="container">
    <h2 class="mb-4">Available Opportunities</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse($jobs as $job)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-primary">{{ $job->title }}</h4>
                        
                        @php
                            $hasApplied = $job->applications->contains('user_id', Auth::id());
                        @endphp

                        @if($hasApplied)
                            <button class="btn btn-success" disabled>Applied ✅</button>
                        @else
                            <form action="{{ route('jobs.apply', $job->job_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">INTERNAL APPLY</button>
                            </form>
                        @endif
                        </div>
                    
                    <h6 class="text-muted">{{ $job->company_name }} &bull; {{ $job->location ?? 'Remote' }}</h6>
                    <p class="mt-3">{{ $job->description }}</p>

                    @if($job->apply_link)
                        <small class="text-muted">External Info: <a href="http://{{ $job->apply_link }}" target="_blank">Visit Website</a></small>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center mt-5">
            <p class="text-muted">No job openings available right now.</p>
        </div>
        @endforelse
    </div>
</div>

</body>
</html>