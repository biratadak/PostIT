  /**
   * Check validation for sending forgot password mail.
   * 
   *  */ 
  function validate() {
    if (document.getElementsByName("mailerr")[0].innerHTML == "") {
      return true;
    }
    else {
      return false;
    }
  };

  validMail("mailId", "mailerr");
  countDown(".counter", 10);
