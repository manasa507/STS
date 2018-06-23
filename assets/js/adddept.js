
//add departments into Departments table
$(document).ready(function() {
$("#add").click(function() {
var name = $("#name").val();
if (name == '') {
alert("Please Enters Department Name...!!!!!!");
} else if ((name.length) < 1) {
alert("Department should atleast 2 character in length...!!!!!!");
}  else {
$.post("adddept.php", {
name1: name,
},function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
document.location.href = "deptinfo.php";
});
}
});
});
