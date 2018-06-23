//validate function for admin login
function validate()
{
  var userName = document.login.username.value;
  var password = document.login.password.value;
  $flag = true;
  if (userName==null || userName=="")
  {
    document.getElementById('userErr').innerHTML="Username cannot be empty";
    $flag=false;
  }
  else
  {
    document.getElementById('userErr').innerHTML=null;
  }
  if (password==null || password=="")
  {
    document.getElementById('pwdErr').innerHTML="Password cannot be empty";
    $flag=false;
  }
  else
  {
    document.getElementById('pwdErr').innerHTML=null;
  }
return $flag;
}