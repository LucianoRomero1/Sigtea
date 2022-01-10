function showPassword() {
    var x = document.getElementById("fos_user_registration_form_plainPassword_first");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}

function showConfirmPassword() {
    var x = document.getElementById("fos_user_registration_form_plainPassword_second");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
}

function showResetPassword() {
  var x = document.getElementById("fos_user_resetting_form_plainPassword_first");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function showResetPasswordConfirm() {
  var x = document.getElementById("fos_user_resetting_form_plainPassword_second");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function showCurrentPassword() {
  var x = document.getElementById("fos_user_profile_form_current_password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

function showAll(){
  var x = document.getElementById("fos_user_change_password_form_current_password");
  var y = document.getElementById("fos_user_change_password_form_plainPassword_first");
  var z = document.getElementById("fos_user_change_password_form_plainPassword_second");
  if (x.type === "password" && y.type === "password" && z.type === "password") {
    x.type = "text";
    y.type = "text";
    z.type = "text";
  } else {
    x.type = "password";
    y.type = "password";
    z.type = "password";
  }
}