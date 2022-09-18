const popup = document.getElementById("popup");
const signup = document.getElementById("signup");
const close = document.getElementById("closePop");
const prevbtn = document.querySelectorAll(".btn-prev");
const nextbtn = document.querySelectorAll(".btn-next");
const formstep = document.querySelectorAll(".form-step");


let formstepsnum = 0 ;

nextbtn.forEach( btn => {
    btn.addEventListener('click' , () => {
       formstep++;
       UpdateFormSteps();
    })
})

function UpdateFormSteps(){
    formstep[formstep].classList.add("form-step-acive")
}


signup.addEventListener("click", openPopup)
function openPopup(){
    popup.classList.add("open-popup");
}


window.onload = signup;

close.addEventListener("click", closePopup)
function closePopup(){
    popup.classList.remove("open-popup");
}



