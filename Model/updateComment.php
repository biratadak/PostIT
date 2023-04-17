<script src="../class/updateComment.js"></script>

<?php
  session_start();
  require('DbConnection.php');
  $db = new DbConnection();
  // If requested for update and postId and uuserId is set and comment is not empty then add the comment to database.
  if (isset($_REQUEST['update']) && isset($_REQUEST['pi']) && isset($_REQUEST['ui']) && $_REQUEST['content'] != "") {
      $db->conn->query("INSERT INTO `comments` (`post_id`,`id`,`comment`) 
      VALUES(" . $_REQUEST['pi'] . "," . $_REQUEST['ui'] . ",'" . $_REQUEST['content'] . "')");
  }
  // If update is not set and postId and uuserId is set then load comments one by one
  if (!isset($_REQUEST['update']) && isset($_GET['pi']) && isset($_GET['ui'])) {
    $q = $db->conn->query('SELECT * from comments where `post_id`=' . $_GET['pi']); 
?>

  <div class="create-comment">
    <img class="comment-user-icon" src="<?php echo $db->getPhotoURLbyId($_GET['ui']) ?>">
    <textarea class="comment-input">
    </textarea>
    <a>
      <img class="comment-send-icon cell" id="<?php echo 'comment-send-btn-' . $_GET['pi'] ?>"
        src="../icons/send-btn.gif">
    </a>
  </div>
<?php
  // Shows how many comments are found.
  echo $q->num_rows . " comments found";
  // If number of comments is more than 0 than show them.
  if (isset($q)) {
    foreach ($q->fetch_all() as $comment) {
      ?>
      <div id='<?php echo $comment[2] . ' -comment-' . $comment[1] ?>' class="comment">
        <img class="comment-user-icon" src="<?php echo $db->getPhotoURLbyId($comment[2]) ?>">
        <p>
          <?php echo $comment[3] ?>
        </p>
        <div>
          <img class="comment-option-icon pointer" src="../icons/menu.gif">
          <div class="comment-edit-option hide">
            EDIT-OPTION
          </div>
        </div>
      </div>
      <?php
    }
  } 
  else {
    echo '--No Comments Found--';
  }
}
?>
