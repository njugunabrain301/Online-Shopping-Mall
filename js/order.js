var iid = "";
var freeSlots = [];
var loc = "";
var timesChecked = 0;
var loginChecker;
var selectedColor = "";
var selectedSize = "";


function checkLoggedIn(){
    var loggedIn = document.getElementById('loggedIn').innerHTML;
    if(loggedIn != "true"){
        closeModal();
        document.getElementById('logInModal').click();
        return false;
    }
    return true;
}

function confirmLoggedIn(){
    var loggedIn = document.getElementById('loggedIn').innerHTML;
    timesChecked++;
    if(loggedIn != "true"){
        document.getElementById("login-message").innerHTML = loggedIn;
    }else{
        clearInterval(loginChecker);
        closeModal();
        timesChecked = 0;
        document.getElementById('order-btn').click();
    }
    if(timesChecked > 10){
        clearInterval(loginChecker);
        timesChecked = 0;
    }
}

function order(form){
    if(!checkLoggedIn()) return false;
    iid = form.id.value;
    var type = document.getElementById('item-type').value;
    var postData = "";
    var getData = "";
    var ajaxId = "";
    
    var number = document.getElementById('item-qty').value;
    var locId = form.pickup.value
    
    if(locId == "Select Pick Up Location"){
        var elm = document.getElementById('order-error');
        elm.innerHTML = "Select a pick up location"
        return false;
    }
    
    postData = "addItemToCart=true&iid="+iid+"&type="+type+"&qty="+number+"&pickup="+locId+"&color="+selectedColor+"&size="+selectedSize;
    getData = "getCartNum=true";
    ajaxId = "cart_count";

    ajax("backend/Customer.php",postData,"post","backend/Handler.php",getData,"get","").then((response)=>{
        var jsonResponse = JSON.parse(response);
        document.getElementById(ajaxId).innerHTML = jsonResponse.incomplete;
    });
    closeModal();
    return false;
}

function book(form){
    if(!checkLoggedIn()) return false;
    var date = form.date.value;
    var time = form.time.value;
    iid = form.id.value;
    loc = form.location.value;
    
    if(loc == "Select Pick Up Location"){
        var elm = document.getElementById('apt-error');
        elm.innerHTML = "Select a pick up location"
        return false;
    }
    time = time.replace(':','');
    document.getElementById("available").innerHTML = "Loading...";
    var checkAvailability = new XMLHttpRequest();
    
    checkAvailability.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            var response = JSON.parse(this.responseText);
            if(response.result == "Okay"){
                var postData = "";
                var getData = "";
                var ajaxId = "";
                
                postData = "addBookingToCart=true&iid="+iid+"&date="+date+"&time="+time+"&loc="+loc;
                getData = "getAptNum=true";
                ajaxId = "apt_count";
                ajax("backend/Customer.php",postData,"post","backend/Handler.php",getData,"get","").then((response) =>{
                    var res = JSON.parse(response);
                    document.getElementById(ajaxId).innerHTML = res.UPCOMING;
                });
                closeModal();
            }else{
                process(response);
            }
        }
    }
    
    var hours = "&opening="+hs+"&closing="+he+"&lunchStart="+ls+"&lunchEnd="+le+"&duration="+d;
    var url = "backend/Handler.php?checkAvailability=true&iid="+iid+"&date="+date+"&time="+time+hours;
    checkAvailability.open("GET",url, true);
    
    checkAvailability.send();
    
    return false;
}

function selected(id){
    selectedSlot = freeSlots[id];
    
    var postData = "";
    var getData = "";
    var ajaxId = "";
    
    postData = "addBookingToCart=true&iid="+iid+"&date="+(selectedSlot.date)+"&time="+selectedSlot.from+"&loc="+loc;
    getData = "getAptNum=true";
    ajaxId = "apt_count";
   
    ajax("backend/Customer.php",postData,"post","backend/Handler.php",getData,"get","").then((response) =>{
        var res = JSON.parse(response);
        document.getElementById(ajaxId).innerHTML = res.UPCOMING;
    });
    document.getElementById('available').innerHTML = "";
    document.getElementById('sub-title').innerHTML = "";
    closeModal();
}

function selectColor(c, elm){
    if(!selectable){
        return;
    }
    selectedColor = c;  
    var colors = document.getElementsByClassName('colors-available');
    for(var i = 0; i < colors.length; i++){
        if(colors[i].classList.contains("selectedSpec")){
            colors[i].classList.remove("selectedSpec");
        }
    }
    elm.classList.add("selectedSpec");
}

function selectSize(s, elm){
    if(!selectable){
        return;
    }
    selectedSize = s;  
    var colors = document.getElementsByClassName('sizes-available');
    for(var i = 0; i < colors.length; i++){
        if(colors[i].classList.contains("selectedSpec")){
            colors[i].classList.remove("selectedSpec");
        }
    }
    elm.classList.add("selectedSpec");  
}

function refreshItemComments(id){
    get("backend/Handler.php","getItemRating=set&id="+id,"get","item-rating").then((response) =>{
       get("backend/Handler.php","getItemComments=set&id="+id,"get","item-comments"); 
    });
}

function rate(id){
    document.getElementById('rate-id').value = id;
    document.getElementById('rate-type').value = 'item';
}

 