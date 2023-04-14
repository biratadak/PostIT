$(document).ready(function () {
  // To initially set all counts of links.
  $(".like-count").each(function () {
    $userId = $(this).parent().parent().parent().attr("id").split("-")[0];
    $postId = $(this).attr("id").substr(11);
    $(this).load("../Model/updateLike.php?postId=" + $postId + " #totalLikes");
  });

  // To update status of likes.
  $.get("../Model/updateLike.php?&userId=" + $userId, function ($r) {
    $.each($r.split(" "), function ($key, $val) {
      if ($val != "") {
        $("#like-" + $val).addClass("liked");
        $("#like-" + $val).attr("liked", "TRUE");
      }
    });
  });

  // To update like counts in DB.
  $(".like").click(function () {
    $(this).toggleClass("liked");
    $userId = $(this).parent().parent().attr("id").split("-")[0];
    $(this).attr("liked") == "FALSE"
      ? $(this).attr("liked", "TRUE")
      : $(this).attr("liked", "FALSE");
    $liked = $(this).attr("liked");
    $postId = $(this).attr("id").substr(5);
    $likeCount = $(this).children(".like-count").children("#totalLikes").html();
    if ($liked == "TRUE")
      $(this)
        .children(".like-count")
        .children("#totalLikes")
        .html(parseInt($likeCount) + 1);
    else
      $(this)
        .children(".like-count")
        .children("#totalLikes")
        .html(parseInt($likeCount) - 1);
    $likeCount = $(this).children(".like-count").children("#totalLikes").html();
    $.get(
      "../Model/updateLike.php?pi=" +
        $postId +
        "&ui=" +
        $userId +
        "&li=" +
        $liked,
      function (data, status) {}
    );
  });

  // To show comment section.
  $(".comment-btn").click(function () {
    $commentsSection = $(this).parent().parent().children(".comments-div");
    $userId = $commentsSection
      .children(".comments")
      .parent()
      .parent()
      .attr("id")
      .split("-")[0];
    $postId = $commentsSection
      .children(".comments")
      .parent()
      .parent()
      .attr("id")
      .split("-")[2];
    $commentsSection
      .children(".comments")
      .load(
        "../Model/updateComment.php?pi=" + $postId + "&ui=" + $userId,
        function (r) {}
      );
    $commentsSection.slideToggle();
  });

  // On click onmenu button toggle the menu options.
  $(".post-menu-btn").click(function () {
    $(this).parent().children(".post-menu-option").slideToggle();
  });
  // On click on delete button delete the post using ajax.
  $(".post-delete-btn").click(function () {
    $id = $(this).attr("id").split("-")[0];
    $.ajax({
      type: "POST",
      url: "Model/updatePosts.php?delete=TRUE&id=" + $id,
      success: function (r) {
        // On Successfully update the database with new post reload the posts section.
        $(".posts").load("Model/getPosts.php", {
          newCount: $count,
          order: $sort,
        });
      },
    });
  });

});
