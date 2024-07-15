var tenant = false;
var reload = false;

function rate(id){    
    document.getElementById('rate-id').value = id;
    document.getElementById('rate-type').value = 'cart';
}

function setPaymentDetails(cartId, amt){
    document.getElementById('payment-id').value = cartId;
    document.getElementById('payment-amt').value = amt;
    document.getElementById('payment-amt-in-text').innerHTML = amt;
}

async function remove_cart_item(id){
    postData = "removeFromCart=true&cid="+id;
    getData = "getCart=true";
    ajaxId = "cart_ajax";
    reload = true;
    var ret = await confirm_delete("Order");
    
    ajax("backend/Customer.php",postData,"post","","","get","").then((reponse)=>{
        disappear("cart-"+id);
        reloadCounts();
    });
}

function reloadCountData(json){
    var pes = document.getElementsByClassName("pe");
    for(var i = 0; i < pes.length; i++){
        pes[i].innerHTML = "("+json.PENDING+")";
    }
   
    var des = document.getElementsByClassName("de");
    for(var i = 0; i < des.length; i++){
        des[i].innerHTML = "("+json.DELIVERY+")";
    }
    
    var pis = document.getElementsByClassName("pi");
    for(var i = 0; i < pis.length; i++){
        pis[i].innerHTML = "("+json.PICKUP+")";
    }
    
    var cos = document.getElementsByClassName("co");
    for(var i = 0; i < cos.length; i++){
        cos[i].innerHTML = "("+json.COMPLETE+")";
    }
    
    var cas = document.getElementsByClassName("ca");
    for(var i = 0; i < cas.length; i++){
        cas[i].innerHTML = "("+json.CANCELLED+")";
    }
}

function reloadCart(){
    getData = "getCart=true";
    if(tenant){
        getData = "getStoreOrders=true";
    }
    
    get("backend/Handler.php",getData,"get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        reloadCartData(jsonResponse);
    });
}

function reloadCounts(){
    getData = "getCartNum=true";
    ajaxId = "cart_count";
    if(tenant){
        getData = "getStoreOrderCount=true";
    }
    get("backend/Handler.php",getData,"get","").then((response) =>{
        jsonResponse = JSON.parse(response);
        document.getElementById("cart_count").innerHTML = jsonResponse.incomplete;
        reloadCountData(jsonResponse);
    });
}

function reloadCartData(json){
    var pes = document.getElementsByClassName("pe-text");
    for(var i = 0; i < pes.length; i++){
        pes[i].innerHTML = json.PENDING;
    }
   
    var des = document.getElementsByClassName("de-text");
    for(var i = 0; i < des.length; i++){
        des[i].innerHTML = json.DELIVERY;
    }
    
    var pis = document.getElementsByClassName("pi-text");
    for(var i = 0; i < pis.length; i++){
        pis[i].innerHTML = json.PICKUP;
    }
    
    var cos = document.getElementsByClassName("co-text");
    for(var i = 0; i < cos.length; i++){
        cos[i].innerHTML = json.COMPLETE;
    }
    
    var cas = document.getElementsByClassName("ca-text");
    for(var i = 0; i < cas.length; i++){
        cas[i].innerHTML = json.CANCELLED;
    }
}

function cancel_order(cid){
    
    document.getElementById('reason-id').value = cid;
    document.getElementById('reason-title').innerHTML = "Cancel Order";
    return false;
}

function cancel_with_reason(form){
    var reason = form.reason.value;
    var id = form.id.value;
    postData = "cancelCartItem=true&cid="+id+"&reason="+reason;
    reload = true;
    ajax("backend/Tenant.php",postData,"post","backend/Handler.php","","get",ajaxId).then((response)=>{
        disappear("cart-"+id);
        reloadCounts();
    });
    closeModal();
    return false;
}

function checkReload(){
    if(reload){
        reload = false;
        reloadCart();
    }
}

function fetchSimpleOrders(){
    $(".complex").css("display","none");
    $(".simple").css("display","block");
}

function fetchDetailedOrders(){
    $(".complex").css("display","block");
    $(".simple").css("display","none");
    
    getData = "getDetailedStoreOrders=true";
    
    get("backend/Handler.php",getData,"get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        document.getElementById("order-data").innerHTML = jsonResponse.DATA;
        $('#order-data-table').DataTable();
    });
}