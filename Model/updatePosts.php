<?php

/**
 * Update posts according to ajax call.
 * If setpost is TRUE then move the uploaded files to public/uploads folder for each audio, video and picture,
 * 
 */
session_start();
require('../Model/DbConnection.php');
$db = new DbConnection('postit');

if (isset($_REQUEST['setPost']) && $_REQUEST['setPost'] == 'TRUE') {
    // Holds the image url if provided.
    $image = "";
    // Holds the audio url if provided.
    $audio = "";
    // Holds the video url if provided.
    $video = "";
    // Holds the comment string if provided.
    $comment = "";
    if (($_FILES['photo-upload']['error']) == 0) {
        move_uploaded_file($_FILES['photo-upload']['tmp_name'], "../public/uploads/" . $_FILES['photo-upload']['name']);
        $image = "../public/uploads/" . $_FILES['photo-upload']['name'];
    }

    if (($_FILES['audio-upload']['error']) == 0) {
        move_uploaded_file($_FILES['audio-upload']['tmp_name'], "../public/uploads/" . $_FILES['audio-upload']['name']);
        $audio = "../public/uploads/" . $_FILES['audio-upload']['name'];
    }
    if (($_FILES['video-upload']['error']) == 0) {
        move_uploaded_file($_FILES['video-upload']['tmp_name'], "../public/uploads/" . $_FILES['video-upload']['name']);
        $video = "../public/uploads/" . $_FILES['video-upload']['name'];
    }
    if (isset($_REQUEST['content']) && $_REQUEST['content'] != "") {
        $db->setPost($_REQUEST['id'], nl2br(htmlspecialchars($_REQUEST['content'], ENT_QUOTES)), $_REQUEST['name'], $audio, $video, $image);
    }

}

/**
 * Update posts according to ajax call.
 * If delete is TRUE thendelete the post.
 */
if (isset($_REQUEST['delete']) && $_REQUEST['delete'] == 'TRUE') {
    $db->deletePost($_REQUEST['id']);
}

?>
