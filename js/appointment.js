var iid = "";
var freeSlots = [];
var aptId = "";

var tenant = false;
var reload = false;

var hs;
var he;
var ls;
var le;
var d;
function rate(id){
    document.getElementById('rate-id').value = id;
    document.getElementById('rate-type').value = 'apt';
}

function reschedule_apt(aptId, iid, hsi, hei, lsi, lei, di){
    document.getElementById('aptId-second').value = aptId;
    document.getElementById('apt-iid').value = iid;
    hs = hsi;
    he = hei;
    ls = lsi;
    le = lei;
    d = di;
}

function reschedule(form){
    var date = form.date.value;
    var time = form.time.value;
    var id = form.aptId.value;
    iid = form.iid.value;
    aptId = form.aptId.value;
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
                
                postData = "rescheduleBooking=true&aptId="+id+"&date="+date+"&time="+time+"&iid="+iid;
                getData = "";
                ajaxId = "";
                ajax("backend/Customer.php",postData,"post","backend/Handler.php",getData,"get",ajaxId);
                reloadApts(); 
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

function remove_apt_item(id){
    postData = "removeFromApt=true&aid="+id;
    getData = "getAppointments=true";
    ajaxId = "apt_ajax";

    ajax("backend/Customer.php",postData,"post","backend/Handler.php","","get","").then((response)=>{
        disappear('apt-'+id);
        reloadAptCounts();
    });
}

function reloadApts(){
    getData = "getAppointments=true";
    if(tenant){
        getData = "getStoreAppointments=true";
    }
    get("backend/Handler.php",getData,"get","").then((response)=>{
        var jsonResponse = JSON.parse(response);
        reloadAptData(jsonResponse);
    });
}

function reloadAptData(json){
    var ups = document.getElementsByClassName("up-text");
    for(var i = 0; i < ups.length; i++){
        ups[i].innerHTML = json.UPCOMING;
    }
   
    var pas = document.getElementsByClassName("pa-text");
    for(var i = 0; i < pas.length; i++){
        pas[i].innerHTML = json.PAST;
    }
    
    var cas = document.getElementsByClassName("ca-text");
    for(var i = 0; i < cas.length; i++){
        cas[i].innerHTML = json.CANCELLED;
    }
}

function reloadAptCounts(){
    getData = "getAptNum=true";
    if(tenant){
        getData = "getStoreAptCount=true";
    }
    ajaxId = "apt_count";
    get("backend/Handler.php",getData,"get","").then((response) => {
        jsonResponse = JSON.parse(response);
        document.getElementById(ajaxId).innerHTML = jsonResponse.UPCOMING;
        reloadAptCountsData(jsonResponse);
    });
}

function reloadAptCountsData(json){
    var ups = document.getElementsByClassName("up");
    for(var i = 0; i < ups.length; i++){
        ups[i].innerHTML = "("+json.UPCOMING+")";
    }
   
    var pas = document.getElementsByClassName("pa");
    for(var i = 0; i < pas.length; i++){
        pas[i].innerHTML = "("+json.PAST+")";
    }
    
    var cas = document.getElementsByClassName("ca");
    for(var i = 0; i < cas.length; i++){
        cas[i].innerHTML = "("+json.CANCELLED+")";
    }
}

function selected(id){
    selectedSlot = freeSlots[id];
    
    var postData = "";
    var getData = "";
    var ajaxId = "";
        
    postData = "rescheduleBooking=true&iid="+iid+"&date="+(selectedSlot.date)+"&time="+selectedSlot.from+"&aptId="+aptId;
   
    ajax("backend/Customer.php",postData,"post","backend/Handler.php","","get","");
    document.getElementById('available').innerHTML = "";
    document.getElementById('sub-title').innerHTML = "";
    reloadApts(); 
    closeModal();
}

function cancel_apt(aptId){
    
    document.getElementById('reason-id').value = aptId;
    document.getElementById('reason-title').innerHTML = "Cancel Appointment";
    return false;
}

function cancel_with_reason(form){
    var reason = form.reason.value;
    var id = form.id.value;
    postData = "cancelApt=true&aid="+id+"&reason="+reason;
        
    reload = true;
    ajax("backend/Tenant.php",postData,"post","backend/Handler.php","","get","").then((response)=>{
        disappear("apt-"+id);
        reloadAptCounts();
    });
    closeModal();
    return false;
}

function checkReload(){
    if(reload){
        reload = false;
        reloadApts();
    }
}

function fetchSimpleApt(){
    $(".complex").css("display","none");
    $(".simple").css("display","block");
}

function fetchDetailedApt(){
    $(".complex").css("display","block");
    $(".simple").css("display","none");
    
    getData = "getDetailedStoreApts=true";
    
    get("backend/Handler.php",getData,"get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        document.getElementById("apt-data").innerHTML = jsonResponse.DATA;
        $('#apt-data-table').DataTable();
    });
}