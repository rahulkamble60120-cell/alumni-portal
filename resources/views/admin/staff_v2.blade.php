<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Staff | Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary-color: #0d2c56; --accent-color: #d4af37; --bg-light: #f4f6f9; }
        body { font-family: 'Open Sans', sans-serif; background-color: var(--bg-light); overflow-x: hidden; }
        h1, h2, h3, h4, h5 { font-family: 'Montserrat', sans-serif; font-weight: 700; }
        .sidebar { background: linear-gradient(180deg, #0d2c56 0%, #05162b 100%); min-height: 100vh; width: 260px; position: fixed; color: white; }
        .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; border-left: 4px solid transparent; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.05); border-left: 4px solid var(--accent-color); }
        .main-content { margin-left: 260px; padding: 30px; }
        .custom-card { background: white; border-radius: 12px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 25px; }
        .card-header-navy { background-color: var(--primary-color); color: white; padding: 15px 20px; font-weight: 600; }
        .btn-navy { background-color: var(--primary-color); color: white; border-radius: 8px; padding: 10px; width: 100%; border: none; }
        .btn-navy:hover { background-color: #05162b; }
        @media (max-width: 768px) { .sidebar { width: 70px; } .main-content { margin-left: 70px; } .nav-link span { display: none; } }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="p-4 text-center border-bottom border-secondary border-opacity-25">
        <h4 class="m-0 text-white"><i class="fas fa-university me-2"></i>Admin</h4>
    </div>
    <ul class="nav flex-column mt-3">
        <li class="nav-item"><a href="{{ url('/admin/dashboard') }}" class="nav-link"><i class="fas fa-th-large me-2"></i> Dashboard</a></li>
        <li class="nav-item"><a href="{{ url('/admin/staff') }}" class="nav-link active"><i class="fas fa-users-cog me-2"></i> Manage Staff</a></li>
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link text-danger mt-5"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
    </ul>
</nav>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Staff</h2>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-users me-2"></i> Existing Staff</div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Name</th>
                                <th>Role</th>
                                <th>Assigned To</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($staff_members as $staff)
                            <tr>
                                <td class="ps-4 fw-bold">{{ $staff->name }}<br><small class="text-muted fw-normal">{{ $staff->email }}</small></td>
                                <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $staff->role)) }}</span></td>
                                <td>
                                    @if($staff->department) <i class="fas fa-building text-muted"></i> {{ $staff->department->name }}
                                    @elseif($staff->chapter) <i class="fas fa-map-marker-alt text-muted"></i> {{ $staff->chapter->name }}
                                    @else - @endif
                                </td>
                                <td>
                                    <a href="{{ url('/admin/staff/'.$staff->id.'/remove') }}" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Remove access?');"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="custom-card">
                <div class="card-header-navy"><i class="fas fa-user-plus me-2"></i> Add Admin</div>
                <div class="p-4">
                    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
                    <form action="{{ url('/admin/staff') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Role</label>
                            <select name="role" class="form-select" id="roleSelect" onchange="toggleFields()" required>
                                <option value="">Select...</option>
                                <option value="department_admin">Department Admin</option>
                                <option value="chapter_admin">Chapter Admin</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 d-none" id="deptField">
                            <label class="form-label small fw-bold">Department</label>
                            <select name="department_id" class="form-select">
                                <option value="">Select Dept...</option>
                                @foreach($departments as $d) <option value="{{ $d->id }}">{{ $d->name }}</option> @endforeach
                            </select>
                        </div>
                        <div class="mb-3 d-none" id="chapterField">
                            <label class="form-label small fw-bold">Chapter</label>
                            <select name="chapter_id" class="form-select">
                                <option value="">Select Chapter...</option>
                                @foreach($chapters as $c) <option value="{{ $c->id }}">{{ $c->name }}</option> @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn-navy mt-2">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        document.getElementById('deptField').classList.add('d-none');
        document.getElementById('chapterField').classList.add('d-none');
        const role = document.getElementById('roleSelect').value;
        if(role === 'department_admin') document.getElementById('deptField').classList.remove('d-none');
        if(role === 'chapter_admin') document.getElementById('chapterField').classList.remove('d-none');
    }
</script>
</body>
</html>