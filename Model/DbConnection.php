<?php

// Loaded all required libraries.
require("../vendor/autoload.php");
// Loading .env credentials.
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
      echo "Connection error:" . $connect->connect_error;
    }
    $this->conn = $connect;
  }

  /**
   * Checks if user's user_id exists. 
   * 
   * @param $userId
   *  Stores the user Id string.
   *  
   * @return bool
   *  Returns TRUE if user exists ,else FALSE.
   */
  public function existsUserId(String $userId)
  {
    if (isset($this->conn->query("select user_id from `oauth-users` where `user_id`='" . $userId . "'")->fetch_assoc()['user_id']))
      return TRUE;
    else
      return FALSE;
  }

  /**
   * Checks if user's mail id exists. 
   * 
   * @param $mailId
   *  Stores the mail Id string.
   *  
   * @return bool
   *  Returns TRUE if mail id exists ,else FALSE.
   */
  public function existsMailId(String $mailId)
  {
    if (isset($this->conn->query("select email from `oauth-users` where email='" . $mailId . "'")->fetch_assoc()['email']))
      return TRUE;
    else
      return FALSE;
  }

  /**
   * Sends query response as array. 
   * 
   * @param $query
   *  Stores the query string.
   *  
   * @return array
   *  Response of the query string.
   */
  public function getQueryArray(String $query)
  {
    $queryResponse = $this->conn->query($query);
    foreach ($queryResponse as $value) {
      $response[] = $value;
    }
    return $response;
  }


  /**
   * Get photo url of user by id. 
   * 
   * @return string
   *  Returns path of image if user exists ,else empty string.
   */
  public function getPhotoURLbyId(Int $Id)
  {
    if (isset($this->conn->query('select photo_url from `oauth-users` where id="' . $Id . '"')->fetch_assoc()['photo_url']))
      return $this->conn->query('select photo_url from `oauth-users` where id="' . $Id . '"')->fetch_assoc()['photo_url'];
    else
      return "";

  }

  /**
   * Get counts of all users. 
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
   * Get photo url of user by user id. 
   * 
   * @return string
   *  Returns path of image if user exists ,else empty string.
   */
  public function getPhotoURLbyUserId(String $userId)
  {
    if (isset($this->conn->query('select photo_url from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['photo_url']))
      return $this->conn->query('select photo_url from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['photo_url'];
    else
      return "";

  }


  /**
   * Get Password of given userId. 
   * 
   * @param $userId
   *  Stores the user Id string.
   *  
   * @return string
   *  Returns pass if user exists ,else return empty string.
   */
  public function getPass(String $userId)
  {
    
    if ($this->existsMailId($userId) && isset($this->conn->query("select pass from `oauth-users` where email='" . $userId . "'")->fetch_assoc()['pass']))
      return $this->conn->query("select pass from `oauth-users` where email='" . $userId . "'")->fetch_assoc()['pass'];
    else if ($this->existsUserId($userId) && isset($this->conn->query("select pass from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['pass']))
      return $this->conn->query("select pass from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['pass'];
    else
      return "";

  }

  /**
   * Get name of given userId. 
   * 
   * @param $userId
   *  Stores the user Id string.
   *  
   * @return string
   *  Returns name if user exists ,else return empty string.
   */
  public function getName(String $userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select first_name from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT CONCAT_WS(" ", `first_name`, `last_name`) as `fullname` from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['fullname'];
    else
      return "";

  }

  /**
   * Get name of given ID. 
   * 
   * @param $id
   *  Stores the Id .
   *  
   * @return string
   *  Returns Name if ID exists ,else return empty string.
   */
  public function getNamebyId(Int $id)
  {
    if (isset($this->conn->query("select first_name from `oauth-users` where id='" . $id . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT CONCAT_WS(" ", `first_name`, `last_name`) as `fullname` from `oauth-users` where id="' . $id . '"')->fetch_assoc()['fullname'];
    else
      return "";

  }

  /**
   * Get Id of given userId. 
   * 
   * @param $userId
   *  Stores the user Id string.
   *  
   * @return string
   *  Returns ID if user exists ,else return empty string.
   */
  public function getId(String $userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select id from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['id']))
      return $this->conn->query('SELECT id from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['id'];
    else
      return "";

  }

  /**
   * Get About of given userId. 
   * 
   * @param $userId
   *  Stores the user Id string.
   *  
   * @return string
   *  Returns about if user exists ,else return empty string.
   */
  public function getAbout(String $userId)
  {
    if ($this->existsUserId($userId) && isset($this->conn->query("select first_name from `oauth-users` where user_id='" . $userId . "'")->fetch_assoc()['first_name']))
      return $this->conn->query('SELECT `about` from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['about'];
    else
      return "";

  }

  /**
   * Get all users of ordered by given order,
   * by default it order by first_name.  
   * 
   * @param $order
   *  Stores the order string.
   *  
   * @return mysqli_result
   *  Returns all users ordered by givenr order.
   */
  public function getAllUsers(String $order = "first_name")
  {
      return $this->conn->query("SELECT * from `oauth-users` ORDER BY " . $order);

  }

  /**
   * Get limit number of posts of ordered by given order. 
   * 
   * @param $order
   *  Stores the order string.
   * 
   * @param $limit
   *  Stores the limit string.
   *  
   * @return mysqli_result
   *  Returns limit numbers of posts ordered by given order .
   */
  public function getAllPosts(String $order = "post_id", Int $limit = 5)
  {
      return $this->conn->query("SELECT * from `posts` ORDER BY " . $order . " LIMIT " . $limit);
  }

  /**
   * Get online status of given userId. 
   * 
   * @param $userId
   *  Stores the user id string.
   *  
   * @return string
   *  Online status of user
   */
  public function getOnline(String $userId)
  {
    return $this->conn->query('select online from `oauth-users` where user_id="' . $userId . '"')->fetch_assoc()['online'];
  }

  /**
   * Get like count of given postId. 
   * 
   * @param $postId
   *  Stores the post id string.
   *  
   * @return int
   *  Like count of posts
   */
  public function getLikeCountbyPostId(Int $postId)
  {
    return $this->conn->query('SELECT count(*) from likes where `post_id`="' . $postId . '"')->fetch_array()[0];
  }

   /**
   * Get postIds of liked posts only. 
   * 
   * @param $userId
   *  Stores the user id string.
   *  
   * @return object
   *  Id's of posts
   */
  public function getLikedPostId(Int $userId)
  {
    return $this->conn->query('SELECT `post_id` from likes WHERE `id`=' . $userId);
  }

  /**
   * Get post id of given userId as string. 
   * 
   * @param $userId
   *  Stores the user id string.
   *  
   * @return string
   *  Array of post ids 
   */
  public function getPostIdbyUserId(Int $userId)
  {
    $str = "";
    foreach ($this->conn->query("SELECT post_id from likes where `id`=" . $userId)->fetch_all() as $r)
      $str .= ($r[0] . ' ');
    return $str;
  }

  /**
   * Set new created post to database. 
   * 
   * @param $id
   *  Stores the id of post.
   * 
   * @param $content
   *  Stores the content text of post.
   * 
   * @param $name
   *  Stores the name of post.
   * 
   * @param $audio
   *  Stores the audio link with filename of post.
   * 
   * @param $video
   *  Stores the video link with filename of post.
   * 
   * @param $photo
   *  Stores the photo link with filename of post.
   *  
   */
  public function setPost(Int $id, String $content, String $name, String $audio = "", String $video = "", String $photo = ""): void
  {
    $this->conn->query('INSERT INTO `posts` (id,content,name,audio,video,photo)
   values(' . $id . ',"' . $content . '","' . $this->getNamebyId($id) . '","' . $audio . '","' . $video . '","' . $photo . '")');
  }

  /**
   * Sets users details. 
   * 
   * @param $oauth_provider
   *  Stores the oauth provider string.
   *  
   * @param $user_id
   *  Stores the user id  string.
   *  
   * @param $first_name
   *  Stores the first name string.
   *  
   * @param $last_name
   *  Stores the last name string.
   *  
   * @param $email
   *  Stores the email string.
   *  
   * @param $phone
   *  Stores the phone number string.
   *  
   * @param $gender
   *  Stores the gendr string.
   *  
   * @param $photo_url
   *  Stores the profile photo string.
   *  
   * @param $link
   *  Stores the link of account.
   *  
   * @param $modified
   *  Stores the modification date  of account details.
   *  
   */
  public function setUser(String $oauth_provider, String $user_id, String $first_name, String $last_name, String $email, String $phone, String $gender, String $photo_url, String $link, String $modified): void
  {
    $sql = "INSERT INTO `oauth-users` (oauth_provider, user_id , first_name, last_name, email, phone, photo_url, link ,modified ) values('" . $oauth_provider . "','" . $user_id . "','" . $first_name . "','" . $last_name . "','" . $email . "','" . $phone . "','" . $photo_url . "','" . $link . "','" . $modified . "')";
    $this->conn->query($sql);
  }

  /**
   * Update online status of given user id. 
   * 
   * @param $userId
   *  Stores the user id string.
   *  
   * @param $status
   *  Stores the status string.
   *  
   */
  public function setOnline(String $userId, String $status)
  {
    $this->conn->query('UPDATE `oauth-users` SET online="' . $status . '" where user_id="' . $userId . '"');
  }

  /**
   * Delete post of given postId. 
   * 
   * @param $postId
   *  Stores the psot id string.
   *  
   */
  public function deletePost(Int $postId):void
  {
    $this->conn->query('SET FOREIGN_KEY_CHECKS = 0');
    $this->conn->query('DELETE FROM POSTS WHERE post_id="' . $postId . '"');
    $this->conn->query('SET FOREIGN_KEY_CHECKS = 1');
  }

}

?>
