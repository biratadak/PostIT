<?php
  if (!isset($_SESSION))
    session_start();

  // If loggedin then show contacts otherwise error
  if (isset($_SESSION['loggedIn'])) { ?>
    <!-- Getting all users ordered by online status -->
    <div class="users">
      <?php
      foreach ($db->getAllUsers("online") as $row) {
        ?>
        <div class="grid-item">
          <img class="user-pic" src="<?php echo $row['photo_url']; ?>" alt="">
          <p class="user-name">
            <?php echo $row['first_name'] . " " . $row['last_name']; ?>
          </p>
          <?php
          // If status is online then green dot else red
          if ($row['online'] == '1') { ?>
            <div class="user-status"></div>
          <?php } 
          else { ?>
            <div class="user-status" style="background-color:red">
            </div>
          <?php } ?>
        </div>
      <?php }
  } 
  else { ?>
      <h1 class='bg-danger br'>user not logged in</h1>
      <?php
  }
?>
</div>
