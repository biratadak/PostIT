
<script>

    $(document).ready(function () {
        $('.comment-send-icon').click(function () {
            $userId = $(this).parent().parent().parent().parent().parent().attr('id').split('-')[0];
            $postId = $(this).parent().parent().parent().parent().attr('id').split('-')[1];
            $comment = $(this).parent().parent().children('.comment-input').val();
            $.post("../Model/updateComment.php?update=TRUE&ui=" + $userId + "&pi=" + $postId, { content: $comment }, function () {
                $('.comments-div').children('.comments').load("../Model/updateComment.php?pi=" + $postId + "&ui=" + $userId, function (r) {
                });
            });
        });

        $('.comment-option-icon').click(function () {
            $postOption = $(this).parent().children('.comment-edit-option');
            $postOption.slideToggle();


        });
    });
</script>

<?php

session_start();
require('DbConnection.php');
$db = new DbConnection('postit');

if (isset($_REQUEST['update']) && isset($_REQUEST['pi']) && isset($_REQUEST['ui'])) {
    if ($_REQUEST['content'] != "")
        $db->conn->query("INSERT INTO `comments` (`post_id`,`id`,`comment`) 
    VALUES(" . $_REQUEST['pi'] . "," . $_REQUEST['ui'] . ",'" . $_REQUEST['content'] . "')");
}

if (!isset($_REQUEST['update']) && isset($_GET['pi']) && isset($_GET['ui'])) {
    $q = $db->conn->query('SELECT * from comments where `post_id`=' . $_GET['pi']);
    echo '<div class="create-comment"><img class="comment-user-icon" src="' . $db->getPhotoURLbyId($_GET['ui']) . '"><textarea class="comment-input"></textarea><a><img class="comment-send-icon cell" id="comment-send-btn-' . $_GET['pi'] . '" src="../icons/send-btn.gif"></a></div>';
    echo $q->num_rows . " comments found";
    if (isset($q)) {
        foreach ($q->fetch_all() as $comment)
            echo '<div id=' . $comment[2] . '-comment-' . $comment[1] . ' class="comment"><img class="comment-user-icon" src="' . $db->getPhotoURLbyId($comment[2]) . '"><p>' . $comment[3] . '</p><div><img class="comment-option-icon pointer" src="../icons/menu.gif"><div class="comment-edit-option hide">EOPTIONSDIT  </div></div></div>';
    } 
    else {
        echo '<br>--No Comments Found--';
    }
}

?>
