<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulated PHP processing (replace this with your actual server-side logic)

    // Retrieve form data
    $productName = $_POST["product-name"];
    $productDescription = $_POST["product-description"];
    $productPrice = $_POST["product-price"];

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["product-image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["product-image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["product-image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["product-image"]["tmp_name"], $targetFile)) {
            echo "The file " . basename($_FILES["product-image"]["name"]) . " has been uploaded.";

            // Insert data into the database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "product_database";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind the statement
            $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $productName, $productDescription, $productPrice, $targetFile);

            // Execute the statement
            if ($stmt->execute()) {
                echo "Product added successfully!";
                header("Refresh: 2; URL=product.html");
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
