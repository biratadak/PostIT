$(document).ready(function () {
  // Default posts count.
  $count = 5;
  $sort = "";

  // To show posts on page reload
  $(".posts").load("Model/getPosts.php", { newCount: $count, order: $sort });

  // Post creating using ajax
  $("#post-create-btn").click(function (e) {
    e.preventDefault();
    $content = $(this)
      .parent()
      .parent()
      .parent()
      .children(".create-post-create")
      .children(".post-content")
      .val();
    $photo = $(this)
      .parent()
      .parent()
      .children(".upload-options")
      .children("#photo-upload")
      .val();
    $id = $(".left-upper").children("h6").attr("id").split("-")[0];
    $name = $.trim($(".left-upper").children("h6").html());
    var form = new FormData($("#post-form")[0]);
    form.append("name", $name);
    form.append("content", $content);
    form.append("id", $id);

    $.ajax({
      type: "POST",
      url: "../Model/updatePosts.php?setPost=TRUE",
      data: form,
      cache: false,
      contentType: false,
      processData: false,
      success: function () {
        // On Successfully update the database with new post reload the posts section
        $(".posts").load("Model/getPosts.php", {
          newCount: $count,
          order: $sort,
        });
      },
    });
  });

  // For loading old posts with button
  $(".load-btn").click(function () {
    $count += 5;
    $(".posts").load("Model/getPosts.php", { newCount: $count, order: $sort });
  });

  // FOR SORTING POSTS
  $("#sort").change(function () {
    $sort = $(this).val();
    $(".posts").load("Model/getPosts.php", { newCount: $count, order: $sort });
  });
});
