<?php

if (!isset($_SESSION))
    session_start();


if (isset($_SESSION['loggedIn'])) {
    if (isset($_SESSION['profile']))
        $profile = unserialize($_SESSION['profile']);
    require('wall.php');
} 
else {
    echo "<script>console.log('home->else')</script>";
    echo "<br><h1 class='bg-danger'>user not logged in</h1>";
}

?>
