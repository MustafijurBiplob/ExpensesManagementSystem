<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Management System</title>
    <!-- Link Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Link Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Your custom styles if any -->
    <style>
        /* Add your custom styles here */
        .hero-section {
            background-color: #f8f9fa; /* Set your desired background color */
            padding: 100px 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <header class="bg-dark text-light py-3">
        <div class="container">
            <h1 class="mb-0">
                <i class="fas fa-money-bill-wave"></i> Expense Management System
            </h1>
            <nav class="navbar navbar-expand-lg navbar-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.html">Register</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h2>Welcome to our Expense Management System</h2>
            <p>Effortlessly manage your expenses with our user-friendly system.</p>
            <!-- Add more content or features as needed -->
        </div>
    </div>

    <!-- Your page content goes here -->

    <footer class="bg-dark text-light text-center py-3">
        <p>&copy; <?php echo date("Y"); ?> Md. Mustafijur Rahman. All rights reserved.</p>
        <!-- Font Awesome Icons -->
        <div>
            <a href="#" class="text-light mx-2"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-light mx-2"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-light mx-2"><i class="fab fa-instagram"></i></a>
            <!-- Add more social media icons as needed -->
        </div>
    </footer>

    <!-- Link Bootstrap JS and any other scripts if needed -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
