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
        ?>
        <p><a href="index.php">GOTO-> Login page</a></p>
        <?php
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
      <a href='index.php'>GOTO-> Login page</a>";
    header("Location:index.php");
  } 
  else {
   echo 'already disconnected' 
?>

  <a href="index.php">GOTO-> Login page</a>';
  
<?php 
  } 
?>
