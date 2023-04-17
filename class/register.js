  /**
   * Check validation for name, mail, userId and password errors.
   * 
   *  @returns bool
   *    If no error found returns TRUE else FALSE.
   */
  function validate() {
    if (document.getElementsByName("nameerr")[0].innerHTML == "" 
    && document.getElementsByName("mailerr")[0].innerHTML == "" 
    && document.getElementsByName("usererr")[0].innerHTML == "" 
    && document.getElementsByName("passerr")[0].innerHTML == "") {
      return TRUE;
    }
      return FALSE;
  };
  
  // Checks if all charecters are letters only
  allLetter("name", "nameerr");

  // Checks if mail is valid.
  validMail("mailId", "mailerr");

  // Checks if userId is valid.
  validUser("userId", "usererr");

  // Checks if password is valid.
  validPass("pass", "passerr");

  // Toggle the hide/show password.
  togglePass("#togglePassword", "#pass");

  // show countdown of 10 sec in the given field.
  countDown(".counter", 10);
