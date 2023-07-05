<?php
include('db.php');
// Check if the AJAX request has been made using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["sessionID"]) && isset($_POST["UserId"]) && isset($_POST["UserIdx"])) {
        $sessionID = $_POST["sessionID"];
        $userId = $_POST["UserId"];
        $userIdx = $_POST["UserIdx"];

        // Sanitize the input data to prevent SQL injection (you can use more advanced sanitization methods)
        $sessionID = str_replace("'", "''", $sessionID);
        $userId = str_replace("'", "''", $userId);
        $userIdx = str_replace("'", "''", $userIdx);

        // Prepare and execute the SQL query to insert data into the database
        $tsql = "INSERT INTO sessionID (sessionID, UserId, UserIdx) VALUES ('$sessionID', '$userId', '$userIdx')";
        $getResults = sqlsrv_query($conn, $tsql);

        if ($getResults === false) {
            echo json_encode(array("status" => "error", "message" => "Error storing session ID in the database."));
        } else {
            echo json_encode(array("status" => "success", "message" => "Session ID stored in the database."));
        }

        // Free statement and connection resources
        sqlsrv_free_stmt($getResults);
        sqlsrv_close($conn);
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid parameters."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
