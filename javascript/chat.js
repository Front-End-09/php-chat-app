const form = document.querySelector(".typing-area"),
      inputField = form.querySelector(".input-field"),
      sendBtn    = form.querySelector("button"),
      chatBox    = document.querySelector(".chat-box");

form.onsubmit = (e)=>{
    e.preventDefault();  //preventing form from submiting
}
sendBtn,onclick = () =>{
    // let's start ajax
  let xhr = new XMLHttpRequest(); //Create XML object
  xhr.open("POST", "php/insert-chat.php", true);
  xhr.onload = () => {
     if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
            inputField.value = ""; //once message inserted into database then leave blank the input field
        }
     }
    }
    // We have to send the form data through ajax to php
    let formData = new FormData(form); // create new formData Object
    xhr.send(formData); //Sending the form data to php
}
setInterval(() => {
    // let's start ajax
    let xhr = new XMLHttpRequest(); //Create XML object
    xhr.open("POST", "php/get-chat.php", true);
    xhr.onload = () => {
       if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              chatBox.innerHTML = data;
          }
       }
    }
    // We have to send the form data through ajax to php
    let formData = new FormData(form); // create new formData Object
    xhr.send(formData); //Sending the form data to php
  }, 5000); //this function will run frequently after 500ms
