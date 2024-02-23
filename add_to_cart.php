<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f8f8f8;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .buy-btn {
            display: inline-block;
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .buy-btn:hover {
            background-color: #45a049;
        }

        form {
            max-width: 400px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <!-- Product Details -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $productId = $_GET["id"];

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
        $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $productId);

        // Execute the statement
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            // Check if the product exists
            if ($result->num_rows > 0) {
                $product = $result->fetch_assoc();

                // Now you have the details of the product, you can proceed to add it to the cart or display the details
                echo "<h2>Product Details</h2>";
                echo "<ul>";
                echo "<li><strong>Name:</strong> " . $product["name"] . "</li>";
                echo "<li><strong>Description:</strong> " . $product["description"] . "</li>";
                echo "<li><strong>Price:</strong> Rs. " . $product["price"] . "</li>";
                echo "<li><strong>Image:</strong> <img src='uploads/" . basename($product["image_path"]) . "' alt='Product Image' style='max-width: 200px;'></li>";
                echo "</ul>";

                // Payment Form
                echo "<form id='paymentForm'>";
                echo "<label for='itemName'>Item Name:</label>";
                echo "<input type='text' id='itemName' name='itemName' value='" . $product["name"] . "' readonly>";

                echo "<label for='amount'>Amount:</label>";
                echo "<input type='number' id='amount' name='amount' value='" . $product["price"] . "' readonly>";

                echo "<label for='paymentMethod'>Payment Method:</label>";
                echo "<select id='paymentMethod' name='paymentMethod' required>";
                echo "<option value='upi'>UPI</option>";
                echo "<option value='bank'>Bank Transfer</option>";
                echo "</select>";

                // Additional fields based on payment method
                echo "<div id='upiFields' style='display:none;'>";
                echo "<label for='upiId'>UPI ID:</label>";
                echo "<input type='text' id='upiId' name='upiId'>";
                echo "</div>";

                echo "<div id='bankFields' style='display:none;'>";
                echo "<label for='accountNumber'>Account Number:</label>";
                echo "<input type='text' id='accountNumber' name='accountNumber'>";

                echo "<label for='ifscCode'>IFSC Code:</label>";
                echo "<input type='text' id='ifscCode' name='ifscCode'>";
                echo "</div>";

                echo "<button type='button' onclick='submitPayment()'>Submit Payment</button>";
                echo "</form>";

                // Payment Result
                echo "<div id='paymentResult' style='display:none; margin-top: 20px;'></div>";

                // JavaScript
                echo "<script>";
                echo "document.getElementById('paymentMethod').addEventListener('change', function() {";
                echo "var upiFields = document.getElementById('upiFields');";
                echo "var bankFields = document.getElementById('bankFields');";

                echo "if (this.value === 'upi') {";
                echo "upiFields.style.display = 'block';";
                echo "bankFields.style.display = 'none';";
                echo "} else if (this.value === 'bank') {";
                echo "upiFields.style.display = 'none';";
                echo "bankFields.style.display = 'block';";
                echo "} else {";
                echo "upiFields.style.display = 'none';";
                echo "bankFields.style.display = 'none';";
                echo "}";
                echo "});";

                echo "function submitPayment() {";
                echo "var paymentForm = document.getElementById('paymentForm');";
                echo "var paymentResult = document.getElementById('paymentResult');";

                echo "paymentForm.style.display = 'none';";
                echo "paymentResult.style.display = 'block';";
                echo "paymentResult.innerHTML = '<h3>Payment Successful!</h3>'";
                echo "}";
                echo "</script>";
                echo "</body>";

            } else {
                echo "Product not found.";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid request.";
    }
    ?>
</html>
