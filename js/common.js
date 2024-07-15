function transact(form){
    var id = form.id.value;
    var amt = form.amt.value;
    postData = "confirmCartPayment=true&cid="+id;
    ajax("backend/Customer.php",postData,"post","backend/Handler.php","","get","");
    disappear("cart-"+id);
    reloadCounts();
    closeModal();
    return false;
}

function submitRating(stars){
    var id = document.getElementById('rate-id').value;
    var type = document.getElementById('rate-type').value;
    var comment = document.getElementById('rate-comment').value;

    var action = "";
    if(type == "cart"){
        action = "rateCartItem";
    }else if(type == "apt"){
        action = "rateAptItem";
    }else if(type == "store"){
        action = "rateStore";
    }else if(type == "item"){
        action = "rateItem";
    }
    postData = action+"=true&id="+id+"&stars="+stars+"&comment="+comment;
    ajax("backend/Customer.php",postData,"post","backend/Handler.php","","get","").then((response) =>{
        alert(response);
    });
    reload = true;
    if(type == "cart"){
        disappear("cart-"+id);
        reloadCounts();
    }else if(type == "apt"){
        disappear("apt-"+id);
        reloadAptCounts();
    }else if(type == "store"){
        refreshStoreComments(id);
    }else if(type == "item"){
        refreshItemComments(id);
    }
    closeModal();
    return false;
    
}
var canGo = true;
function goTo(page){
    if(canGo)
        window.open(page,'_self');
    canGo = true;
}

function formatDate(date){
    var d = new Date(date);
    return d.toDateString();
}

function formatTime(time){
    var suffix = "am";
    if(time == 1200){
        suffix = "noon";
    }else if(time > 1200){
        suffix = "pm";
        if(time > 1259){
            time-=1200;
        }
    }
    var str = ""+time;
    if(str.length < 4)
        str= " "+str;
    var ret = str.substr(0,2)+":"+str.substr(2)+" "+suffix;
    return ret;
}

function process(response){
    var free = response.free;
    var available = document.getElementById('available');
    available.innerHTML = "";
    document.getElementById('sub-title').innerHTML = "<h5>Available Slots</h5>";
    for(var i = 0; i < free.length; i++){
        var slot = free[i];
        freeSlots.push(slot);
        var str = "<tr><td>"+formatDate(slot.date)+"</td><td>"+formatTime(slot.from)+"</td><td>-  </dt><td>"+formatTime(slot.to)+"</td><td class='right-align'><button onclick='selected("+i+")' class='btn-small green'>Book</button></td></tr>";
        available.innerHTML+=str;
    }
}
var left = false;
var check = false;
function disappear(id){
    
    if(check){
        var width = $(document).width();
        if(width > 600){
            left = true;
        }
        check = false;
    }
    
    if(left){
        $("#"+id).animate({width: "toggle"}, 350);
        left = false;
    }else{
        $("#"+id).slideUp();   
    }
}

function copyLink(){
    var loc = window.location.href;
    var elem = document.getElementById('link-address');
    elem.value = loc;
    elem.select();
    elem.setSelectionRange(0,99999);
    document.execCommand("copy");
    var tooltip = document.getElementById('copy-tooltip');
    if(!tooltip.classList.contains("tooltip-show")){
        tooltip.classList.add("tooltip-show")
    }
    setInterval(function(){
        tooltip.classList.remove("tooltip-show");
    }, 3000);
}

function follow(uid, sid, elm){
    canGo = false;
    ajax("backend/Customer.php","follow=true&uid="+uid+"&sid="+sid, "post", "","","get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        if(jsonResponse.okay){
            get("backend/Handler.php","getFollowing=true&uid="+uid+"&sid="+sid,"get","").then((response) =>{
                elm.parentElement.innerHTML = response;
            })
        }else{
            errorAlert(jsonResponse.message);
        }
    });
}

function unfollow(uid, sid, elm){
    canGo = false;
    ajax("backend/Customer.php","unfollow=true&uid="+uid+"&sid="+sid, "post", "","","get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        if(jsonResponse.okay){
            get("backend/Handler.php","getFollowing=true&uid="+uid+"&sid="+sid,"get","").then((response) =>{
                elm.parentElement.innerHTML = response;
            })
        }else{
            errorAlert(jsonResponse.message);
        }
    });
}