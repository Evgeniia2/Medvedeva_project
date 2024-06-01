function togglePasswordVisibility() {
  var password1 = document.getElementById("password_1");
  var password2 = document.getElementById("password_2");
  var password = document.getElementById("login_password");
  
  if (password1 && password2) {
    if (password1.type === "password") {
      password1.type = "text";
      password2.type = "text";
    } else {
      password1.type = "password";
      password2.type = "password";
    }
  }

  if (password) {
    if (password.type === "password") {
      password.type = "text";
    } else {
      password.type = "password";
    }
  }
}
