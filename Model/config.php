<?php

  /**
   * Configuration file for LinekdIn authentication.
   */
  require_once('vendor/autoload.php');
  $dotEnv = Dotenv\Dotenv::createImmutable(__DIR__);
  $dotEnv->safeLoad();
  if (!isset($_SESSION['adapter'])) {
    $config = [
      'callback' => 'http://post.it/login.php',
      'keys' => [
        'id' => $_ENV['linkedInClientId'],
        'secret' => $_ENV['linkedInClientSecret']
      ],
      'scope' => 'r_liteprofile r_emailaddress',
    ];
    $adapter = new Hybridauth\Provider\LinkedIn($config);
  }
?>
