
<?php
  if (!isset($_SESSION))
    session_start();
  require("vendor/autoload.php");
  require("class/DbHelper.php");

  // Header Loads here
  require('view/header.php');
?>

<head>
  <link rel="stylesheet" href="stylesheet/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <script src="class/validation.js"></script>
</head>

<!-- BODY section -->

<body>

  <?php
  $db = new DbConnection();
  // For login with form section
  // Checks if userId and Password field are empty.
  if (isset($_POST['userId']) && isset($_POST['pass'])) {

    // If any fields are empty show error
    if ($_POST['userId'] == "" || $_POST['pass'] == "") { ?>
      <div class='error-div'>
        <?php echo "Fill all fields"; ?>
      </div>

    <?php }
    // If user exists and all fields are valid then login and set session.
    else if (($db->existsUserId($_POST['userId']) && $_POST['pass'] == $db->getPass($_POST['userId'])) || ($db->existsMailId($_POST['userId']) && $_POST['pass'] == $db->getPass($_POST['userId']))) {
      $_SESSION['loggedIn'] = TRUE;
      $_SESSION['userId'] = $_POST['userId'];
      $db->setOnline($_POST['userId'], '1');
      // Redirects to homepage on successfull login.
      header("Location:http://post.it");
    }
    // If user exits but password is wrong then show error.
    else if (($db->existsUserId($_POST['userId']) || $db->existsMailId($_POST['userId'])) && $_POST['pass'] != $db->getPass($_POST['userId'])) { ?>
          <div class='error-div'>
        <?php echo "Password is incorrect"; ?>
          </div>
        <?php
        $forgotPass = TRUE;
    }
    // If user not exits then show error.
    else { ?>
          <div class='error-div'>
        <?php echo "Login Credentials failed"; ?>
          </div>
    <?php }
  }

  if ((isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])) {
    if (isset($_SESSION['adapter'])) {
      $adapter = unserialize($_SESSION['adapter']);
    } ?>
    <div class="container">
      <?php require('Controller/AuthController.php'); ?>
    </div>
    <?php
    // Footer section
    require('view/footer.php');
  } 
  else {
    ?>

    <form class="form-div" method="POST" action="index.php">
      <h2>Login Page</h2>
      Username: <span class="error br" name="usererr">
      </span>
      <input type="text" name="userId" placeholder=" Username / Email" value='<?php if (isset($_POST["userId"]))
        echo $_POST["userId"]; ?>'>
      Password:<span class="error br" name="passerr">
      </span>
      <span>
        <input type="password" name="pass" id="pass" placeholder="Enter Password" value='<?php if (isset($_POST["pass"]))
          echo $_POST["pass"] ?>'>
          <i class="bi bi-eye-slash " id="togglePassword">
          </i>
        </span>
        <?php
        if (isset($forgotPass) && $forgotPass) { ?>
        <a class="link-btn br" href="forgotPass.php">forgotten password?</a>
      <?php } ?>
      <div class="sp-bw">
        <input class="hover-eff click-eff btn br" type="submit" name="submit" id="login-btn" value="Login">
        <a class="link-btn grow " href="register.php">I\'m new</a>
      </div>
      <hr><a href="login.php"><img class=" click-eff" height="30px" src="icons/connect-with-linkedin.png"></a>
    </form>

  <?php } ?>
</body>
<script src="class/index.js"></script>
