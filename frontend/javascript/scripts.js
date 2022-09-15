
console.log("helloooo")

let popup = document.getElementById("popup");
let signup = document.getElementById("signup");
let close = document.getElementById("closePop");
console.log("hi")


signup.addEventListener("click", openPopup)
function openPopup(){
    popup.classList.add("open-popup");
    console.log("bye")
}
window.onload = signup;



close.addEventListener("click", closePopup)
function closePopup(){
    popup.classList.remove("open-popup");
}


