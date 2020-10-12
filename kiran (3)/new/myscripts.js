//Validation function. Validates all input form fields
function validateFunction() {

document.getElementById("nameError").innerHTML = "";
document.getElementById("numError").innerHTML = "";
document.getElementById("numError").innerHTML = "";
document.getElementById("mailError").innerHTML = "";
document.getElementById("provError").innerHTML = "";
document.getElementById("cityError").innerHTML = "";
document.getElementById("zipError").style.display = "";
document.getElementById("dobError").style.display = "";
document.getElementById("passError").style.display = "";


document.getElementById("nameError").style.display = "none";
document.getElementById("numError").style.display = "none";
document.getElementById("mailError").style.display = "none";
document.getElementById("provError").style.display = "none";
document.getElementById("cityError").style.display = "none";
document.getElementById("zipError").style.display = "none";
document.getElementById("dobError").style.display = "none";
document.getElementById("passError").style.display = "none";


var name, num, email, city, prov, numberLength ;
var errorText = "This is a required field. Please make sure you enter your relevant details.";
var count = 0;
    
  name = document.getElementById("name").value;
  num = document.getElementById("number").value;
  email = document.getElementById("email").value;
  password = document.getElementById("password").value;
  city = document.getElementById("city").value;
  prov = document.getElementById("province").value;
  numberLength = document.getElementById("number").value.length;



 var PROVS = {
    EC : {value: 0, name: "Ontario"}, 
    FS: {value: 1, name: "Manitoba"},
    GT : {value: 2, name: "Alberta"},
    KZN : {value: 3, name: "Nova scotia"},
    LM : {value: 4, name: "Nuvat"},
    MP : {value: 5, name: "yukon"},
    NC : {value: 6, name: "Prince Edward"},
    NW : {value: 7, name: "British columbia"},
    WC : {value: 8, name: "Quebec"},
}
 
//Validation and Assign errors

      if (name == ""){
           document.getElementById("nameError").innerHTML = errorText;
           document.getElementById("nameError").style.display = "block";
           count++;
      }
      if (num == ""){
           document.getElementById("numError").innerHTML = errorText;
           document.getElementById("numError").style.display = "block";
           count++;
      }
      else if(num < 0 || isNaN(num) || numberLength != 10 || num[0] != 0){
            document.getElementById("numError").innerHTML = "Please enter a valid mobile number.";
            document.getElementById("numError").style.display = "block";
            count++;
      }

      if (email == ""){
           document.getElementById("mailError").innerHTML = errorText;
           document.getElementById("mailError").style.display = "block";
           count++;
      } 
      else if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)))
      {
            document.getElementById("mailError").innerHTML = "Please enter a valid email address.";
            document.getElementById("mailError").style.display = "block";
            count++;
      }

      if (prov == ""){
           document.getElementById("provError").innerHTML = errorText;
           document.getElementById("provError").style.display = "block";
           count++;
      }
        else if (prov != PROVS.EC.name && prov != PROVS.FS.name && prov != PROVS.GT.name && prov != PROVS.KZN.name && 
        prov != PROVS.LM.name && prov != PROVS.MP.name && prov != PROVS.NC.name && prov != PROVS.NW.name && prov != PROVS.WC.name)//check that prov == 1 of the nine provinces
      {
            document.getElementById("provError").innerHTML = "Please select a valid Province.";
            document.getElementById("provError").style.display = "block";
            count++;
      }

      if (city == ""){
           document.getElementById("cityError").innerHTML = errorText;
           document.getElementById("cityError").style.display = "block";
           count++;
      }

      if (name == ""){
          document.getElementById("zipError").innerHTML = errorText;
          document.getElementById("zipError").style.display = "block";
          count++;
     }
     if ( name== ""){
          document.getElementById("dobError").innerHTML = errorText;
          document.getElementById("dobError").style.display = "block";
          count++;
     }

     if ( name== ""){
          document.getElementById("passError").innerHTML = errorText;
          document.getElementById("passError").style.display = "block";
          count++;
     }

        //Validate zip code (basic)
    if ($("#zip").val()) {
     let zip = $("#zip").val();
     let patt = /[^0-9]/g;
     
     let testZip = patt.exec(zip);
     if(testZip) {
       errors.push("zip");
     }
     else if (zip.length != 5) {
       errors.push("zip");
     }
   }
   

   if (count > 0)
   {
    return false;
   }
   
}

//Length Function for mobile number input. Limits it at 10 digits
function lengthFunc(){
  var numLength = document.getElementById("number").value.length;
  var number = document.getElementById("number").value;
  if (numLength > 10){
    document.getElementById("number").value = number.slice(0, 10);
  }
}



// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

