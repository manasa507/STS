// Addusers into users table....
$(document).ready(function() {
$("#register").click(function() {
var name = $("#userName").val();
var email = $("#emailId").val();
var mobile = $("#mobileNumber").val();
var password = $("#password").val();
var cpassword = $("#confirmPassword").val();
var gender = $("input[name='gender']:checked").val();
// var gender = $("#gen").val();
var dept = $("#dept").val();
var role = $("#role").val();
if (name == '' || email == '' || mobile == '' || password == '' || cpassword == '' || gender == '' || dept == '' ||  role == '') {
alert("Please fill all fields...!!!!!!");
}else if ((password.length) < 6) {
alert("Password should atleast 6 character in length...!!!!!!");
} else if (!(password).match(cpassword)) {
alert("Your passwords don't match. Try again?");
} else {
$.post("adduser.php", {
name1: name,
email1: email,
mobile1: mobile,
password1: password,
gender1: gender,
dept1: dept,
role1: role
},function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
document.location.href = "users.php";
});
}
});
});
