
/**
 * Function to check only alphabet and spaces in given name field.
 * 
 *  @param string fieldName
 *    Field name where to check the error.
 * 
 *  @param string errorFieldName
 *    Name of the field to display error if occured.
 *    
 * */ 
function allLetter(fieldName, errorFieldName) {
  document.getElementsByName(fieldName)[0].onchange = function () {
    inputtxt = document.getElementsByName(fieldName)[0].value;
    var pattern = /^[A-Za-z-' ]+$/;
    if (inputtxt.match(pattern)) {
      document.getElementsByName(errorFieldName)[0].innerHTML = "";
    } 
    else {
      document.getElementsByName(errorFieldName)[0].innerHTML =
        "Only letters and white space allowed";
    }
  };
}

/**
 * Function to check valid Indian phone no.
 * 
 *  @param string fieldName
 *    Field name where to check the error.
 * 
 *  @param string errorFieldName
 *    Name of the field to display error if occured.
 *    
 * */
function validPhone(fieldName, errorFieldName) {
  document.getElementsByName(fieldName)[0].onkeyup = function () {
    inputtxt = document.getElementsByName(fieldName)[0].value;
    var pattern = /^[+][9][1][6-9][0-9]{9}$/;
    if (inputtxt.match(pattern)) {
      document.getElementsByName(errorFieldName)[0].innerHTML = "";
    } 
    else {
      if (inputtxt.slice(0, 3) != "+91") {
        document.getElementsByName(errorFieldName)[0].innerHTML =
          "Add +91 beggining";
      } 
      else {
        document.getElementsByName(errorFieldName)[0].innerHTML =
          "Invalid Number";
      }
    }
  };
}

/**
 * Function to check valid mail id.
 * 
 *  @param string fieldName
 *    Field name where to check the error.
 * 
 *  @param string errorFieldName
 *    Name of the field to display error if occured.
 *    
 * */
function validMail(fieldName, errorFieldName) {
  document.getElementsByName(fieldName)[0].onkeyup = function () {
    inputtxt = document.getElementsByName(fieldName)[0].value;
    var pattern = /^[a-z0-9-.]{1,20}[@][a-z]{1,10}[.][a-z]{2,4}$/;
    if (inputtxt.match(pattern)) {
      document.getElementsByName(errorFieldName)[0].innerHTML = "";
    } 
    else {
      document.getElementsByName(errorFieldName)[0].innerHTML =
        "Invalid Mail Id";
    }
  };
}

/**
 * Function to check valid Indian phone no.
 * 
 *  @param string fieldName
 *    Field name where to check the error.
 * 
 *  @param string errorFieldName
 *    Name of the field to display error if occured.
 *    
 * */
function validUser(fieldName, errorFieldName) {
  document.getElementsByName(fieldName)[0].onkeyup = function () {
    inputtxt = document.getElementsByName(fieldName)[0].value;
    var pattern = /^[A-Za-z-0-9]+$/;
    if (inputtxt.match(pattern)) {
      document.getElementsByName(errorFieldName)[0].innerHTML = "";
    }
    else {
      document.getElementsByName(errorFieldName)[0].innerHTML =
        "User Id should only contain alphabet and number";
    }
  };
}

/**
 * Function to check Password has atleast one char,digit and Special character.
 * 
 *  @param string fieldName
 *    Field name where to check the error.
 * 
 *  @param string errorFieldName
 *    Name of the field to display error if occured.
 *    
 * */
function validPass(fieldName, errorFieldName) {
  document.getElementsByName(fieldName)[0].onkeyup = function () {
    inputtxt = document.getElementsByName(fieldName)[0].value;
    var pattern = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (inputtxt.match(pattern)) {
      document.getElementsByName(errorFieldName)[0].innerHTML = "";
    } 
    else {
      // Checks for atleast one digit.
      if (!inputtxt.match(/^(?=.*\d)/)){
        document.getElementsByName(errorFieldName)[0].innerHTML =
        "*Password should contain atleast one digit";
      }
      // Checks for atleast one alphabet.
      else if (!inputtxt.match(/^(?=.*[a-z])(?=.*[A-Z])/)){
        document.getElementsByName(errorFieldName)[0].innerHTML =
        "*Password should contain atleast one uppercase and lowercase";
      }
      // Checks for atleast one special character.
      else if (!inputtxt.match(/^(?=.*[!@#$%^&*])/)){
        document.getElementsByName(errorFieldName)[0].innerHTML =
        "*Password should contain atleast special character";
      }
      else {
        document.getElementsByName(errorFieldName)[0].innerHTML = "";
      }
      // If password is not between 8 and 16 characters then show error.
      if (length(inputtxt) < 8 && length(inputtxt) < 16) {
        document.getElementsByName(errorFieldName)[0].innerHTML =
          "*Password should contain 8 to 16";
      }
    }
  };
}

/**
 * Toggle show and hide password script.
 * 
 *  @param string buttonField
 *    Field name where to check the error.
 * 
 *  @param string passField
 *    Name of the password field.
 *    
 * */
function togglePass(buttonField, passField) {
  const togglePassword = document.querySelector(buttonField);
  const password = document.querySelector(passField);
  togglePassword.addEventListener("click", function () {
    // Toggle the type attribute.
    const type =
      password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    // Toggle the icon.
    this.classList.toggle("bi-eye");
  });
}

/**
 * Countdown timer after some delay.
 * 
 *  @param string displayQuerySelector
 *    Field name where to shoe countdown.
 * 
 *  @param string delay
 *    Name of the password field.
 *    
 * */
function countDown(displayQuerySelector, delay) {
  // Holds the display field of timer.
  const field = document.querySelector(displayQuerySelector);

  // Holds the delay duration in seconds.
  let num = parseInt(delay);
  const i = setInterval(() => {
    num -= 1;
    field.innerText = num;
    if (num === 0) {
      clearInterval(i);
    }
  }, 1000);
}
