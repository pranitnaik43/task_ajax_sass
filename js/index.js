function redirectToLogin() {
  window.location.href = "login.html";
}

function calculateAge(dob) {
  return Math.floor((new Date() - new Date(dob).getTime()) / 3.15576e+10)
}

$('#logout').on("click", function() {
  document.cookie = "";
  
})

$(document).ready(function() {
  try {
    let cookie = document.cookie;
    let cookieObj = JSON.parse(cookie);
    let email = cookieObj.email;
    if(!email)  redirectToLogin();
  
    console.log(cookie, cookieObj)

    $.ajax({
      method: 'GET',
      url: 'http://localhost:3000/php/getData.php',
      data: {email: email},
      success: function (response) {
        // console.log("success", response, typeof response);
        let responseObj = JSON.parse(response);
        let data = responseObj.data;
        console.log("data",data, typeof data)
        if(responseObj["success"]===true) {
          console.log("check", $("#emailVal"));
          if(data.first_name && data.last_name) 
            $("#nameVal").text(data.first_name + " " + data.last_name);
          if(data.email) 
            $("#emailVal").text(data.email);
          if(data.contact) 
            $("#contactVal").text(data.contact);
          if(data.dob) {
            let dob = new Date(data.dob);
            let currentDate = new Date();
            $("#dobVal").text("DOB: "+ data.dob);
            $("#ageVal").text("Age: "+ calculateAge(data.dob));
          }
        }
        else {
          window.location.href = "login.html";
        }
      },
      error: function (data) {
        console.log("error", data)
      }
    });
  } catch(err) {
    console.log(err);
  }
});
