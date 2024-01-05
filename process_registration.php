<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database configuration file
    include_once "db_config.php"; // Change this to your actual database configuration file

    // Collect form data
    $username = htmlspecialchars($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

    try {
        // Create a PDO connection
        $pdo = new PDO("mysql:host=localhost;dbname=exp", "root", "");
        
        // Set the PDO error mode to exception
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Prepare a statement to insert user data into the Users table
        $stmt = $pdo->prepare("INSERT INTO Users (UserName, Password, RegistrationDate) VALUES (?, ?, NOW())");
        
        // Bind parameters to the statement
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $password);
        
        // Execute the prepared statement
        $stmt->execute();

        // Close the database connection
        $pdo = null;

        // Redirect to a success page or login page
        header("Location: registration_success.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
