<head>
  <link rel="stylesheet" href="style.css">
</head>
<?php

session_start();
require_once('Model/config.php');
require_once('model/DbConnection.php');
$db = new DbConnection('postit');
// If already LoggedIn then redirect to base URL
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE) {
  header('Location:http://post.it/home');
}
// If not LoggedIn show then try to authenticate with LinkedIn.
else {
  try {
    $adapter->authenticate();
    if ($adapter->isConnected()) {

      echo '<h2 class="success">Successfully Logedin</h2>';
      $_SESSION['adapter'] = serialize($adapter);
      $_SESSION['code'] = $_GET['code'];
      $profile = $adapter->getUserProfile();
      $_SESSION['profile'] = serialize($profile);
      //setting values to database
      if (!$db->existsUserId($profile->identifier) && !$db->existsMailId($profile->email)) {
        $db->setUser("linkedin", $profile->identifier, $profile->firstName, $profile->lastName, $profile->email, $profile->phone, $profile->gender, $profile->photoURL, $profile->webSiteURL, date("y-m-d h:i:s"));
      } 
      else {

        echo "user already have an account";
      }
      $_SESSION['userId'] = $profile->identifier;
      $_SESSION['loggedIn'] = TRUE;
      // set online status 1
      $db->setOnline($profile->identifier, '1');
      echo 'Redirecting to <a href="http://post.it" > Home Page</a>......in 3 seconds';
      header('refresh:3,url=http://post.it/home');
    }

  } 
  catch (Exception $e) {
    echo $e->getMessage();
  }
}

?>