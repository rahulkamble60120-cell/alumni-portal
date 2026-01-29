<!DOCTYPE html>
<html lang="en">
<head>
    <title>Job Applicants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Applicants for: <span class="text-primary">{{ $job->title }}</span></h3>
        <a href="{{ url('/admin/jobs') }}" class="btn btn-secondary">Back to Jobs List</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Applied Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($job->applications as $app)
                    <tr>
                        <td class="fw-bold">{{ $app->student->name }}</td>
                        <td>{{ $app->student->email }}</td>
                        <td>{{ $app->created_at->format('d M Y') }}</td>
                        <td>
                            @if($app->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($app->status == 'accepted')
                                <span class="badge bg-success">Accepted ✅</span>
                            @else
                                <span class="badge bg-danger">Rejected ❌</span>
                            @endif
                        </td>
                        <td>
                            @if($app->status == 'pending')
                                <a href="{{ url('/admin/application/'.$app->application_id.'/accepted') }}" class="btn btn-success btn-sm">Accept</a>
                                <a href="{{ url('/admin/application/'.$app->application_id.'/rejected') }}" class="btn btn-outline-danger btn-sm">Reject</a>
                            @else
                                <span class="text-muted">Completed</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">No applicants yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>