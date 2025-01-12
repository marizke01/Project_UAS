<?php
session_start();
include 'db.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upgrade to Premium</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            background-color: #343a40;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            padding-bottom: 30px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }
        .card-body {
            background-color: #ffffff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
            width: 100%;
            bottom: 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">MEGA MUSIC</a>
            <div class="d-flex gap-2">
                <a href="search.php" class="nav-link">Search</a>
                <a href="premium.php" class="nav-link">Premium</a>
                <a href="collections.php" class="nav-link">Collections</a>
                <a href="akun.php" class="nav-link">Akun</a>
                <a href="logout.php" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Upgrade to Premium
            </div>
            <div class="card-body">
                <h4>Enjoy access to more songs for just <b>Rp10.000/month</b>.</h4>
                <form action="process_premium.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="paymentMethod" class="form-label">Choose Payment Method:</label>
                        <select id="paymentMethod" name="payment_method" class="form-control" required>
                            <option value="" disabled selected>Select a payment method</option>
                            <option value="bca">Bank BCA</option>
                            <option value="bsi">Bank BSI</option>
                            <option value="mandiri">Bank Mandiri</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="accountNumber" class="form-label">Enter Your Account Number:</label>
                        <input type="text" id="accountNumber" name="account_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="paymentProof" class="form-label">Upload Payment Proof:</label>
                        <input type="file" id="paymentProof" name="payment_proof" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Upgrade Now</button>
                </form>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 MusicApp. All Rights Reserved. | <a href="#" style="color: #fff; text-decoration: none;">Privacy Policy</a> | <a href="#" style="color: #fff; text-decoration: none;">Terms of Service</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
