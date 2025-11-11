<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Life Training Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --speed-color: #4169e1;
            --power-color: #ff6b6b;
            --wit-color: #9370db;
            --stamina-color: #32cd32;
            --guts-color: #ff8c00;
            --skill-color: #ff69b4;
        }

        body {
            background: linear-gradient(135deg, #e6f3ff 0%, #ffe6f2 50%, #f0e6ff 100%);
            min-height: 100vh;
            font-family: 'Arial Rounded MT Bold', 'Hiragino Maru Gothic ProN', 'Yu Gothic', sans-serif;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="stars" patternUnits="userSpaceOnUse" width="20" height="20"><circle cx="10" cy="10" r="1" fill="rgba(255,105,180,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23stars)"/></svg>');
        }

        .navbar-brand {
            font-weight: 800;
            background: linear-gradient(45deg, var(--speed-color), var(--skill-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 4px rgba(255, 255, 255, 0.5);
        }

        .main-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: 3px solid rgba(255, 255, 255, 0.8);
            position: relative;
            overflow: hidden;
        }

        .main-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--speed-color), var(--power-color), var(--wit-color), var(--stamina-color), var(--guts-color), var(--skill-color));
        }

        .attribute-column {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            border: 3px solid transparent;
            background-clip: padding-box;
            position: relative;
            transition: all 0.3s ease;
        }

        .attribute-column::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            border-radius: 15px 15px 0 0;
        }

        .attribute-column.speed::before { background: var(--speed-color); }
        .attribute-column.power::before { background: var(--power-color); }
        .attribute-column.wit::before { background: var(--wit-color); }
        .attribute-column.stamina::before { background: var(--stamina-color); }
        .attribute-column.guts::before { background: var(--guts-color); }
        .attribute-column.skill::before { background: var(--skill-color); }

        .attribute-column:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .attribute-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .attribute-logo {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .skill-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            border-left: 4px solid;
            margin-bottom: 15px;
        }

        .skill-card.speed { border-left-color: var(--speed-color); }
        .skill-card.power { border-left-color: var(--power-color); }
        .skill-card.wit { border-left-color: var(--wit-color); }
        .skill-card.stamina { border-left-color: var(--stamina-color); }
        .skill-card.guts { border-left-color: var(--guts-color); }
        .skill-card.skill { border-left-color: var(--skill-color); }

        .skill-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .progress {
            border-radius: 10px;
            background: #e9ecef;
            height: 10px;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .skill-card.speed .progress-bar { background: var(--speed-color); }
        .skill-card.power .progress-bar { background: var(--power-color); }
        .skill-card.wit .progress-bar { background: var(--wit-color); }
        .skill-card.stamina .progress-bar { background: var(--stamina-color); }
        .skill-card.guts .progress-bar { background: var(--guts-color); }
        .skill-card.skill .progress-bar { background: var(--skill-color); }

        .btn-primary {
            background: linear-gradient(135deg, var(--speed-color), var(--skill-color));
            border: none;
            border-radius: 25px;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(65, 105, 225, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(65, 105, 225, 0.4);
        }

        .btn-outline-primary {
            border: 2px solid var(--speed-color);
            color: var(--speed-color);
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: var(--speed-color);
            transform: translateY(-2px);
        }

        /* Stat Cards Alignment Fix */
        .stat-card {
            background: linear-gradient(135deg, var(--speed-color), var(--skill-color));
            color: white;
            border-radius: 15px;
            border: none;
            box-shadow: 0 8px 25px rgba(65, 105, 225, 0.3);
            transition: transform 0.3s ease;
            min-height: 140px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 1.5rem;
            opacity: 0.9;
        }

        /* Ensure all stat cards have consistent content alignment */
        .stat-card > div:first-child {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-card small {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .search-form {
            max-width: 300px;
        }

        .search-btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            background: linear-gradient(135deg, var(--speed-color), var(--skill-color));
            border: none;
        }

        .form-control {
            border-radius: 20px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
        }

        .form-control:focus {
            border-color: var(--speed-color);
            box-shadow: 0 0 0 0.2rem rgba(65, 105, 225, 0.25);
        }

        .navbar {
            background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,249,250,0.95) 100%) !important;
            backdrop-filter: blur(10px);
            border-bottom: 3px solid transparent;
            border-image: linear-gradient(90deg, var(--speed-color), var(--power-color), var(--wit-color), var(--stamina-color), var(--guts-color), var(--skill-color)) 1;
        }

        .display-4, .display-5 {
            background: linear-gradient(135deg, var(--speed-color), var(--skill-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 2px solid var(--stamina-color);
            border-radius: 15px;
            color: #155724;
        }

        /* Uma-themed animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Attribute colors for badges */
        .badge.speed { background: var(--speed-color); }
        .badge.power { background: var(--power-color); }
        .badge.wit { background: var(--wit-color); }
        .badge.stamina { background: var(--stamina-color); }
        .badge.guts { background: var(--guts-color); }
        .badge.skill { background: var(--skill-color); }

        /* Responsive design */
        @media (max-width: 768px) {
            .search-form {
                max-width: 200px;
            }
            
            .btn-group .btn {
                padding: 5px 8px;
                font-size: 0.875rem;
            }
            
            .stat-card {
                min-height: 120px;
            }
            
            .stat-card h3 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 576px) {
            .search-form {
                max-width: 150px;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(var(--speed-color), var(--skill-color));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(var(--skill-color), var(--speed-color));
        }

        /* Button group improvements */
        .btn-group-sm > .btn {
            border-radius: 15px;
            margin: 0 2px;
        }

        /* Card body improvements */
        .card-body {
            padding: 1.25rem;
        }

        /* Progress bar animations */
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shimmer 2s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('skills.index') }}">
                🌟 Life Training Center
            </a>

            <!-- Search Form -->
            <form action="{{ route('skills.search') }}" method="GET" class="d-flex search-form me-3">
                <input type="text" name="q" class="form-control" placeholder="Search life skills..." 
                       value="{{ request('q') }}" aria-label="Search">
                <button class="btn btn-primary search-btn" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            
            <div class="navbar-nav ms-auto">
                @auth
                    <span class="navbar-text me-3 fw-bold text-dark">
                        <i class="fas fa-user me-1"></i>Life Learner: {{ Auth::user()->name }}
                    </span>
                    <a class="nav-link fw-bold" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a class="nav-link fw-bold" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                    <a class="nav-link fw-bold" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Join
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="main-container p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-trophy me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>