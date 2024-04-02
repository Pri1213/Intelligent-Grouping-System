/*date in footer*/ 
const d = new Date();
document.getElementById("demo").innerHTML = d;

/*Scroll reveal for homepage: animation*/
const sr = ScrollReveal ({
     distance: '60px',
     duration: 2500,
     reset: true
})

sr.reveal('.home-text',{delay:200, origin:'top'})

/*form validation*/
const form = document.getElementById("myForm");
if(form !== null && form !== "undefined" && form.length > 0 ){
  form.addEventListener("submit", function(event) {
    event.preventDefault(); // prevent the form from submitting
    
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const message = document.getElementById('message').value;
  
    if (name === "") {
      alert("Please enter your full name.");
      return;
    }
    
    if (email === "") {
      alert("Please enter your email address.");
      return;
    }
    
    if (!validateEmail(email)) {
      alert("Please enter a valid email address.");
      return;
    }
  
    if (message === '') {
       alert('Please enter a message');
       return;
   }
  
    // if all validation passes, submit the form
    form.submit();
  });
}


function validateEmail(email) {
  // a simple email validation using regular expression
  const regex = /^\S+@\S+\.\S+$/;
  return regex.test(email);
}
