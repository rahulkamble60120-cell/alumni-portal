<!DOCTYPE html>
<html lang="en">
<head>
    <title>Join {{ $institution->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d2c56 0%, #0a1f3d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-card {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
        }
        .btn-register {
            background-color: #d4af37;
            color: #0d2c56;
            font-weight: bold;
            border: none;
        }
        .btn-register:hover {
            background-color: #c4a030;
            color: #0d2c56;
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="text-center mb-3">
        <h3 style="color: #0d2c56; font-weight: bold;">🎓 Join {{ $institution->name }}</h3>
        <p class="text-muted">Create your alumni account</p>
    </div>

    <form action="{{ url('/school/'.$id.'/register') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" required placeholder="John Doe">
        </div>

        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required placeholder="john@example.com">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Graduation Year</label>
            <input type="number" name="graduation_year" class="form-control" required placeholder="2024" min="1900" max="2030">
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="Min 8 characters">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required placeholder="Re-enter password">
        </div>

        <button type="submit" class="btn btn-register w-100 py-2">Create Account</button>
        
        <div class="text-center mt-3">
            <span class="text-muted small">Already have an account?</span>
            <a href="{{ url('/login') }}" class="text-decoration-none fw-bold">Login here</a>
        </div>
    </form>
</div>

</body>
</html>