
<script>

    $(document).ready(function () {

        // To initially set all counts of liks
        $('.like-count').each(function () {
            $userId = ($(this).parent().parent().parent().attr('id').split('-')[0]);
            $postId = $(this).attr('id').substr(11);
            $(this).load("../Model/updateLike.php?postId=" + $postId + " #totalLikes");
        });

        // To update status of likes
        $.get("../Model/updateLike.php?&userId=" + $userId, function ($r) {
            $.each($r.split(" "), function ($key, $val) {
                if ($val != "") {
                    $("#like-" + $val).addClass('liked');
                    $("#like-" + $val).attr("liked", "TRUE");
                }
            });

        });

        // To update like counts in DB
        $('.like').click(function () {
            $(this).toggleClass('liked');
            $userId = $(this).parent().parent().attr('id').split('-')[0];
            ($(this).attr("liked") == 'FALSE') ? $(this).attr("liked", 'TRUE') : $(this).attr("liked", 'FALSE');
            $liked = $(this).attr("liked");
            $postId = $(this).attr('id').substr(5);
            $likeCount = $(this).children('.like-count').children('#totalLikes').html();
            if ($liked == 'TRUE')
                $(this).children('.like-count').children('#totalLikes').html(parseInt($likeCount) + 1);
            else
                $(this).children('.like-count').children('#totalLikes').html(parseInt($likeCount) - 1);
            $likeCount = $(this).children('.like-count').children('#totalLikes').html();
            $.get("../Model/updateLike.php?pi=" + $postId + "&ui=" + $userId + "&li=" + $liked, function (data, status) {
            });

        });

        // To show comment section
        $('.comment-btn').click(function () {
            $commentsSection = $(this).parent().parent().children('.comments-div');
            $userId = $commentsSection.children('.comments').parent().parent().attr('id').split('-')[0];
            $postId = $commentsSection.children('.comments').parent().parent().attr('id').split('-')[2];
            $commentsSection.children('.comments').load("../Model/updateComment.php?pi=" + $postId + "&ui=" + $userId, function (r) {
            });
            $commentsSection.slideToggle();
        });


        ///////MENU BUTTON///////
        $('.post-menu-btn').click(function () {
            $(this).parent().children('.post-menu-option').slideToggle();

        });
        $('.post-delete-btn').click(function () {
            $id = ($(this).attr('id').split('-')[0]);
            $.ajax({
                type: 'POST',
                url: "../Model/updatePosts.php?delete=TRUE&id=".$id,
                success: function (r) {
                    // On Successfully update the database with new post reload the posts section
                    $('.posts').load("Model/getPosts.php", { newCount: $count, order: $sort });

                },
                error: function (e) {
                    console.log("error");
                    console.log(e);
                }

            });

            // Post edit button

            $('.post-edit-btn').click(function () {
                console.log($(this));
            });
        });
    });
</script>

<?php

if (!isset($_SESSION))
    session_start();

require('../Model/DbConnection.php');
// For post counts
if (isset($_POST['newCount'])) {
    $limit = $_POST['newCount'];
}

// For ordering posts
if (isset($_POST['order']) && $_POST['order'] != "") {
    $order = $_POST['order'];
} 
elseif (isset($_POST['order']) && $_POST['order'] == "") {
    $order = "post_id DESC";
}


$db = new DbConnection('postit');
foreach ($db->getAllPosts($order, $limit) as $row) {
    echo '<div class="post" id="' . $db->getId($_SESSION['userId']) . "-post-" . $row['post_id'] . '">
    <div class="icon-text">
    <div class="icon-text">
    <img class="post-icon" src="' . $db->getPhotoURLbyId($row['id']) . '" alt="">
    <H5 class="post-text">' . $row["name"] . '</H5>
    <H6 class="post-date">' . $row['date'] . '</H6>
    </div>';
    
    if ($row['id'] == $db->getId($_SESSION['userId']))
        echo '<div class="icon-text">
    <img  class="post-menu-icon post-menu-btn" src="icons/menu.png" alt="">
    <div class="post-menu-option hide">
    <img id="' . $row['post_id'] . '-delete-btn" class="post-delete-btn" src="icons/delete.png" alt="">
    <img id="' . $row['post_id'] . '-edit-btn" class="post-edit-btn" src="icons/edit.png" alt="">
    </div>
    </div>
    </div>';
    
    if ($row['video'] != "") {
        echo '<div class="content-img-div" ><i> 
    <video controls >
         <source src = "' . $row['video'] . '" type ="video/ogg" />
         <source src = "' . $row['video'] . '" type = "video/mp4" />
         Your browser does not support the <video> element.
      </video>
    </i></div>';
    }
    
    if ($row['photo'] != "") {
        echo '<div class="content-img" ><img  src="' . $row['photo'] . '" alt="~Picture not found~"></div>';
    }
    
    if ($row['audio'] != "") {
        echo '<div class="content-audio" ><i>
    <audio controls >
         <source src = "' . $row['audio'] . '" type = "audio/ogg" />
         <source src = "' . $row['audio'] . '" type = "audio/mp3" />
         <source src = "' . $row['audio'] . '" type = "audio/wav" />
         Your browser does not support the <audio> element.
      </audio>
    </i></div>';
    }

    echo '<p class="content-text">' . $row['content'] . '</p>
    <div class="post-options">
    <a class="icon-text like" id="' . 'like-' . $row['post_id'] . '" liked="FALSE"><img class="post-option-icon" src="icons/like.gif" alt="">
    LIKE <span class="like-count" id="like-count-' . $row['post_id'] . '"></span></a>
    <a class="icon-text  comment-btn cell" ><img class="post-option-icon" src="icons/comment.gif" alt="">
    COMMENT
    </a>
    </div>
    <div id="comment-' . $row['post_id'] . '" class="comments-div hide">
    <hr>
    <div class="comments" ></div>
    </div>
    </div>';
}

?>
