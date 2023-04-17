  /**
   * Check validation for sending forgot password mail.
   * 
   *  @returns bool
   *    return true if element found else false.
   *  */ 
  function validate() {
    if (document.getElementsByName("mailerr")[0].innerHTML == "") {
      return TRUE;
    }
    else {
      return FALSE;
    }
  };

  validMail("mailId", "mailerr");
  countDown(".counter", 10);
