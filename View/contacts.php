<?php
if (!isset($_SESSION))
    session_start();


if (isset($_SESSION['loggedIn'])) {
    // getting all users ordered by online status
    echo '<div class="users">';
    foreach ($db->getAllUsers("online") as $row) {

        echo $row['id'] . '<div class="grid-item">
        <img class="user-pic" src="' . $row['photo_url'] . '" alt="">
        <p class="user-name">' . $row['first_name'] . " " . $row['last_name'] . '</p>';

        // If status is online then green dot else red
        if ($row['online'] == '1')
            echo '<div class="user-status" ></div>';
        else
            echo '<div class="user-status" style="background-color:red"></div>';
        echo '</div>';
    }
} 
else {
    echo "<br><h1 class='bg-danger'>user not logged in</h1>";
}
echo '</div>';

?>