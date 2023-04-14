<script src="../class/getPosts.js"></script>

<?php

if (!isset($_SESSION))
  session_start();

require('../Model/DbConnection.php');
// For post counts.
if (isset($_POST['newCount'])) {
  $limit = $_POST['newCount'];
}

// For ordering posts.
if (isset($_POST['order']) && $_POST['order'] != "") {
  $order = $_POST['order'];
} 
else if (isset($_POST['order']) && $_POST['order'] == "") {
  $order = "post_id DESC";
}

$db = new DbConnection();
foreach ($db->getAllPosts($order, $limit) as $row) {
  ?>

  <div class="post" id="<?php echo $db->getId($_SESSION['userId']) . "-post-" . $row['post_id']; ?>">
    <div class="icon-text">
      <div class="icon-text">
        <img class="post-icon" src="<?php echo $db->getPhotoURLbyId($row['id']) ?>" alt="">
        <H5 class="post-text">
          <?php echo $row["name"]; ?>
        </H5>
        <H6 class="post-date">
          <?php echo $row["date"]; ?>
        </H6>
      </div>
      <?php
      if ($row['id'] == $db->getId($_SESSION['userId'])) {
        ?>
        <div class="icon-text">
          <img class="post-menu-icon post-menu-btn" src="icons/menu.png" alt="">
          <div class="post-menu-option hide">
            <img id="<?php echo $row['post_id']; ?>-delete-btn" class="post-delete-btn" src="icons/delete.png">
            <img id="<?php echo $row['post_id']; ?>-edit-btn" class="post-edit-btn" src="icons/edit.png">
          </div>
        </div>
      <?php } ?>

    </div>
    <?php
    if ($row['video'] != "") { ?>
      <div class="content-img-div"><i>
          <video controls>
            <source src="<?php echo $row['video']; ?>" type="video/ogg" />
            <source src="<?php echo $row['video']; ?>" type="video/mp4" />
            Your browser does not support the
            <video>
              element.
            </video>
        </i></div>
    <?php }
    if ($row['photo'] != "") { ?>

      <div class="content-img">
        <img src="<?php echo $row['photo']; ?>" alt="~Picture not found~">
      </div>
    <?php }

    if ($row['audio'] != "") { ?>
      <div class="content-audio"><i>
          <audio controls>
            <source src="<?php echo $row['audio']; ?>" type="audio/ogg" />
            <source src="<?php echo $row['audio']; ?>" type="audio/mp3" />
            <source src="<?php echo $row['audio']; ?>" type="audio/wav" />
            Your browser does not support the <audio> element.
            </audio>
        </i></div>
    <?php } ?>

    <p class="content-text">
      <?php echo $row['content']; ?>
    </p>
    <div class="post-options">
      <a class="icon-text like" id="<?php echo 'like-' . $row['post_id']; ?>" liked="FALSE">
        <img class="post-option-icon" src="icons/like.gif" alt="">
        LIKE
        <span class="like-count" id="<?php echo 'like-count-' . $row['post_id']; ?>">
        </span>
      </a>
      <a class="icon-text  comment-btn cell">
        <img class="post-option-icon" src="icons/comment.gif" alt="">
        COMMENT
      </a>
    </div>
    <div id="<?php echo 'comment-' . $row['post_id']; ?>" class="comments-div hide">
      <hr>
      <div class="comments">
      </div>
    </div>
  </div>
<?php
}
?>