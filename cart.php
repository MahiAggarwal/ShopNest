<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
</head>

<body>

    <h2>Shopping Cart</h2>

    <?php
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            echo '<div>';
            echo '<p>Name: ' . $item['name'] . '</p>';
            echo '<p>Price: ' . $item['price'] . '</p>';
            echo '</div>';
        }
        echo '<a href="checkout.php">Proceed to Checkout</a>';
    } else {
        echo 'Your cart is empty.';
    }
    ?>

</body>

</html>
