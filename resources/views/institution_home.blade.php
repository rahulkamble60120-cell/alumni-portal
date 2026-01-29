<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $institution->name }} - Alumni Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d2c56; /* Deep Navy */
            --accent-color: #d4af37;  /* Gold */
            --bg-light: #f8f9fa;
        }
        
        body { 
            font-family: 'Open Sans', sans-serif; 
            color: #333;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, .navbar-brand {
            font-family: 'Montserrat', sans-serif;
        }

        /* Navbar */
        .navbar {
            background-color: var(--primary-color) !important;
            padding: 15px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .btn-register {
            background-color: var(--accent-color);
            color: var(--primary-color);
            font-weight: 700;
            border: none;
        }
        .btn-register:hover {
            background-color: #bfa345;
            color: var(--primary-color);
        }

        /* Hero Section with Parallax */
        .hero-section {
            background: linear-gradient(rgba(13, 44, 86, 0.85), rgba(13, 44, 86, 0.7)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            color: white;
            padding: 160px 0 120px;
            text-align: center;
            position: relative;
        }
        
        /* Stats Bar */
        .stats-bar {
            background: var(--accent-color);
            color: var(--primary-color);
            padding: 40px 0;
            margin-top: -50px;
            position: relative;
            z-index: 10;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        .stat-item h3 { font-size: 2.5rem; font-weight: 700; margin: 0; }
        .stat-item p { font-weight: 600; margin: 0; text-transform: uppercase; font-size: 0.9rem; letter-spacing: 1px; }

        /* Section Styling */
        .section-padding { padding: 80px 0; }
        .bg-light-section { background-color: #f4f6f9; }
        
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        .section-header h2 {
            font-weight: 700;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
        }
        .section-header h2::after {
            content: '';
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        /* Event Date Box */
        .event-date-box {
            background: var(--primary-color);
            color: white;
            text-align: center;
            border-radius: 8px;
            padding: 10px;
            min-width: 70px;
        }
        
        /* Job Cards */
        .job-card { border-left: 5px solid var(--accent-color); }

        /* Footer */
        footer {
            background-color: #1a1a1a;
            color: #888;
            padding: 60px 0 30px;
        }
        footer h5 { color: white; margin-bottom: 20px; }
        footer a { color: #888; text-decoration: none; transition: 0.3s; }
        footer a:hover { color: var(--accent-color); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-university me-2"></i>{{ $institution->name }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link text-white" href="{{ url('/login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/school/'.request()->route('id').'/register') }}" class="btn btn-register rounded-pill px-4">
                            Join Alumni
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container">
            <h1 class="display-3 fw-bold mb-4">Legacy. Network. Future.</h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px; opacity: 0.9;">
                Reconnect with your classmates, find new career opportunities, and give back to the community that shaped you.
            </p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/school/'.request()->route('id').'/register') }}" class="btn btn-outline-light btn-lg px-5 rounded-pill fw-bold">Get Started</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row stats-bar text-center">
            <div class="col-md-4 stat-item border-end border-dark border-opacity-10">
                <h3><i class="fas fa-users mb-2 d-block d-md-none"></i> 5,000+</h3>
                <p>Alumni Connected</p>
            </div>
            <div class="col-md-4 stat-item border-end border-dark border-opacity-10">
                <h3><i class="fas fa-briefcase mb-2 d-block d-md-none"></i> 120+</h3>
                <p>Careers Posted</p>
            </div>
            <div class="col-md-4 stat-item">
                <h3><i class="fas fa-calendar-check mb-2 d-block d-md-none"></i> 50+</h3>
                <p>Annual Events</p>
            </div>
        </div>
    </div>

    <section class="section-padding">
        <div class="container">
            <div class="section-header">
                <h2>Campus Stories</h2>
                <p class="text-muted mt-3">Stay updated with the latest achievements and news.</p>
            </div>

            <div class="row g-4">
                @if(isset($news_list) && count($news_list) > 0)
                    @foreach($news_list as $news)
                        <div class="col-lg-4 col-md-6">
                            <div class="card h-100">
                                <div style="height: 200px; background: #e9ecef; display: flex; align-items: center; justify-content: center; color: #adb5bd;">
                                    <i class="fas fa-image fa-3x"></i>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2 text-muted small">
                                        <span><i class="far fa-calendar-alt me-1"></i> {{ $news->created_at->format('M d, Y') }}</span>
                                        <span class="text-primary fw-bold">News</span>
                                    </div>
                                    <h5 class="card-title fw-bold text-dark">{{ $news->title }}</h5>
                                    <p class="card-text text-secondary">{{ Str::limit($news->content, 90) }}</p>
                                </div>
                                <div class="card-footer bg-white border-0 pt-0">
                                    <a href="#" class="text-decoration-none fw-bold text-primary">Read Story <i class="fas fa-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center text-muted">
                        <p>No stories published yet. Check back soon!</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section-padding bg-light-section">
        <div class="container">
            <div class="section-header">
                <h2>Upcoming Events</h2>
                <p class="text-muted mt-3">Don't miss out on reunions, webinars, and meetups.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @forelse($events as $event)
                        <div class="card mb-4 hover-shadow">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <div class="col-md-2 text-center mb-3 mb-md-0">
                                        <div class="event-date-box shadow-sm">
                                            <div class="fw-bold" style="font-size: 1.8rem; line-height: 1;">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</div>
                                            <div class="text-uppercase small">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 mb-3 mb-md-0">
                                        <h5 class="fw-bold mb-1">{{ $event->title }}</h5>
                                        <p class="text-muted mb-2"><i class="fas fa-map-marker-alt text-danger me-2"></i> {{ $event->location ?? 'Campus Main Hall' }}</p>
                                        <p class="text-secondary small mb-0">{{ Str::limit($event->description, 120) }}</p>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        <a href="{{ url('/school/'.request()->route('id').'/register') }}" class="btn btn-outline-primary rounded-pill px-4">Register</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted">No upcoming events found.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <section class="section-padding">
        <div class="container">
            <div class="section-header">
                <h2>Career Board</h2>
                <p class="text-muted mt-3">Exclusive opportunities for our alumni network.</p>
            </div>

            <div class="row g-4">
                @forelse($jobs as $job)
                    <div class="col-md-4">
                        <div class="card h-100 job-card">
                            <div class="card-body">
                                <h5 class="fw-bold">{{ $job->title }}</h5>
                                <h6 class="text-muted mb-3">{{ $job->company_name }}</h6>
                                <div class="mb-3">
                                    <span class="badge bg-light text-dark border"><i class="fas fa-map-pin me-1"></i> {{ $job->location ?? 'Remote' }}</span>
                                    <span class="badge bg-light text-dark border"><i class="fas fa-clock me-1"></i> Full Time</span>
                                </div>
                                <hr>
                                <div class="d-grid">
                                    <a href="{{ url('/login') }}" class="btn btn-primary btn-sm rounded-pill">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">No jobs posted currently.</div>
                @endforelse
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold text-white">{{ $institution->name }}</h5>
                    <p class="small">Building a stronger community, one graduate at a time. Stay connected, stay inspired.</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">Home</a></li>
                        <li class="mb-2"><a href="#">Events</a></li>
                        <li class="mb-2"><a href="#">Careers</a></li>
                        <li class="mb-2"><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Contact Us</h5>
                    <p class="small mb-1"><i class="fas fa-envelope me-2"></i> alumni@{{ strtolower(str_replace(' ', '', $institution->name)) }}.edu</p>
                    <p class="small"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-lg"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary my-4">
            <div class="text-center small">
                &copy; {{ date('Y') }} {{ $institution->name }} Alumni Association. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>