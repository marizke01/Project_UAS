<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MusicApp - Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #1e2a38;
            border-bottom: 2px solid; rgb(113, 52, 219);
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color:rgb(255, 255, 255); !important;
            transition: color 0.3s ease;
        }
  
        .navbar-nav .nav-link:hover {
            color: #fff !important;
        }

        .hero-section {
            background-color:rgb(113, 52, 219);
            background-size: cover;
            color: white;
            padding: 120px 30px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
            color: white; /* Set text color to blue */
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
            color: white; /* Set text color to blue */
        }

        .btn-primary {
            background-color:rgb(113, 52, 219);;
            border: none;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: rgb(113, 52, 219);
        }

        .container {
            max-width: 900px;
            margin-top: 50px;
            text-align: center;
        }

        .about-section h2 {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .about-section p {
            font-size: 1.1rem;
            color: #7f8c8d;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        footer p {
            margin: 0;
            font-size: 1rem;
        }

        .features {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .features .feature {
            background-color: #ecf0f1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 30%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .features .feature:hover {
            transform: translateY(-10px);
        }

        .features .feature h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .features .feature p {
            font-size: 1rem;
            color: #7f8c8d;
        }

    </style>
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">MEGA MUSIC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <h1>Welcome to Mega Music</h1>
        <p>Your ultimate platform to manage and enjoy your music collection.</p>
        <a href="register.html" class="btn btn-primary">Get Started</a>
    </div>

    <!-- Home Section -->
    <div class="container">
        <!-- About Section -->
        <div class="about-section">
            <h2>About MEGA MUSIC</h2>
            <p><strong>Who:</strong> MusicApp is designed for music enthusiasts who love to manage their music collections efficiently.</p>
            <p><strong>What:</strong> A web application to store, organize, and display music data.</p>
            <p><strong>When:</strong> This project is created as part of a final project to demonstrate web development skills.</p>
            <p><strong>Where:</strong> Hosted on a local server or deployed on the web.</p>
            <p><strong>Why:</strong> To provide a simple, user-friendly interface for managing music collections.</p>
            <p><strong>How:</strong> Built using modern web technologies like HTML, CSS, Bootstrap, PHP (for backend), and MySQL (for database).</p>
        </div>

        <!-- Features Section -->
        <div class="features">
            <div class="feature">
                <h3>Organize Your Music</h3>
                <p>Easily categorize and store your favorite songs in different playlists.</p>
            </div>
            <div class="feature">
                <h3>Access Anywhere</h3>
                <p>Access your music collection from any device with an internet connection.</p>
            </div>
            <div class="feature">
                <h3>Easy Sharing</h3>
                <p>Share your playlists with friends and family with just a click.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 MusicApp. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
