<div class="offcanvas offcanvas-end">
    <!-- Sidebar code goes here -->
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled">';
        <?php

// Retrieve all the chats of the current user
$sql = "SELECT DISTINCT recipientId FROM chats WHERE UserId = '$UserId'";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}


while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $recipientId = $row['recipientId'];

    // Get the name of the recipient
    $sql2 = "SELECT Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$recipientId'";
    $stmt2 = sqlsrv_query($conn, $sql2);
    if ($stmt2 === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    
    $row2 = sqlsrv_fetch_array($stmt2, SQLSRV_FETCH_ASSOC);
    $recipientName = $row2['Surname'] . ' ' . $row2['First_Name'];
    $Passport = $row2['Passport'];
    if (empty( $Passport)) {
      $passportImage="UserPassport/DefaultImage.png";
     }else{
     $passportImage="UserPassport/".$Passport;
     }
    
    // Display the recipient name and passport image in the list
    echo '<li>';
    echo '<div class="passport">';
    echo '<a data-bs-toggle="modal" data-bs-target="#profilepicturemodal">';
    echo '<img src="'. $passportImage . '" alt="' . $recipientName . '">';
    echo '</a>';
    echo '</div>';
    echo '<div class="name"><span><a href="chat.php?UserIdx=' . $recipientId . '">' . $recipientName . '</a></span></div>';
    echo '</li>';
    
    
}

echo '</ul>
    </div>
</div>';

?>
</div>
