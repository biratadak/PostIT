<?php
  require('../vendor/autoload.php');
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use GuzzleHttp\Client;

  // Getting secret credentials using dotEnv.
  $dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotEnv->safeLoad();

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
  class Features {
    /** 
     * Checks if a string only contains alphabets and whitespaces.
     * 
     *  @param string $str
     *    Stores the string to varify.
     * 
     *  @return bool
     *    return true is string contains only alphabet else false. 
     * 
     **/
    public function onlyAlpha(string $str) {
      if (preg_match("/^[a-zA-Z-' ]*$/", $str)) {
        return TRUE;
      }
      return FALSE;
    }

    /** 
     * Fucntion to check the string only has digits.
     * 
     *  @param string $str
     *    Stores the string to varify. 
     *  
     *  @return bool
     *    Return true is string contains only digits else false. 
     *
     **/
    public function onlyDigit(string $str) {
      if (preg_match("/^[1-9][0-9]{0,15}$/", $str)) {
        return TRUE;
      }
      return FALSE;
    }

    /** 
     * Checks wether given image is jpg/png and under 500kb.
     * 
     *  @param int $imageSize
     *    Stores the size of the image. 
     * 
     *  @param string $imageType
     *    Stores the datatype of the image. 
     *
     *  @return bool
     *    Return true is image is valid  else false. 
     * 
     **/
    public function validImage(int $imageSize, string $imageType) {
      if (($imageSize / 1000) <= 500 
      && ($imageType == 'image/jpg' 
      || $imageType == 'image/png' 
      || $imageType == 'image/jpeg')) {
        return TRUE;
      } 
      else {
        if (($imageSize / 1000) > 500) {
          echo "Image size should be less than 500KB (" . ($imageSize / 1000) . "KB given)";
        }
        if ($imageType != 'image/jpg' || $imageType != 'image/png' || $imageType != 'image/jpeg') {
          echo "Only Jpeg, Jpg & Png are allowed (" . $imageType . " given)";
        }
        return FALSE;
      }
    }

    /**
     * Checks if Mail Id is valid or not using RegEx.
     * 
     *  @param string $mailId
     *    Stores the Mail Id of the user. 
     * 
     *  @return bool
     *    Return true is mail id is valid  else false. 
     * 
     **/
    public function validMailId(string $mailId) {
      if (preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix', $mailId)) {
        return TRUE;
      }
      return FALSE;
    }

    /**
     * Checks if user Id is valid or not using RegEx.
     * 
     *  @param string $userId
     *    Stores the Mail Id of the user. 
     * 
     *  @return bool
     *    Return true is user id is valid  else false. 
     * 
     **/
    public function validUserId(string $userId) {
      if (preg_match('/^[a-zA-Z0-9\s]+$/', $userId)) {
        return TRUE;
      }
      return FALSE;
    }

    /**
     * Checks Mail Id validation with mailBoxLayer API.
     * 
     *  @param string $mailId
     *    Stores the Mail Id of the user. 
     * 
     *  @return bool
     *    Return true is image is valid  else false. 
     * 
     **/
    public function validMailBox(string $mailId) {
      // API Calling using HttpGuzzle.
      $client = new Client([
        // Base uri of the site
        'base_uri' => 'https://api.apilayer.com/ ?email=',
      ]);

      $request = $client->request('GET', 'email_verification/check', [
        "headers" => [
          'apikey' => $_ENV['apiKey']
        ],
        'query' => [
          'email' => $mailId,
        ]
      ]);
      $response = $request->getBody();

      // Checking format, mx, smtp, and deliverablity score for the mail
      if (json_decode($response)->format_valid == TRUE 
      && json_decode($response)->mx_found == TRUE 
      && json_decode($response)->smtp_check == TRUE) {
        echo "(E-mail deliverablity score is: " . ((json_decode($response)->score) * 100) . "% ).";
        return TRUE;
      } 
      else { ?>
        <div class='error-div'>Error:
          <?php
          if (isset(json_decode($response)->format_valid) && json_decode($response)->format_valid == FALSE) {
            echo "E-mail format is not valid";
          }
          if (isset(json_decode($response)->mx_found) && json_decode($response)->mx_found == FALSE) {
            echo "MX-Records not found";
          }
          if (isset(json_decode($response)->smtp_check) && json_decode($response)->smtp_check == FALSE) {
            echo "SMTP validation failed";
          } ?>
        </div>
        <?php
        return FALSE;
      }
    }

    /** 
     * Send Mails using PHP-Mailer. 
     *  
     *  @param string $mailId
     *    Takes mailId as input field data of the user. 
     * 
     *   @return void
     * 
     **/
    public function sendMail(string $mailId, string $subject = "Subject", string $body = "no data found") : void {
      $mail = new PHPMailer(TRUE);

      try {
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = TRUE;
        $mail->Username = $_ENV['SMTPMail'];
        $mail->Password = $_ENV['SMTPKey'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($mailId, 'PostIt');
        $mail->addAddress($mailId);
        $mail->isHTML(TRUE);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = 'Body in plain text for non-HTML mail clients';
        $mail->send();
        echo "Mail has been sent successfully!";
      } 
      catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }

    /** 
     * Get response body from url using Guzzle.
     *  
     *  @param string $url
     *    Takes url as input and return response body. 
     * 
     *  @return Psr\Http\Message\StreamInterface
     *    returns body response of the requested url.
     **/
    public function getURL(string $url) {
      $client = new Client([
        // Base uri of the site
        'base_uri' => $url,
      ]);
      $request = $client->request('GET');
      return $request->getBody();
    }
  }
?>
