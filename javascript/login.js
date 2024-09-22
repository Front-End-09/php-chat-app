const form = document.querySelector(".login form"),
      continueBtn = form.querySelector(".button input"),
      errorText   = form.querySelector(".error-txt");
form.onsubmit = (e)=>{
    e.preventDefault();  //preventing form from submiting
}
continueBtn.onclick = ()=>{
 // let's start ajax
  let xhr = new XMLHttpRequest(); //Create XML object
  xhr.open("POST", "php/login.php", true);
  xhr.onload = () => {
     if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            let data = xhr.response;
             if(data == "Success!"){
                location.href = "users.php";
             }else{
                errorText.textContent = data;
                errorText.style.display ="block";
             }
        }
     }
  }
    // We have to send the form data through ajax to php
    let formData = new FormData(form); // create new formData Object
    xhr.send(formData); //Sending the form data to php
}
