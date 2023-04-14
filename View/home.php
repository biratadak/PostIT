
<?php

  if (!isset($_SESSION))
    session_start();

  // If loggedIn then view wall otherwise show error.
  if (isset($_SESSION['loggedIn'])) {
    // If the linkedIn adapter is set in the session then unserialize it and view wall.
    if (isset($_SESSION['profile']))
      $profile = unserialize($_SESSION['profile']);
    require('wall.php');
  }
  // If not loggedIn then show error. 
  else {
    echo "<br><h1 class='bg-danger'>user not logged in</h1>";
  }
?>
