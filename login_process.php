<?php
// Include your database configuration file
include_once "db_config.php"; // Change this to your actual database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=localhost;dbname=exp", "root", "");

        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare a statement to retrieve user data
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE UserName = ?");
        $stmt->bindParam(1, $username);
        $stmt->execute();

        // Fetch user data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row["Password"])) {
            // Authentication successful, redirect to user-specific page
            header("Location: user_dashboard.php?id=" . $row["UserID"]);
            exit();
        } else {
            // Authentication failed, redirect to login page with an error message
            header("Location: login.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
