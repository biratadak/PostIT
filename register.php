<?php
require("model/DbConnection.php");
// If already loggedin redirect to submit page.
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == TRUE)
  header("Location:index.php");
// Connect with Credential table database.
$db = new DbConnection('postit');
// Checks first if submit is clicked
if (isset($_POST["name"]) && isset($_POST["mailId"]) && isset($_POST["userId"]) && isset($_POST["pass"])) {
  // If id and pass fields are not empty.
  if ($_POST['name'] != "" && $_POST["mailId"] != "" && $_POST['userId'] != "" && $_POST["pass"] != "") {
    if (!preg_match('/^[a-zA-Z\s]+$/', $_POST['name']))
      echo "<br><h4 class='error'>Invalid name</h4>";
    if (!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $_POST['mailId']))
      echo "<br><h4 class='error'>Invalid email address.</h4>";
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['userId']))
      echo "<br><h4 class='error'>User Id should only contain alphabet numbers and space</h4>";
    // If user is not available in db
    if ($db->existsUserId($_POST['userId']))
      echo "<br><h4 class='error'>User Id is unavailable</h4>";
    // If mail id is not available in db
    if ($db->existsMailId($_POST['mailId']))
      echo "<br><h4 class='error'>Mail Id is unavailable</h4>";
    // If all fileds are valid then insert data into database
    else {
      try {
        date_default_timezone_set("Asia/Kolkata");
        $sql = "INSERT INTO `oauth-users` (`oauth_provider`, first_name, last_name, email, user_id, pass,modified) values('postit','" . explode(' ', $_POST['name'], 2)[0] . "','" . explode(' ', $_POST['name'] . " ", 2)[1] . "','" . $_POST["mailId"] . "','" . $_POST['userId'] . "','" . $_POST['pass'] . "','" . date("y-m-d h:i:s") . "')";
        $db->conn->query($sql);
        echo "<h3 class='success'>Account Successfully created<br> Try to Login</h3>";
        echo "<span >Redirecting page in <span class='counter'>10</span> sec.</span>";
        header("refresh:10;url=index.php");
      } catch (Exception $e) {
        echo $e;
      }

    }
  } else {
    echo "<h4 class='error'>All fileds should be filled</h4>";
  }
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

  <form class="form-div" method="POST" action="register.php" onsubmit="return validate()">
    <h3>Register Yourself</h2>
      <br>
      Name: <span class="error" name="nameerr">*
      </span><br> <input type="text" name="name" value=<?php if (isset($_POST['name']))
        echo $_POST['name']; ?>>

      <br><br>
      Email: <span class="error" name="mailerr">*
      </span><br><input type="text" name="mailId" value=<?php if (isset($_POST['mailId']))
        echo $_POST['mailId']; ?>>

      <br><br>
      User Id: <span class="error" name="usererr">*
      </span><br><input type="text" name="userId" value=<?php if (isset($_POST['userId']))
        echo $_POST['userId']; ?>>

      <br><br>
      Password: <span class="error" name="passerr">*
      </span><br><input type="password" name="pass" id="pass" value=<?php if (isset($_POST['pass']))
        echo $_POST['pass']; ?>><i class="bi bi-eye-slash " id="togglePassword"></i>

      <br><br>
      <div class="sp-bw">
        <input type="submit" class="hover-eff click-eff btn" name="register" value="Regiser User">
        <a class="link-btn grow" href="index.php">Already have account.</a>

      </div>

  </form>


</body>
<script src="class/register.js"></script>

</html>
