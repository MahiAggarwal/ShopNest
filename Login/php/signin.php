<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $userPassword = $_POST["userPassword"];

    $servername = "localhost";
    $username = "root";
    $dbPassword = ""; 
    $database = "myDB";

    $conn = mysqli_connect($servername, $username, $dbPassword, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Create users table if not exists
    $createTableSql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL
    )";

    if (mysqli_query($conn, $createTableSql)) {
        // Use prepared statements to prevent SQL injection
        $insertSql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertSql);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, password_hash($userPassword, PASSWORD_DEFAULT));

        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);

            // Redirect to login page
            header("Location: C:\xampp\htdocs\DBW project\Login\login.html");
            exit;
        } else {
            echo "Error executing statement: " . mysqli_error($conn);
        }
    } else {
        echo "Error creating table: " . mysqli_error($conn);
    }
}
?>
