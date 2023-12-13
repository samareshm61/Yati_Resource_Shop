<?php
require 'config/functions.php';

// Check if the user is logged in
if (!isset($_SESSION['phone'])) {
    redirect('customer_index.php','Please Login To Continue');
    
}



// Retrieve all products from the database
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed. " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            position: relative;
        }

        h2 {
            margin-bottom: 20px;
        }

        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px;
            background-color: #4285f4;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .product-container {
            margin-bottom: 20px;
        }

        .product-image {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <a href="customer_logout.php" class="logout-btn">Logout</a>

    <h2>Welcome, <?php echo $_SESSION['phone']; ?>!</h2>

    <h3>Products:</h3>

    <?php
    // Display products
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="product-container">';
        echo '<h4>' . $row['name'] . '</h4>';
        echo '<img class="product-image" src="' . $row['image'] . '" alt="' . $row['name'] . '">';
        // You can display other product details here
        echo '</div>';
    }
    ?>
</body>
</html>
