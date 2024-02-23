<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["new-name"];
    $newUsername = $_POST["new-username"];
    $newPassword = $_POST["new-password"];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "myDB";

    $conn = mysqli_connect($servername, $dbUsername, $dbPassword, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the username already exists
    $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newUsername'";
    $result = mysqli_query($conn, $checkUsernameQuery);

    if (mysqli_num_rows($result) > 0) {
        // Username already exists, handle accordingly (e.g., display an error message)
        echo "Username '$newUsername' already exists. Please choose a different username.";
    } else {
        // Insert user data into the users table
        $insertSql = "INSERT INTO users (name, username, password) VALUES ('$name', '$newUsername', '$newPassword')";

        if (mysqli_query($conn, $insertSql)) {
            mysqli_close($conn);
            // Redirect to login.html after successful registration
            header("Location: http://localhost/DBW%20project/Login/login.html");
            exit;
        } else {
            echo "Error: " . $insertSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="stl.css">
</head>

<body>
    <div class="container">
        <div class="form-box">
            <h2>Register</h2>

            <form method="post" action="register.php" id="register-form">
                <div class="input-container">
                    <label for="new-name">Name</label>
                    <input type="text" id="new-name" name="new-name" required>
                </div>
                <div class="input-container">
                    <label for="new-username">Username</label>
                    <input type="text" id="new-username" name="new-username" required>
                </div>
                <div class="input-container">
                    <label for="new-password">Password</label>
                    <input type="password" id="new-password" name="new-password" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="index.html">Login here</a></p>
        </div>
    </div>
</body>

</html>
