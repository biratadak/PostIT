<?php

/**
 * Routes the pages in body section using Request_URI.
 */

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
  echo 'Not logged in';
}
?>
