
<?php

session_start();
require('DbConnection.php');
$db = new DbConnection('postit');

if (isset($_REQUEST['postId'])) {
    echo '<span id="totalLikes">' . $db->getLikeCountbyPostId($_REQUEST['postId'])->fetch_array()[0] . '</span>';
}
if (isset($_REQUEST['userId'])) {
    foreach ($db->getLikedPostId($_REQUEST['userId'])->fetch_all() as $row)
        echo " " . $row[0];
} 
elseif (isset($_GET['pi']) && isset($_GET['ui'])) {
    $q = $db->conn->query('SELECT * from likes where `post_id`=' . $_GET['pi'] . ' AND `id`=' . $_GET['ui'])->fetch_assoc();
    if (isset($q)) {
        if ($q['liked'] == "TRUE") {

            $db->conn->query("DELETE FROM likes 
        WHERE `post_id`=" . $_GET['pi'] . " AND `id`=" . $_GET['ui']
            );
        } 
        else {

            $db->conn->query("UPDATE `likes` 
        SET `liked`='TRUE' 
        WHERE `post_id`=" . $_GET['pi'] . " AND `id`=" . $_GET['ui']
            );
        }

    } 
    else {
        $db->conn->query("INSERT INTO `likes` (`post_id`,`id`,`liked`) 
VALUES(" . $_GET['pi'] . "," . $_GET['ui'] . "," . $_GET['li'] . ")");

    }
}

?>
