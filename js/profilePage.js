var change_fname = document.getElementById('changeFname');

var change_lname = document.getElementById('changeLname');

var change_email = document.getElementById('changeEmail');

var change_phone = document.getElementById('changePhone');

var change_idnum = document.getElementById('changeIdnum');

var change_pass = document.getElementById('changePass');

function cancel_profile_change(){
    var classes = document.getElementsByClassName('profile_change');
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "none";
    }
    
    event.preventDefault();
}

change_fname.onclick = function(){
    cancel_profile_change();
    document.getElementById('divFname').style.display = "block";
}

change_lname.onclick = function(){
    cancel_profile_change();
    document.getElementById('divLname').style.display = "block";
}

change_email.onclick = function(){
    cancel_profile_change();
    document.getElementById('divEmail').style.display = "block";
}

change_phone.onclick = function(){
    cancel_profile_change();
    document.getElementById('divPhone').style.display = "block";
}

change_idnum.onclick = function(){
    cancel_profile_change();
    document.getElementById('divIdnum').style.display = "block";
}

change_pass.onclick = function(){
    cancel_profile_change();
    document.getElementById('divPassword').style.display = "block";
}