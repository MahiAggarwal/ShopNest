<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST["username"];
    $enteredPassword = $_POST["password"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "myDB";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to check if the entered username and password exist in the users table
    $sql = "SELECT * FROM users WHERE name = '$enteredUsername' AND password = '$enteredPassword'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        session_start(); // Start a session
        $_SESSION["username"] = $enteredUsername; 
        header("Location: http://localhost/collegeProject/Html/Admin/index.html"); 
    } else {
        echo "Login failed. Please check your credentials.";
    }

    mysqli_close($conn);
}
?>
