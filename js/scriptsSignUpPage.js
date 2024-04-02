 /*This is the first script for showing the first password for
  the enter password field*/
function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }

  /*This is the second script for showing the second password for
  the confim password field*/
  
function myFunction2() {
  var x = document.getElementById("confirmPassword");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

/*Below is the code for validating password entered */
function passCheck(){
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;

    if (password != confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }
    /* here the condition for matching password is met, hence no prompt is to be displayed*/
    return true;
}

