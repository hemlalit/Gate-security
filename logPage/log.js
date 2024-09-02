// function goToHome() {
//     window.location.href = "../userpage/users.html";
// }
const loader = document.querySelector('.preloader')
window.addEventListener('load', function(){
    loader.style.display = "none"
})

const pwdfield = document.querySelector("form input[type='password']"),
togglebtn = document.querySelector("form .form-element i");

togglebtn.onclick = () => {
    if(pwdfield.type == "password"){
        pwdfield.type = "text";
        togglebtn.classList.add("active");
    }else{
        pwdfield.type = "password";
        togglebtn.classList.remove("active");
    }
}

window.history.forward();