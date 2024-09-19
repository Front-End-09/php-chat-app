const psawrdField = document.querySelector(".form input[type='password']");
togleBtn = document.querySelector(".form .field i");

togleBtn.onclick = ()=>{
    if(psawrdField.type == "password"){
        psawrdField.type = "text";
        togleBtn.classList.add("active");
    }else{
        psawrdField.type = "password";
        togleBtn.classList.remove("active");
    }
}