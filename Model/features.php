<?php

require('../vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use GuzzleHttp\Client;

// Getting secret credentials using dotenv.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
/**
 * Provides some usefull features for the checking, validating and upload files.
 * 
 *  @method onlyAlpha().
 *    Checks wether given str is only alphabet or not.
 * 
 *  @method onlyDigit().
 *    Checks wether given str is only digit or not.
 * 
 *  @method validImage().
 *    Checks wether given image is jpg/png and under 500kb.
 *  
 *  @method validMailId().
 *    Checks if Mail Id is valid or not using RegEx.
 * 
 *  @method validMailBox().
 *    Checks if Mail Id is valid or not using MailBoxLayer and Guzzle.
 * 
 *  @method sendMail().
 *    Sends mail to given email Id.
 * 
 *  @method getURL().
 *    Get response body of given URL using GuzzleHTTP client request.
 * 
 **/
class features
{
  // String methods here. 

  /** 
   * Checks if a string only contains alphabets and whitespaces.
   * 
   *  @param  $str
   *    Stores the string to varify. 
   * 
   **/
  function onlyAlpha($str)
  {
    if (preg_match("/^[a-zA-Z-' ]*$/", $str)) {
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  /** 
   * Fucntion to check the string only has digits.
   * 
   *  @param  $str
   *    Stores the string to varify. 
   * 
   **/
  function onlyDigit($str)
  {
    if (preg_match("/^[1-9][0-9]{0,15}$/", $str))
      return TRUE;
    else
      return FALSE;
  }

  // Image methods here
  /** 
   *   Checks wether given image is jpg/png and under 500kb.
   * 
   *  @param  $imageSize
   *    Stores the size of the image. 
   * 
   *  @param  $imageType
   *    Stores the datatype of the image. 
   * 
   **/
  function validImage($imageSize, $imageType)
  {
    if (($imageSize / 1000) <= 500 && ($imageType == 'image/jpg' || $imageType == 'image/png' || $imageType == 'image/jpeg')) {
      return TRUE;
    } 
    else {
      if (($imageSize / 1000) > 500) {
        echo "<br>Image size should be less than 500KB (" . ($imageSize / 1000) . "KB given)";
      }
      if ($imageType != 'image/jpg' || $imageType != 'image/png' || $imageType != 'image/jpeg') {
        echo "<br>Only Jpeg, Jpg & Png are allowed (" . $imageType . " given)";
      }
      return FALSE;
    }

  }

  /**
   * Checks if Mail Id is valid or not using RegEx.
   * 
   *  @param  $mailId
   *    Stores the Mail Id of the user. 
   * 
   **/
  function validMailId(string $mailId)
  {
    if (preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $mailId)) {
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  /**
   * Checks if user Id is valid or not using RegEx.
   * 
   *  @param  $userId
   *    Stores the Mail Id of the user. 
   * 
   **/
  function validUserId(string $userId)
  {
    if (preg_match('/^[a-zA-Z0-9\s]+$/', $userId)) {
      return TRUE;
    } 
    else {
      return FALSE;
    }
  }

  /**
   * Checks Mail Id validation with mailBoxLayer API.
   * 
   *  @param  $mailId
   *    Stores the Mail Id of the user. 
   * 
   **/
  function validMailBox(string $mailId)
  {

    // API Calling using HttpGuzzle.
    $client = new Client([
      // Base uri of the site
      'base_uri' => 'https://api.apilayer.com/ ?email=',
    ]);

    $request = $client->request('GET', 'email_verification/check', [
      "headers" => [
        'apikey' => 'H2AIxxMvhiT1uUKhxs7TuSMJmysHASNI'
      ],
      'query' => [
        'email' => $mailId,
      ]
    ]);
    $response = $request->getBody();



    // Checking format, mx, smtp, and deliverablity score for the mail
    if (json_decode($response)->format_valid == TRUE && json_decode($response)->mx_found == TRUE && json_decode($response)->smtp_check == TRUE) {
      echo "<br>(E-mail deliverablity score is: " . ((json_decode($response)->score) * 100) . "% ).";
      return TRUE;
    } 
    else {
      echo "<div class='error'>Error:<br>";

      if (isset(json_decode($response)->format_valid) && json_decode($response)->format_valid == FALSE) {
        echo "E-mail format is not valid<br>";
      }
      if (isset(json_decode($response)->mx_found) && json_decode($response)->mx_found == FALSE) {
        echo "MX-Records not found<br>";
      }
      if (isset(json_decode($response)->smtp_check) && json_decode($response)->smtp_check == FALSE) {
        echo "SMTP validation failed<br>";
      }
      echo "</div>";
      return false;
    }
  }

  /** 
   * Send Mails using PHP-Mailer. 
   *  @param  $mailId
   *    Takes mailId as input field data of the user. 
   * 
   **/
  function sendMail(string $mailId, string $subject = "Subject", string $body = "no data found")
  {
    $mail = new PHPMailer(true);

    try {
      $mail->SMTPDebug = 0;
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = $_ENV['SMTPMail'];
      $mail->Password = $_ENV['SMTPKey'];
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom($mailId, 'PostIt');
      $mail->addAddress($mailId);

      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = $body;
      $mail->AltBody = 'Body in plain text for non-HTML mail clients';
      $mail->send();
      echo "<div class='success'>Mail has been sent successfully!</div>";
    } 
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }

  /** 
   * Get response body from url using Guzzle.
   *  @param  $url
   *    Takes url as input and return response body. 
   *  @return Psr\Http\Message\StreamInterface
   **/
  function getURL(string $url)
  {
    $client = new Client([
      // Base uri of the site
      'base_uri' => $url,
    ]);
    $request = $client->request('GET');
    return $request->getBody();
  }

}

?>
