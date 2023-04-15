<?php

  require("model/DbConnection.php");
  $db = new DbConnection();
  require_once 'Model/config.php';
  if (isset($_SESSION['loggedIn'])) {
    try {
      if ($adapter->isConnected()) {
        $adapter->disconnect();
        unset($_SESSION['adapter']);
        unset($_SESSION['code']);
        unset($_SESSION['profile']);
        echo 'Successfully LoggedOut';
        echo '<br><p><a href="index.php">GOTO-> Login page</a></p>';

      }
    } 
    catch (Exception $e) {
      echo $e->getMessage();
    }
    $db->setOnline($_SESSION['userId'], '0');
    unset($_SESSION['userId']);
    unset($_SESSION['loggedIn']);
    session_destroy();
    echo "Disconnected Successfully
      <br><a href='index.php'>GOTO-> Login page</a>";
    header("Location:index.php");
  } 
  else {
   echo 'already disconnected' 
?>
  <br><a href="index.php">GOTO-> Login page</a>';

<?php 
  } 
?>
