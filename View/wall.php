<script src="../class/wall.js"></script>

<div class="posts-body">
  <section class="left-section  fd-col">
    <div class="left-upper">
      <img class="profile-pic" src='<?php echo $db->getPhotoURLbyUserId($_SESSION["userId"]) ?>' alt="">
      <h6 id="<?php echo $db->getId($_SESSION['userId']) . "-name"; ?>">
        <?php echo $db->getName($_SESSION['userId']); ?>
        </h4>
        <hr>
        <div class="about">
          <?php echo $db->getAbout($_SESSION['userId']); ?>
        </div>
    </div>
    <div class="left-lower">
      <div class="users">
        <h5>Users</h5>
        <div class="grid">
          <?php
          // Getting all users ordered by online status
          foreach ($db->getAllUsers("online") as $row) { ?>
            <div class="grid-item">
              <img class="user-pic" src="<?php echo $row['photo_url'] ?>">
              <p class="user-name">
                <?php echo $row['first_name'] . " " . $row['last_name']; ?>
              </p>

              <?php
              // If status is online then green dot else red 
              if ($row['online'] == '1') { ?>
                <div class="user-status">
                </div>
              <?php } 
              else { ?>
                <div class="user-status" style="background-color:red">
                </div>
              <?php } ?>
            </div>
          <?php }
          ?>

        </div>
      </div>
    </div>
  </section>

  <div class="right-section fd-col">
    <form id="post-form" method="POST" class="create-posts" enctype="multipart/form-data">
      <div class="create-post-create ">
        <img class='post-pic' src="<?php echo $db->getPhotoURLbyUserId($_SESSION['userId']); ?>" alt="">
        <textarea class="post-content" name="content" placeholder="Start a post"></textarea>
      </div>
      <div class="create-posts-options">

        <div class="upload-options">
          <label class="photo-upload" for="photo-upload">Photo</label>
          <input id="photo-upload" name="photo-upload" type="file" accept="image/*" hidden>
        </div>
        <div class="upload-options">
          <label class="video-upload" for="video-upload">Video</label>
          <input id="video-upload" name="video-upload" type="file" accept="video/*" hidden>
        </div>
        <div class="upload-options">
          <label class="audio-upload" for="audio-upload">Audio</label>
          <input id="audio-upload" name="audio-upload" type="file" accept="audio/*" hidden>
        </div>
        <div class="upload-options">
          <label class="post-create-btn" for="post-create-btn"></label>
          <input id="post-create-btn" name="post-create-btn" hidden>
        </div>

      </div>
    </form>

    <!-- <select class="sort-btn"> -->
    <select type="submit" name="sort" id="sort" onchange="sortPosts(this.value)">
      <option value=""> --SELECT ORDER-- </option>
      <option value="DATE ASC">Date Ascending.</option>
      <option value="DATE DESC">Date Descending.</option>
      <option value="NAME ASC">Name Ascending.</option>
      <option value="NAME DESC">Name Descending.</option>
    </select>

    <div class="posts">
    </div>
    <button class="load-btn">Load More</button>
  </div>
</div>
