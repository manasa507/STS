//Add tickets into ticket table...
$(document).ready(function() {
$("#add").click(function() {
var subject = $("#subject").val();
var dept = $("#dept").val();
var category = $("#category").val();
var description = $("#description").val();
if (subject == '' || description =='' || dept == '' || category == '') {
alert("Please fill all fields...!!!!!!");
} else if ((subject.length) < 5) {
alert("Department should atleast 2 character in length...!!!!!!");
}  else {
$.post("addticket.php", {
dept1: dept,
category1: category,
subject1: subject,
description1:description
}, function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
document.location.href = "tickets.php";
});
}
});
});