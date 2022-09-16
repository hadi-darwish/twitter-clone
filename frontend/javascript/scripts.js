const popup = document.getElementById("popup");
const signup = document.getElementById("signup");
const close = document.getElementById("closePop");
const next = document.getElementById("next-btn");


signup.addEventListener("click", openPopup)
function openPopup(){
    popup.classList.add("open-popup");
}


window.onload = signup;

close.addEventListener("click", closePopup)
function closePopup(){
    popup.classList.remove("open-popup");
}

