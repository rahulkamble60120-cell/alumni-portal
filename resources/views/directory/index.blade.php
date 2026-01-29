<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alumni Directory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <span class="navbar-brand">🎓 Alumni Directory</span>
        <a href="{{ url('/student/dashboard') }}" class="btn btn-outline-light btn-sm">Back to Dashboard</a>
    </div>
</nav>

<div class="container">

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ url('/directory') }}" method="GET" class="row g-3">
                
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name, Company, or Position..." value="{{ request('search') }}">
                </div>

                <div class="col-md-4">
                    <select name="grad_year" class="form-select">
                        <option value="">-- Filter by Year --</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('grad_year') == $year ? 'selected' : '' }}>
                                Class of {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 d-grid">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
            
            @if(request('search') || request('grad_year'))
                <div class="mt-2">
                    <a href="{{ url('/directory') }}" class="text-danger text-decoration-none small">✖ Clear Filters</a>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        @forelse($alumni as $alum)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; font-size: 24px;">
                            {{ substr($alum->name, 0, 1) }}
                        </div>
                        
                        <h5 class="card-title mb-1">{{ $alum->name }}</h5>
                        <p class="text-muted mb-2">Class of {{ $alum->graduation_year }}</p>
                        
                        <div class="badge bg-light text-dark border mb-3">
                            {{ $alum->current_position ?? 'Alumni' }} 
                            @if($alum->current_company)
                                at {{ $alum->current_company }}
                            @endif
                        </div>
                        
                        <div class="d-grid">
                            <a href="mailto:{{ $alum->email }}" class="btn btn-outline-primary btn-sm">Contact</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">No alumni found.</h4>
            </div>
        @endforelse
    </div>
</div>

</body>
</html>