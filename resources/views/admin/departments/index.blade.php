<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Departments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1>Manage Departments</h1>
    <a href="{{ url('/admin/dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">Add New Department</div>
                <div class="card-body">
                    <form action="{{ url('/admin/departments') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Department Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Computer Science" required>
                        </div>
                        <div class="mb-3">
                            <label>Short Code</label>
                            <input type="text" name="code" class="form-control" placeholder="CSE" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Department</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Existing Departments</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $dept)
                            <tr>
                                <td>{{ $dept->department_id }}</td>
                                <td>{{ $dept->name }}</td>
                                <td>{{ $dept->code }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>