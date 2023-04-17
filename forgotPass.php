<?php
require("model/DbConnection.php");
require("model/Features.php");

// If already loggedin redirect to submit page.
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE)
  header("Location:index.php");

// Connect with Credential table database.
$db = new DbConnection();

// Checks first if submit is clicked
if (isset($_POST["mailId"])) {

  // If id and pass fields are not empty.
  if ($_POST["mailId"] != "") {
    if (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $_POST['mailId'])) { ?>
      <h4 class='error br'>Invalid email address.</h4>
    <?php }
    // If mail is valid then send credentials to the user inbox.
    else if ($db->existsMailId($_POST['mailId'])) {
      $feature = new Features();
      $feature->sendMail($_POST['mailId'], "Password Reset Link", "Your UserId: " . $_POST['mailId'] . "Password: " . $db->getPass($_POST['mailId']) . "Change Password after login.");
    } 
    // When mail is not found in database then, show error.
    else {?>
      <h4 class='error-div'>Mail is not registered with &copyPostIt </h4>
    <?php }
  }
  // If mail not valid show error
  else { ?>
    <h4 class='error-div'>Fill valid MailId</h4>
  <?php }
}
?>
<html>

<head>
  <link rel="stylesheet" href="stylesheet/style.css">
  <title>Register</title>
  <script src="class/validation.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
</head>

<body>
  <form class="form-div br" method="POST" action="forgotPass.php" onsubmit="return validate()">
    <h3>Register Yourself</h2>
      Email: <span class="error br" name="mailerr">*
      </span><input type="text" name="mailId" value=<?php if (isset($_POST['mailId']))
        echo $_POST['mailId']; ?>>
      <div class="sp-bw br">
        <input type="submit" class="hover-eff click-eff btn" name="reset" value="Get Password">
        <a class="link-btn grow" href="index.php">LogIn.</a>
      </div>
  </form>
</body>

<script src="class/forgotPass.js"></script>
</html>
