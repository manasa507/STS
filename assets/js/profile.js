    //readURL function for readonly image files....
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.imgCircle')
                .attr('src', e.target.result)
                .width(200)
                .height(200);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }       
    var checkme = document.getElementById('checker');
    var userImage = document.getElementById('image-input');
    var userName = document.getElementById('name');
    var userMobile = document.getElementById('mobile');
    var userPassword = document.getElementById('password');
    var UserSend = document.getElementById('submit');
    var editPic = document.getElementById('PicUpload');
    checkme.onchange = function() {
        UserSend.disabled = !this.checked;
        userImage.disabled = !this.checked;
        userMobile.disabled = !this.checked;
        userPassword.disabled = !this.checked;
        userPlace.disabled = !this.checked;
        editPic.style.display = this.checked ? 'block' : 'none';
    };
    //show function for visible the password section 
    function show(id){
        if(document.getElementById(id).style.display=="none"){
            document.getElementById(id).style.display="block";
        }
        else{
            document.getElementById(id).style.display="none";
        }
    }
    //clearFields function for when onclick in textbox then clear field values...
    function clearFields(id) {
        document.getElementById(id).value="";
        document.getElementById(id).value="";
        document.getElementById(id).value="";
    }

 
  