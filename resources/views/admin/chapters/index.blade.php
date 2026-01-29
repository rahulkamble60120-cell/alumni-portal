<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Chapters</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex">
    <div class="bg-dark text-white p-3 vh-100" style="width: 250px;">
        <h4 class="mb-4">🎓 Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ url('/admin/dashboard') }}" class="nav-link text-white">⚡ Dashboard</a></li>
            <li class="nav-item"><a href="{{ url('/admin/staff') }}" class="nav-link text-white">👔 Staff</a></li>
            <li class="nav-item"><a href="{{ url('/admin/departments') }}" class="nav-link text-white">🏢 Departments</a></li>
            <li class="nav-item"><a href="{{ url('/admin/chapters') }}" class="nav-link text-warning fw-bold">🌍 Chapters</a></li>
            <li class="nav-item mt-5"><a href="{{ url('/logout') }}" class="nav-link text-danger">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="p-4 w-100">
        <h2 class="mb-4">Manage Chapters 🌍</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">Add New Chapter</div>
                    <div class="card-body">
                        <form action="{{ url('/admin/chapters') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Chapter Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Bangalore Chapter" required>
                            </div>
                            <div class="mb-3">
                                <label>City / Region</label>
                                <input type="text" name="city" class="form-control" placeholder="e.g. Bangalore">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Create Chapter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">Existing Chapters</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($chapters as $chap)
                                <tr>
                                    <td>{{ $chap->id }}</td>
                                    <td>{{ $chap->name }}</td>
                                    <td>{{ $chap->city }}</td>
                                    <td>
                                        <a href="{{ url('/admin/chapters/'.$chap->id.'/delete') }}" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>