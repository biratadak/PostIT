
<?php

session_start();
require('../Model/DbConnection.php');
$db = new DbConnection('postit');
if (isset($_REQUEST['setPost']) && $_REQUEST['setPost'] == 'TRUE') {
    $image = "";
    $audio = "";
    $video = "";
    $comment = "";
    if (($_FILES['photo-upload']['error']) == 0) {
        // echo "audio-success";
        move_uploaded_file($_FILES['photo-upload']['tmp_name'], "../public/uploads/" . $_FILES['photo-upload']['name']);
        $image = "../public/uploads/" . $_FILES['photo-upload']['name'];
    }

    if (($_FILES['audio-upload']['error']) == 0) {
        // echo "audio-success";
        move_uploaded_file($_FILES['audio-upload']['tmp_name'], "../public/uploads/" . $_FILES['audio-upload']['name']);
        $audio = "../public/uploads/" . $_FILES['audio-upload']['name'];
    }
    if (($_FILES['video-upload']['error']) == 0) {
        // echo "video-success";
        move_uploaded_file($_FILES['video-upload']['tmp_name'], "../public/uploads/" . $_FILES['video-upload']['name']);
        $video = "../public/uploads/" . $_FILES['video-upload']['name'];
    }
    if (isset($_REQUEST['content']) && $_REQUEST['content'] != "") {
        $db->setPost($_REQUEST['id'], nl2br(htmlspecialchars($_REQUEST['content'], ENT_QUOTES)), $_REQUEST['name'], $audio, $video, $image);
    }

}
if (isset($_REQUEST['delete']) && $_REQUEST['delete'] == 'TRUE') {
    echo $id;
}

?>
