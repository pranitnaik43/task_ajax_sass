
function validate(name, value) {
  // console.log(name, value)
  switch(name) {
    case "first_name":
    case "last_name":
    case "email":
    case "contact":
      if(!value) {  
        return { valid: false, message: "Please fill all the details" };
      }
      break;
    case "dob":
      if(!value) {  
        return { valid: false, message: "Date of Birth cannot be empty" };
      }
      var varDate = new Date(value); //dd-mm-YYYY
      var today = new Date();

      if(varDate > today) {
        return { valid: false, message: "Invalid Date" };
      }
      break;
    case "password":
      if(!value)
        return { valid: false, message: "Password cannot be empty" };
      if(value<6) {
        return { valid: false, message: "Password should have atleast 6 characters." };
      }
      if (value.search(/[a-z]/i) < 0) {
        return { valid: false, message: "Your password must contain at least one letter." };
      }
      if (value.search(/[0-9]/) < 0) {
        return { valid: false, message: "Your password must contain at least one digit." };
      }
      break;
    default:
      return { valid: true };
  }
  return { valid: true };
}

function register() {
  //get form data
  let myForm = document.getElementById("signupForm");
  let formData = new FormData(myForm);
  const data = {}; 
  for (let [key, val] of formData.entries()) {
    //validate values
    let isValid = validate(key, val);
    if(!isValid.valid) {
      alert(isValid.message);
      return false;
    }
    Object.assign(data, { [key]: val });
  }
  // console.log(formData, data, JSON.stringify(data));

  //ajax call to php for saving data
  $.ajax({
    method: 'POST',
    url: 'http://localhost:3000/php/register.php',
    data: data,
    success: function (response) {
      // console.log("success", response, typeof response);
      let data = JSON.parse(response);
      // console.log("data",data, typeof data)
      if(data["success"]===false) {
        alert(data["message"]);
      }
      if(data["success"]===true) {
        //redirect to login on success
        window.location.href = "login.html";
      }
    },
    error: function (data) {
      console.log("error", data)
    }
  });
}

function login() {
  //get form data
  let myForm = document.getElementById("loginForm");
  let formData = new FormData(myForm);
  const data = {}; 
  for (let [key, val] of formData.entries()) {
    Object.assign(data, { [key]: val });
  }
  let email = data.email;
  if(!email) {
    alert("Email cannot be empty");
    return false;
  }
  // console.log(formData, data, JSON.stringify(data));

  //ajax call to php for saving data
  $.ajax({
    method: 'POST',
    url: 'http://localhost:3000/php/login.php',
    data: data,
    success: function (response) {
      console.log("success", response, typeof response);
      let data = JSON.parse(response);
      // console.log("data",data, typeof data)
      if(data["success"]===false) {
        alert(data["message"]);
      }
      if(data["success"]===true) {
        //redirect to home on success
        document.cookie = JSON.stringify({email: email});
        window.location.href = "index.html";
      }
    },
    error: function (data) {
      console.log("error", data)
    }
  });
}

$("#signupForm").on("submit", (e) => {
  e.preventDefault();
  register();
})

$("#signupSubmit").on("click", (e) => {
  e.preventDefault();
  register();
})

$("#loginForm").on("submit", (e) => {
  e.preventDefault();
  login();
})

$("#loginSubmit").on("click", (e) => {
  e.preventDefault();
  login();
})