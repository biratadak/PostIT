  // Check validation for name, mail, userId and password errors.
  function validate() {
    if (document.getElementsByName("nameerr")[0].innerHTML == "" && document.getElementsByName("mailerr")[0].innerHTML == "" && document.getElementsByName("usererr")[0].innerHTML == "" && document.getElementsByName("passerr")[0].innerHTML == "") {
      return true;
    }
    else {
      return false;
    }
  };

  allLetter("name", "nameerr");
  validMail("mailId", "mailerr");
  validUser("userId", "usererr");
  validPass("pass", "passerr");
  togglePass("#togglePassword", "#pass");
  countDown(".counter", 10);
