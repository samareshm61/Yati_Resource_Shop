<?php
require 'config/functions.php';

if (isset($_POST['customer_loginBtn'])) {
    $enteredPhone = validate($_POST['phone']);

    if ($enteredPhone != '') {
        // Check if the entered phone number exists in the customers table
        $query = "SELECT * FROM customers WHERE phone='$enteredPhone' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                // User found, compare entered phone number with the stored one
                $row = mysqli_fetch_assoc($result);

                // Assuming the database stores the phone number in the 'phone' column
                $storedPhone = $row['phone'];

                if ($enteredPhone == $storedPhone) {
                    // Phone numbers match, you can proceed with login
                    // Store user information in the session if needed
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['phone'] = $row['phone'];

                    // Redirect to the products page or any other page
                   redirect('customer_dashboard.php','Login Successfully!');
                } else {
                    // Entered phone number does not match the stored one
                    redirect('customer_index.php', 'Entered phone number does not match');
                }
            } else {
                // User not found
                redirect('customer_index.php', 'User not found');
            }
        } else {
            // Handle the database query error
            die("Database query failed. " . mysqli_error($conn));
        }
    } else {
        redirect('customer_index.php', 'Phone number is mandatory!');
    }
}
?>
