<?php
ob_start(); // Start output buffering

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "myDB";

    $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the username and password match
    $checkLoginQuery = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $checkLoginQuery);

    if (mysqli_num_rows($result) > 0) {
        // Login successful
        // Redirect to the specified location
        header("Location: Admin/main.html");
        exit;
    } else {
        // Login failed
        echo "Invalid username or password. Please try again.";
    }

    mysqli_close($conn);
}

ob_end_flush(); // Flush the output buffer
?>
