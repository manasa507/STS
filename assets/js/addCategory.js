//add categories into categories table
$(document).ready(function() {
$("#add").click(function() {
var dept = $("#dept").val();
var name = $("#name").val();
if (name == '' || dept == ''){
alert("Please Enters Category Name....!!!!!!");
} else if ((name.length) < 1) {
alert("Category should atleast 2 character in length...!!!!!!");
}  else {
$.post("addcategory.php", {
dept1: dept,
name1: name
},function(data) {
alert(data);
$('#form')[0].reset(); // To reset form fields
document.location.href = "categories.php";
});
}
});
});