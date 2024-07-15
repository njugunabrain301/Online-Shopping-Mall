async function approveStore(id, from){
    var postData = "approveStore=true&id="+id;
    var getData = "getStores=true&id="+from;
    await ajax("backend/adminHandle.php",postData,"post","backend/adminGet.php",getData,"get","ajax_stores");
}

async function declineStore(id){
    var postData = "declineStore=true&id="+id;
    var getData = "getStores=true&pending_div";
    await ajax("backend/adminHandle.php",postData,"post","backend/adminGet.php",getData,"get","ajax_stores");
}

async function suspendStore(id){
    var postData = "suspendStore=true&id="+id;
    var getData = "getStores=true&id=live_div";
    await ajax("backend/adminHandle.php",postData,"post","backend/adminGet.php",getData,"get","ajax_stores");
}

function storePaid(id){
    var postData = "storePaid=true&id="+id;
    var getData = "getStores=true";
    ajax("backend/adminHandle.php",postData,"post","backend/adminGet.php",getData,"get","ajax_stores");
}

function setActive(id){
    var all = document.getElementsByClassName('sub_nav');
    for(var i = 0; i < all.length; i++){
        if(all[i].classList.contains("active")){
            all[i].classList.remove("active");
        }
    }
    document.getElementById('pending_link').click();   
}

function fetchStoresData(){
    
    $('#stores-data-table').DataTable({
        "ajax" : "backend/adminGet.php?getStoresAll=true",
        "deferRender" : true
    });
    
}

function fetchIncomeData(){
    
    $('#income-data-table').DataTable({
        "ajax" : "backend/adminGet.php?getIncomeData=true",
        "deferRender" : true
    });    
}
