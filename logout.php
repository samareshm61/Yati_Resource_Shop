<?php

require 'config/functions.php';

// Check if the user is logged in
if (isset($_SESSION['loggedIn'])) {
    // Call the logoutSession() function
    logoutSession();

    // Redirect to the login page with a success message
    redirect('./login.php', 'Logout Successfully!');
} else {
    // If the user is not logged in, you may want to handle that case accordingly
    // For example, redirect to the login page with an error message
    redirect('./login.php', 'You are not login.');
}


?>