<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        /* Sidebar Styling matches Dashboard */
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #2c3e50; color: white; transition: all 0.3s; }
        .sidebar h4 { font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px; color: #ecf0f1; }
        .main-content { margin-left: 260px; padding: 30px; }
        .nav-link { color: #bdc3c7; padding: 12px 20px; border-radius: 5px; margin-bottom: 5px; transition: 0.3s; }
        .nav-link:hover { background: #34495e; color: #fff; }
        .nav-link.active { background: #3498db; color: #fff !important; font-weight: 600; }
        .nav-link i { width: 25px; }
        /* Card Styling matches Dashboard */
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; font-weight: bold; padding: 15px 20px; }
        .btn-primary { background-color: #3498db; border: none; }
        .btn-primary:hover { background-color: #2980b9; }
    </style>
</head>
<body>

<div class="d-flex">
    <div class="sidebar p-3">
        <div class="text-center mb-4 py-3">
            <h4>🎓 Alumni Portal</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/staff') }}" class="nav-link active">
                    <i class="fas fa-user-shield"></i> Manage Staff
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/departments') }}" class="nav-link">
                    <i class="fas fa-sitemap"></i> Departments
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/chapters') }}" class="nav-link">
                    <i class="fas fa-map-marker-alt"></i> Chapters
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/admin/alumni') }}" class="nav-link">
                    <i class="fas fa-user-graduate"></i> Alumni List
                </a>
            </li>
            <div class="mt-auto pt-5">
                <hr style="border-color: rgba(255,255,255,0.1);">
                <li class="nav-item">
                    <a href="{{ url('/logout') }}" class="nav-link text-danger">
                        <i class="fas fa-power-off"></i> Logout
                    </a>
                </li>
            </div>
        </ul>
    </div>

    <div class="main-content w-100">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold m-0">Manage Staff & Admins</h3>
                <p class="text-muted small">Assign and control administrative roles</p>
            </div>
            <div class="user-info d-flex align-items-center">
                <span class="me-3 fw-semibold">{{ auth()->user()->name }}</span>
                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-header border-0 pb-0">
                        <h5 class="m-0">Assign New Role</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/admin/staff') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0" placeholder="e.g. Dr. John Doe" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Email ID</label>
                                <input type="email" name="email" class="form-control bg-light border-0" placeholder="e.g. john@college.edu" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label small text-uppercase fw-bold text-muted">Role Type</label>
                                <select name="role" class="form-select bg-light border-0" id="roleSelect" onchange="toggleFields()" required>
                                    <option value="" selected disabled>Choose Role...</option>
                                    <option value="department_admin">Department Admin</option>
                                    <option value="chapter_admin">Chapter Admin</option>
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="deptField">
                                <label class="form-label small text-uppercase fw-bold text-primary">Department</label>
                                <select name="department_id" class="form-select border-primary-subtle">
                                    <option value="">Select Department...</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->department_id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 d-none" id="chapField">
                                <label class="form-label small text-uppercase fw-bold text-warning">Chapter</label>
                                <select name="chapter_id" class="form-select border-warning-subtle">
                                    <option value="">Select Chapter...</option>
                                    @foreach($chapters as $chap)
                                        <option value="{{ $chap->chapter_id }}">{{ $chap->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-2 py-2 fw-bold">
                                <i class="fas fa-user-check me-2"></i> Assign Role
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="m-0">Active Admins</h5>
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Staff Member</th>
                                        <th>Role</th>
                                        <th>Assigned To</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($staff as $member)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold">{{ $member->name }}</div>
                                            <div class="text-muted small">{{ $member->email }}</div>
                                        </td>
                                        <td>
                                            @if($member->role == 'department_admin')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3">Dept Admin</span>
                                            @else
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Chapter Admin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-dark">
                                                @if($member->role == 'department_admin')
                                                    <i class="fas fa-building text-muted me-1 small"></i> {{ $member->department->name ?? 'Unassigned' }}
                                                @else
                                                    <i class="fas fa-map-marker-alt text-muted me-1 small"></i> {{ $member->chapter->name ?? 'Unassigned' }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ url('/admin/staff/'.$member->user_id.'/remove') }}" 
                                               class="btn btn-light btn-sm text-danger border"
                                               onclick="return confirm('Confirm Removal?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
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
</div>

<script>
    function toggleFields() {
        let role = document.getElementById('roleSelect').value;
        let deptField = document.getElementById('deptField');
        let chapField = document.getElementById('chapField');

        deptField.classList.add('d-none');
        chapField.classList.add('d-none');

        if (role === 'department_admin') {
            deptField.classList.remove('d-none');
        } else if (role === 'chapter_admin') {
            chapField.classList.remove('d-none');
        }
    }
</script>

</body>
</html>