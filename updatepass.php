<?php
if (isset($_POST['editpass'])) {
    include('db.php');

    // Sanitize input data
    $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'emailtosendto', FILTER_SANITIZE_EMAIL);

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Prepare and execute SQL query
    $query = "UPDATE User_Profile SET Password=? WHERE email=?";
    $params = array($newPassword, $email);
    $stmt = sqlsrv_prepare($conn, $query, $params);

    if ($stmt === false) {
        // Handle query preparation error
        echo "Error preparing SQL query.";
        exit;
    }

    if (!sqlsrv_execute($stmt)) {
        // Handle query execution error
        echo "Error executing SQL query.";
        die(print_r(sqlsrv_errors(), true));
    }

    // Check if any rows were affected by the query
    $rowsAffected = sqlsrv_rows_affected($stmt);

    if ($rowsAffected === false) {
        // Handle error in rows affected retrieval
        echo "Error retrieving rows affected.";
        exit;
    }

    if ($rowsAffected > 0) {
        // Password update successful
        echo "success";
    } else {
        // No rows were updated
        echo "Unable to update password.";
    }

    // Clean up resources
    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>
