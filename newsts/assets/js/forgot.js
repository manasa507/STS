/*
@desc to check email validation
*/
function validate()
{
  var email = document.login.email.value;
  $flag = true;
  atpos = email.indexOf("@");
  dotpos = email.lastIndexOf(".");
  if(email == "")
  {
      document.getElementById('emailErr').innerHTML = "Email should not be empty"; 
    	$flag=false;
  }
  else if (atpos < 1 || ( dotpos - atpos < 2 ))
  {
    document.getElementById('emailErr').innerHTML = "your emailid should contain be in correct format (eg:sree@cred.com) "; 
    $flag=false;
  }
  else
  {
    document.getElementById('emailErr').innerHTML = "";
  }
  return $flag;
}



/*
@desc to check token and password validation
*/

function validation()
{
  var token = document.resetform.token.value;
  var password = document.resetform.password.value;
  var confirmPassword = document.resetform.confirmpassword.value;
  regular = /^(?=.*\d)(?=.*[a-zA-Z]).{6,10}$/;
  
  $flag = true;
  if (token==null || token=="")
  {
    document.getElementById('tknErr').innerHTML="token cannot be empty";
    $flag=false;
  }
  else
  {
    document.getElementById('tknErr').innerHTML=null;
  }

  if (password==null || password=="")
  {
    document.getElementById('pwdErr').innerHTML="password cannot be empty";
    $flag=false;
  }
  else if(!regular.test(password))
  {
    document.getElementById('pwdErr').innerHTML="password should contain atleast 1 number,1 alphabet and 6 characters";
    $flag=false;
  }
  else
  {
    document.getElementById('pwdErr').innerHTML=null;
  }

  if (confirmPassword==null || confirmPassword=="")
  {
    document.getElementById('cpwdErr').innerHTML="ConfirmPassword cannot be empty";
    $flag=false;
  }
   else if(!regular.test(confirmPassword))
  {
    document.getElementById('cpwdErr').innerHTML="confirmPassword should contain atleast 1 number,1 alphabet and 6 characters";
    $flag=false;
  }
  else
  {
    document.getElementById('cpwdErr').innerHTML=null;
  }

  return $flag;
}