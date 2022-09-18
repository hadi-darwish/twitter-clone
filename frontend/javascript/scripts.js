const popup = document.getElementById("popup");
const signup = document.getElementById("signup");
const close = document.getElementById("closePop");
const next = document.getElementById("next-btn");

//hadi
const login = document.getElementById("login");
const email = document.getElementById("email-login");
const password = document.getElementById("password-login");
const errorMsg = document.getElementById("error-messages");
const form = document.querySelector("form");
let error = "";

login.onclick = (event) => {
  event.preventDefault();
  errorMsg.style.display = "none";
  error = "";
  if (!(checkEmail() && checkPassword())) {
    console.log(!(checkEmail() && checkPassword()));
    errorMsg.style.display = "block";
    errorMsg.innerHTML = error;
    return false;
  } else {
    let shi = {
      method: "POST",
      body: new URLSearchParams({
        email: email.value,
        password: password.value,
      }),
    };
    fetch("http://localhost/twitter-apis/login-confirm.php", shi)
      .then((res) => res.json())
      .then((data) => {
        if (data.confirmation == "not found") {
          error += "Email Not Found<br>";
          errorMsg.style.display = "block";
          errorMsg.innerHTML = error;
        } else if (data.confirmation == "false") {
          error += "WRONG PASSWORD!!<br>";
          errorMsg.style.display = "block";
          errorMsg.innerHTML = error;
        } else {
          localStorage.setItem("user_id", data.id);
          location.replace("../feed.html");
        }
      });
  }
};
function checkEmail() {
  if (!/(^[\w-\.]{3,})+@(([\w-]{5,})+\.)+[\w-]{2,4}$/.test(email.value)) {
    email.style.borderColor = "red";
    error +=
      "Please enter email with at least 3 characters before @ and 5 after!!<br>";
    return false;
  }
  email.style.borderColor = "green";
  return true;
}

function checkPassword() {
  if (!/^(\w){12,}$/.test(password.value)) {
    password.style.borderColor = "red";
    error += "password is at least 12 characters!!<br>";
    return false;
  }

  password.style.borderColor = "green";
  return true;
}
//hadi

signup.addEventListener("click", openPopup);
function openPopup() {
  popup.classList.add("open-popup");
}

window.onload = signup;
close.addEventListener("click", closePopup);
function closePopup() {
  popup.classList.remove("open-popup");
}
