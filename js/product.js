function addToView(){
    var loggedIn = document.getElementById('loggedIn').innerHTML;
    if(loggedIn != "true"){
        return;
    }
    var xml = new XMLHttpRequest();
    xml.onload = function(){
    };
    xml.open("POST","backend/user.php", true);
    xml.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xml.send("addView=true&pid="+pid);

}

addToView();