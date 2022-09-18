const popup = document.getElementById("popup");
const close = document.getElementById("closePop");


edit_profile.addEventListener("click", openPopup)
function openPopup(){
    popup.classList.add("open-popup");
}


window.onload = edit_profile;

close.addEventListener("click", closePopup)
function closePopup(){
    popup.classList.remove("open-popup");
}
