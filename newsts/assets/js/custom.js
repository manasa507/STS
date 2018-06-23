"use strict";

var data = [{

  "compName": "Credencys",
  "empName": "ram",
  "empEmail": "ram@credencys.com",
  "experience":"6months",
  "salary": 12000,
  "skills": "angular, node",
}, {
  "compName": "Credencys",
  "empName": "ramesh",
  "empEmail": "ramesh@credencys.com",
  "experience":"4yrs",
  "salary": 52000,
  "skills": "angular, node",
} ];

function tabledisplay(){ 

  var table = document.getElementById("jstable"); //give this ID to your table
  for (var i = 0; i < data.length; i++) {
  var row = table.insertRow(i);
  print_data(data[i],0);
  }
}//function end


function getsalary(){
  var totSal = 0;
  for(var i = 0; i < data.length; i++){
  totSal = data[i].salary + totSal ;
  }
  document.getElementById('totalsalary').innerHTML = "Total Salary is " + totSal;
}

function filterSalaryAbove50k(){
  var table = document.getElementById("jstable");
  document.getElementById('jstable').innerText ="";  
  for(var i = 0; i < data.length; i++)
  {
  var row = table.insertRow(i);
  if(data[i].salary >= 50000){
  
  row.style.color="red";
  print_data(data[i],1);
  
  }
  else{
  print_data(data[i],0);
  }
  
  }// for end
}//radio function
function filterSalarybelow50k(){
  document.getElementById('jstable').innerHTML ="";  
  var table = document.getElementById("jstable");

  for(var i = 0; i < data.length; i++)
  {
  var row = table.insertRow(i);
  if(data[i].salary < 50000){  
  print_data(data[i],1); 
  }
  else{
  print_data(data[i],0);
  }
  
  }// for end

}//radio function
function print_data(element,e){
  document.getElementById('totalsalary').innerHTML = "";
  var table = document.getElementById("jstable"); 
  var row = table.insertRow();
  if(e == 1){
  row.style.backgroundColor="grey";
  }
  cells(element.compName);
  cells(element.empName);
  cells(element.empEmail);
  cells(element.experience);
  cells(element.salary);
  cells(element.skills);
  function cells(names){
  var cell = row.insertCell();
 cell.innerHTML = names;
  }

}













