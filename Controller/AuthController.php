<?php
$output="";
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE) {
    switch ($_SERVER['REQUEST_URI']) {
        case "/home":
            include("view/home.php");
            break;
        case "/contacts":
            include("view/contacts.php");
            break;
        case "/about":
            include("View/about.php");
            break;
        default:
            include('view/home.php');
            break;
    }
} 
else {
    $output .= 'Not logged in';
}
echo $output;
?>