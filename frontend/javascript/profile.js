const popup = document.getElementById("popup");
const close = document.getElementById("closePop");
const edit_profile = document.getElementById("edit_profile");


edit_profile.addEventListener("click", openPopup)
function openPopup(){
    console.log("hi")
    popup.classList.add("open-popup");
}


window.onload = edit_profile;

close.addEventListener("click", closePopup)
function closePopup(){
    popup.classList.remove("open-popup");
}
