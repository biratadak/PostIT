<?php
if (!isset($_SESSION))
    session_start();
require("vendor/autoload.php");
require("model/DbConnection.php");


// <!-- Header Loads here -->
require('view/header.php');
?>

<head>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <script src="class/validation.js"></script>
</head>
<!-- //BODY section -->

<body>

    <?php
    $db = new DbConnection('postit');


    //For login with form section
    if (isset($_POST['userId']) && isset($_POST['pass'])) {

        if ($_POST['userId'] == "" || $_POST['pass'] == "") {
            echo "Fill all fields";
        } 
        else if (($db->existsUserId($_POST['userId']) && $_POST['pass'] == $db->getPass($_POST['userId']))) {
            $_SESSION['loggedIn'] = TRUE;
            $_SESSION['userId'] = $_POST['userId'];
            $db->setOnline($_POST['userId'], '1');
            header("Location:index.php/about");
        } 
        else if ($db->existsUserId($_POST['userId']) && $_POST['pass'] != $db->getPass($_POST['userId'])) {
            echo "Password is incorrect";
            $forgotPass = TRUE;
            echo "<br> exist=" . $db->existsUserId($_POST['userId']);
            echo "<br>" . $_POST['pass'];
        } 
        else {

            echo "Login Credentials failed";
            echo "<br> exist=" . $db->existsUserId($_POST['userId']);
            echo "<br>" . $_POST['pass'];
        }
    }



    if ((isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])) {
        if (isset($_SESSION['adapter']))
            $adapter = unserialize($_SESSION['adapter']);
        echo '<div class="container">';
        require('controller/AuthController.php');
        echo '</div>';

        // <!-- //footer section -->
        require('view/footer.php');
    } 
    else {
        echo '<form class="form-div" method="POST" action="index.php" ">
            <h2>Login Page</h2>
            User Id: <span class="error" name="usererr">*
            </span><br> <input type="text" name="userId" value=' ?>
        <?php if (isset($_POST["userId"]))
            echo $_POST["userId"];
        echo '>
            
            <br><br>
            Password:<span class="error" name="passerr"></span><br>
            
            <span>
            <input type="password" name="pass" id="pass" value=' ?>
        <?php if (isset($_POST["pass"]))
            echo $_POST["pass"];
        echo '><i class="bi bi-eye-slash " id="togglePassword"></i>
            </span>';

        if (isset($forgotPass) && $forgotPass)
            echo '<br><a class="link-btn" href="forgotPass.php">forgotten password?</a>
            <br><br>';
        echo
            '<div class="sp-bw">
            <input class="hover-eff click-eff btn" type="submit" name="submit" id="login-btn" value="Login">
            <a class="link-btn grow " href="register.php">I\'m new</a>
            
            </div>';
        echo '<hr><a href="login.php"><img class=" click-eff" height="30px" src="icons/connect-with-linkedin.png"></a></form>';
        echo '<script>
            togglePass("#togglePassword", "#pass");
            validUser("userId", "usererr");
        </script>';
    }
    ?>

</body>
