<?php
if (isset($_POST['editpass'])) {
    include('db.php');

    $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'emailtosendto', FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    $query = "UPDATE User_Profile SET Password=? WHERE email=?";
    $params = array($newPassword, $email);
    $stmt = sqlsrv_prepare($conn, $query, $params);

    if ($stmt === false) {
        echo "Error preparing SQL query.";
        exit;
    }

    if (!sqlsrv_execute($stmt)) {
        echo "Error executing SQL query.";
        die(print_r(sqlsrv_errors(), true));
    }

    $rowsAffected = sqlsrv_rows_affected($stmt);

    if ($rowsAffected === false) {
        echo "Error retrieving rows affected.";
        exit;
    }

    if ($rowsAffected > 0) {
        echo "success";
    } else {
        // No rows were updated
        echo "Unable to update password.";
    }

    sqlsrv_free_stmt($stmt);
    sqlsrv_close($conn);
}
?>
