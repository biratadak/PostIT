<?php

// Loaded all required libraries.
require("../vendor/autoload.php");
//  Loading .env credentials.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

/**
 * Connects with database using mysqli.
 * 
 * @method getQueryController
 *  Get query response as an array.
 * 
 * @var string $conn
 *  Store the mysqli connection object.
 *
 * */
class DbConnection
{

  public $conn;
  function __construct($database = "postit")
  {
    $connect = new mysqli("localhost", $_ENV['sqlUser'], $_ENV['sqlPass'], $database);
    if ($connect->connect_error) {
      echo '<script>"Connection error:" . $connect->connect_error</script>';
    }
    $this->conn = $connect;
  }


  /**
   * Sends query response as array. 
   * 
   * @param $query
   *  stores the query string.
   *  
   * @return array
   *  Response of the query string.
   */
  public function getQueryArray($query)
  {
    $queryResponse = $this->conn->query($query);
    foreach ($queryResponse as $value) {
      $response[] = $value;
    }
    return $response;
  }

  /**
   * Checks if user exists. 
   * 
   * @param $userId
   *  stores the user Id string.
   *  
   * @return bool
   *  Returns TRUE if user exists ,else FALSE.
   */
  public function existsUserId($userId)
  {
    if (isset($this->conn->query("select user_id from `oauth-users` where `user_id`='" . $userId . "'")->fetch_assoc()['user_id']))
      return TRUE;
    else
      return FALSE;
  }

  /**
   * get photo url of user by id. 
   * 
   * @return string
   *  Returns path of image if user exists ,else empty string.
   */
  public function getPhotoURLbyId($Id)
  {
    if (isset($this->conn->query('select photo_url from `oauth-users` where id="' . $Id . '"')->fetch_assoc()['photo_url']))
      return $this->conn->query('select photo_url from `oauth-users` where id="' . $Id . '"')->fetch_assoc()['photo_url'];
    else
      return 0;

  }

  /**
   * get counts of all users. 
   * 
   * @return int
   *  Returns count if user exists ,else 0.
   */
  public function getUsersCount()
  {
    if (isset($this->conn->query('select count(*) as count from `oauth-users`')->fetch_assoc()['count']))
      return $this->conn->query('select count(*) as count from `oauth-users`')->fetch_assoc()['count'];
    else
      return 0;
  }

  /**
   * get photo url of user by user id. 
   * 
   * @return string
   *  Returns path of image if user exists ,else empty string.
   */
  public function getPhotoURLbyUserId($userId)
  {
    if (isset($this->conn->query('select photo_url from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['photo_url']))
      return $this->conn->query('select photo_url from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['photo_url'];
    else
      return "";

  }



  /**
   * Checks if user exists. 
   * 
   * @param $mailId
   *  stores the mail Id string.
   *  
   * @return bool
   *  Returns TRUE if mail id exists ,else FALSE.
   */
  public function existsMailId($mailId)
  {
    if (isset($this->conn->query("select email from `oauth-users` where email='" . $mailId . "'")->fetch_assoc()['email']))
      return TRUE;
    else
      return FALSE;
  }

  /**
   * get Password of given userId. 
   * 
   * @param $userId
   *  stores the user Id string.
   *  
   * @return string
   *  Returns pass if user exists ,else return empty string.
   */
  public function getPass($userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select pass from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['pass']))
      return $this->conn->query("select pass from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['pass'];
    else
      return "";

  }

  /**
   * get name of given userId. 
   * 
   * @param $userId
   *  stores the user Id string.
   *  
   * @return string
   *  Returns name if user exists ,else return empty string.
   */
  public function getName($userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select first_name from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT CONCAT_WS(" ", `first_name`, `last_name`) as `fullname` from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['fullname'];
    else
      return "";

  }

  /**
   * get name of given ID. 
   * 
   * @param $id
   *  stores the Id .
   *  
   * @return string
   *  Returns Name if ID exists ,else return empty string.
   */
  public function getNamebyId($id)
  {
    if (isset($this->conn->query("select first_name from `oauth-users` where id='" . $id . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT CONCAT_WS(" ", `first_name`, `last_name`) as `fullname` from `oauth-users` where id="' . $id . '"')->fetch_assoc()['fullname'];
    else
      return "";

  }

  /**
   * get Id of given userId. 
   * 
   * @param $userId
   *  stores the user Id string.
   *  
   * @return string
   *  Returns ID if user exists ,else return empty string.
   */
  public function getId($userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select id from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['id']))
      return $this->conn->query('SELECT id from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['id'];
    else
      return "";

  }

  /**
   * get About of given userId. 
   * 
   * @param $userId
   *  stores the user Id string.
   *  
   * @return string
   *  Returns about if user exists ,else return empty string.
   */
  public function getAbout($userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select first_name from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT `about` from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['about'];
    else
      return "";

  }

  /**
   * get all users of ordered by given order. 
   * 
   * @param $order
   *  stores the order string.
   *  
   * @return string
   *  Returns all users ordered by givenr order.
   */
  public function getAllUsers($order = "first_name")
  {
    if (isset($this->conn->query("SELECT * from `oauth-users`")->fetch_assoc()['user_id']))
      return $this->conn->query("SELECT * from `oauth-users` ORDER BY " . $order);
    else
      return "";
  }

  /**
   * get limit number of posts of ordered by given order. 
   * 
   * @param $order
   *  stores the order string.
   * 
   * @param $limit
   *  stores the limit string.
   *  
   * @return string
   *  Returns limit numbers of posts ordered by given order .
   */
  public function getAllPosts($order = "post_id", $limit = 5)
  {
    if (isset($this->conn->query("SELECT * from `posts`")->fetch_assoc()['post_id']))
      return $this->conn->query("SELECT * from `posts` ORDER BY " . $order . " LIMIT " . $limit);
    else
      return "";
  }

  /**
   * get online status of given userId. 
   * 
   * @param $userId
   *  stores the user id string.
   *  
   * @return string
   *  online status of user
   */
  public function getOnline($userId)
  {
    return $this->conn->query('select online from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['online'];
  }

  /**
   * get like count of given postId. 
   * 
   * @param $postId
   *  stores the post id string.
   *  
   * @return int
   *  like count of posts
   */
  public function getLikeCountbyPostId($postId)
  {
    return $this->conn->query('SELECT count(*) from likes where `post_id`="' . $postId . '"');
  }

   /**
   * get postIds of liked posts only. 
   * 
   * @param $userId
   *  stores the user id string.
   *  
   * @return string
   *  id's of posts
   */
  public function getLikedPostId($userId)
  {
    return $this->conn->query('SELECT `post_id` from likes WHERE `id`=' . $userId);
  }

  /**
   * get post id of given userId as string. 
   * 
   * @param $userId
   *  stores the user id string.
   *  
   * @return string
   *  array of post ids 
   */
  public function getPostIdbyUserId($userId)
  {
    $str = "";
    foreach ($this->conn->query("SELECT post_id from likes where `id`=" . $userId)->fetch_all() as $r)
      $str .= ($r[0] . ' ');
    return $str;
  }

  /**
   * set new created post to database. 
   * 
   * @param $id
   *  stores the id of post.
   * 
   * @param $content
   *  stores the content text of post.
   * 
   * @param $name
   *  stores the name of post.
   * 
   * @param $audio
   *  stores the audio link with filename of post.
   * 
   * @param $video
   *  stores the video link with filename of post.
   * 
   * @param $photo
   *  stores the photo link with filename of post.
   *  
   */
  public function setPost($id, $content, $name, $audio = "", $video = "", $photo = ""): void
  {
    $this->conn->query('INSERT INTO `posts` (id,content,name,audio,video,photo)
   values(' . $id . ',"' . $content . '","' . $this->getNamebyId($id) . '","' . $audio . '","' . $video . '","' . $photo . '")');
  }

  /**
   * Sets users details. 
   * 
   * @param $oauth_provider
   *  stores the oauth provider string.
   *  
   * @param $user_id
   *  stores the user id  string.
   *  
   * @param $first_name
   *  stores the first name string.
   *  
   * @param $last_name
   *  stores the last name string.
   *  
   * @param $email
   *  stores the email string.
   *  
   * @param $phone
   *  stores the phone number string.
   *  
   * @param $gender
   *  stores the gendr string.
   *  
   * @param $photo_url
   *  stores the profile photo string.
   *  
   * @param $link
   *  stores the link of account.
   *  
   * @param $modified
   *  stores the modification date  of account details.
   *  
   */
  public function setUser($oauth_provider, $user_id, $first_name, $last_name, $email, $phone, $gender, $photo_url, $link, $modified): void
  {
    $sql = "INSERT INTO `oauth-users` (oauth_provider, user_id , first_name, last_name, email, phone, photo_url, link ,modified ) values('" . $oauth_provider . "','" . $user_id . "','" . $first_name . "','" . $last_name . "','" . $email . "','" . $phone . "','" . $photo_url . "','" . $link . "','" . $modified . "')";
    $this->conn->query($sql);
  }

  /**
   * update online status of given user id. 
   * 
   * @param $userId
   *  stores the user id string.
   *  
   * @param $status
   *  stores the status string.
   *  
   */
  public function setOnline($userId, $status)
  {
    $this->conn->query('UPDATE `oauth-users` SET online="' . $status . '" where user_id="' . $userId . '"');

  }

  /**
   * delete post of given postId. 
   * 
   * @param $postId
   *  stores the psot id string.
   *  
   */
  public function deletePost($postId): void
  {
    $this->conn->query('SET FOREIGN_KEY_CHECKS = 0');
    $this->conn->query('DELETE FROM POSTS WHERE post_id="' . $postId . '"');
    $this->conn->query('SET FOREIGN_KEY_CHECKS = 1');
  }

}

?>
