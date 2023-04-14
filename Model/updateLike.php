
<?php

  session_start();
  require('DbConnection.php');
  $db = new DbConnection();
  // Fetch total likes of each posts
  if (isset($_REQUEST['postId'])) {
    echo '<span id="totalLikes">' . $db->getLikeCountbyPostId($_REQUEST['postId']) . '</span>';
  }
  // Fetch all post id where current users liked.
  if (isset($_REQUEST['userId'])) {
    foreach ($db->getLikedPostId($_REQUEST['userId'])->fetch_all() as $row)
      echo " " . $row[0];
  }
  // If Ajax called for a perticular like then update them accordingly. 
  else if (isset($_GET['pi']) && isset($_GET['ui'])) {

    $query = $db->conn->query('SELECT * from likes where `post_id`=' . $_GET['pi'] . ' AND `id`=' . $_GET['ui'])->fetch_assoc();
    // If likes found for given user id and post id 
    if (isset($query)) {
      // When the liked field is set in database delete that perticular like.
      if ($query['liked'] == "TRUE") {
        $db->conn->query("DELETE FROM likes WHERE `post_id`=" . $_GET['pi'] . " AND `id`=" . $_GET['ui']);
      }
      // When the liked field is not set in database update that perticular like
      else {
        $db->conn->query(
          "UPDATE `likes` SET `liked`='TRUE' WHERE `post_id`=" . $_GET['pi'] . " AND `id`=" . $_GET['ui']
        );
      }
    }
    // If not liked then add like to likes table by the current user.
    else {
      $db->conn->query("INSERT INTO `likes` (`post_id`,`id`,`liked`) 
    VALUES(" . $_GET['pi'] . "," . $_GET['ui'] . "," . $_GET['li'] . ")");

    }
  }
?>
