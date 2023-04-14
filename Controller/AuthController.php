<?php

  /**
   * Routes the pages in body section using Request_URI.
   */
  // If the session loggedIn is set then route pages.
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
  // If session is not set then show error.
  else {
    echo 'Not logged in';
  }
?>
