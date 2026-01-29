<!DOCTYPE html>
<html lang="en">
<head>
    <title>Approve Alumni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1>Pending Alumni Requests</h1>
    <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>USN</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pending_alumni as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->usn }}</td>
                        <td>{{ $student->graduation_year }}</td>
                        <td>
                            <a href="{{ url('/admin/alumni/'.$student->user_id.'/approve') }}" class="btn btn-success btn-sm">Approve</a>

                            <a href="{{ url('/admin/alumni/'.$student->user_id.'/reject') }}" class="btn btn-danger btn-sm">Reject</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No pending requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>