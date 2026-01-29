<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard | {{ Auth::user()->name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d2c56; /* Deep Navy */
            --accent-color: #d4af37;  /* Gold */
            --bg-light: #f4f6f9;
            --text-dark: #333;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: var(--bg-light);
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            background: linear-gradient(180deg, #0d2c56 0%, #05162b 100%);
            min-height: 100vh;
            color: white;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 260px;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 20px;
            font-size: 1.4rem;
            font-weight: bold;
            color: var(--accent-color);
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.05);
            border-left: 4px solid var(--accent-color);
        }

        .nav-link.active {
            color: var(--accent-color);
            background: rgba(212, 175, 55, 0.1);
            border-left: 4px solid var(--accent-color);
        }

        .nav-link i { width: 25px; }

        /* --- MAIN CONTENT --- */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* --- STAT CARDS --- */
        .stat-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            position: absolute;
            right: 20px;
            top: 25px;
            font-size: 3rem;
            opacity: 0.1;
        }

        .stat-title {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
        }

        /* Special Card Colors */
        .card-gold { border-bottom: 4px solid var(--accent-color); }
        .card-navy { border-bottom: 4px solid var(--primary-color); }
        
        /* --- TABLES --- */
        .custom-table-card {
            background: white;
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .custom-table-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            color: #495057;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        /* --- ACTION BUTTONS --- */
        .btn-quick {
            background: white;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 12px;
            text-align: left;
            transition: all 0.2s;
            color: var(--primary-color);
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
        }
        .btn-quick:hover {
            border-color: var(--accent-color);
            transform: translateX(5px);
            background: #fffdf5; /* Light gold tint */
        }
        .btn-quick i {
            font-size: 1.5rem;
            margin-right: 15px;
            color: var(--accent-color);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 70px; }
            .sidebar-brand span, .nav-link span { display: none; }
            .main-content { margin-left: 70px; padding: 15px; }
        }
    </style>
</head>
<body>

<nav class="sidebar">
    <div class="sidebar-brand">
        <i class="fas fa-university me-2"></i> <span>Admin Portal</span>
    </div>
    <div class="px-3 py-3 mb-2 border-bottom border-secondary border-opacity-25">
        <div class="d-flex align-items-center">
            <div class="bg-white text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="ms-3 overflow-hidden">
                <div class="small text-white opacity-75">Welcome,</div>
                <div class="fw-bold text-truncate" style="max-width: 140px;">{{ Auth::user()->name }}</div>
            </div>
        </div>
    </div>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ url('/admin/dashboard') }}" class="nav-link active">
                <i class="fas fa-th-large"></i> <span>Dashboard</span>
            </a>
        </li>

        {{-- FIXED: Added 'admin' check to ensure you see the Manage Staff link --}}
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
        <li class="nav-item">
            <a href="{{ url('/admin/staff') }}" class="nav-link">
                <i class="fas fa-users-cog"></i> <span>Manage Staff</span>
            </a>
        </li>
        @endif

        <li class="nav-item"><a href="{{ url('/admin/events') }}" class="nav-link"><i class="fas fa-calendar-check"></i> <span>Events</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/news') }}" class="nav-link"><i class="fas fa-newspaper"></i> <span>News</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/gallery') }}" class="nav-link"><i class="fas fa-images"></i> <span>Gallery</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/jobs') }}" class="nav-link"><i class="fas fa-briefcase"></i> <span>Career Board</span></a></li>
        <li class="nav-item"><a href="{{ url('/admin/alumni') }}" class="nav-link"><i class="fas fa-user-graduate"></i> <span>Alumni List</span></a></li>
        
        <li class="nav-item mt-4">
            <a href="{{ url('/logout') }}" class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
            </a>
        </li>
    </ul>
</nav>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Dashboard Overview</h2>
            <p class="text-muted">Here's what's happening at your institution today.</p>
        </div>
        <a href="{{ url('/school/1') }}" target="_blank" class="btn btn-outline-primary rounded-pill">
            <i class="fas fa-external-link-alt me-2"></i> View Public Site
        </a>
    </div>

    {{-- ADDED: Alert for success messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card card-navy">
                <div class="stat-title">Total Alumni</div>
                <div class="stat-value">{{ $total_alumni ?? 0 }}</div>
                <div class="text-success small"><i class="fas fa-arrow-up"></i> Growing Network</div>
                <i class="fas fa-user-graduate stat-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card card-navy">
                <div class="stat-title">Active Events</div>
                <div class="stat-value">{{ $total_events ?? 0 }}</div>
                <div class="text-muted small">Scheduled this year</div>
                <i class="fas fa-calendar-alt stat-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card card-gold" style="background: #fffdf5;">
                <div class="stat-title" style="color: #bfa345;">Pending Approvals</div>
                <div class="stat-value" style="color: #d4af37;">{{ $pending_approvals ?? 0 }}</div>
                <div class="text-muted small">Needs attention</div>
                <i class="fas fa-clock stat-icon" style="color: #d4af37; opacity: 0.2;"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card card-navy">
                <div class="stat-title">Jobs Posted</div>
                <div class="stat-value">{{ $total_jobs ?? 0 }}</div>
                <div class="text-muted small">Opportunities available</div>
                <i class="fas fa-briefcase stat-icon"></i>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="custom-table-card">
                <div class="custom-table-header">
                    <div><i class="fas fa-user-clock me-2"></i> Pending Registration Requests</div>
                    @if(isset($pendingUsers) && count($pendingUsers) > 0)
                        <span class="badge bg-warning text-dark rounded-pill px-3">{{ count($pendingUsers) }} Pending</span>
                    @endif
                </div>
                
                <div class="p-0">
                    @if(isset($pendingUsers) && count($pendingUsers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Name</th>
                                        <th>Email</th>
                                        <th>Grad Year</th>
                                        <th>Role</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingUsers as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td><span class="badge bg-light text-dark border">{{ $user->graduation_year }}</span></td>
                                        <td><span class="badge bg-info bg-opacity-10 text-info">{{ ucfirst($user->role) }}</span></td>
                                        <td class="text-end pe-4">
                                            {{-- FIXED: Changed id to user_id to fix the double-slash error --}}
                                            <a href="{{ url('/admin/alumni/'.$user->user_id.'/approve') }}" class="btn btn-success btn-sm rounded-pill px-3 me-1">
                                                <i class="fas fa-check"></i> Approve
                                            </a>
                                            <a href="{{ url('/admin/alumni/'.$user->user_id.'/reject') }}" class="btn btn-outline-danger btn-sm rounded-circle" onclick="return confirm('Reject user?');" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <span class="fa-stack fa-2x">
                                  <i class="fas fa-circle fa-stack-2x text-success opacity-25"></i>
                                  <i class="fas fa-check fa-stack-1x text-success"></i>
                                </span>
                            </div>
                            <h5 class="text-muted">All caught up!</h5>
                            <p class="text-secondary small">There are no pending registration requests at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-3">Quick Actions</h4>
    <div class="row g-3">
        <div class="col-md-4">
            <a href="{{ url('/admin/news') }}" class="btn-quick text-decoration-none">
                <i class="fas fa-pen-nib"></i>
                <div>
                    <div class="text-dark">Publish News</div>
                    <div class="small text-muted">Share updates with alumni</div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ url('/admin/events') }}" class="btn-quick text-decoration-none">
                <i class="fas fa-calendar-plus"></i>
                <div>
                    <div class="text-dark">Create Event</div>
                    <div class="small text-muted">Schedule a reunion or webinar</div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ url('/admin/gallery') }}" class="btn-quick text-decoration-none">
                <i class="fas fa-camera"></i>
                <div>
                    <div class="text-dark">Upload Gallery</div>
                    <div class="small text-muted">Share photos from campus</div>
                </div>
            </a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>