function fetchInvoiceData(){
    
    getData = "getInvoices=true";
    
    get("backend/Handler.php",getData,"get","").then((response) =>{
        alert(response);
        var jsonResponse = JSON.parse(response);
        document.getElementById("inv-data").innerHTML = jsonResponse.DATA;
        $('#inv-data-table').DataTable();
    });
}

function deleteInvoice(invId){
    
    postData = "deleteInvoice=true&id="+invId;
    
    ajax("backend/Tenant.php",postData,"post","","","","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        if(jsonResponse.okay){
            disappear("inv-"+id);   
            get("backend/Handler.php","getStoreInvoiceCount=set","get","").then((response) =>{
                jsonResponse = JSON.parse(response);
                document.getElementById('invoice-ct').innerHTML = jsonResponse.count;
            });
        }else{
            errorAlert(jsonResponse.message);
        }
    });
}

function payInvoice(invId, amt){
    alert("here");
    getData = "isLoggedIn=true";
    
    get("backend/Utility.php",getData,"get","").then((response) =>{
        alert(response);
        var jsonResponse = JSON.parse(response);
        if(jsonResponse.okay){
            document.getElementById("payment-id").value = invId;
            document.getElementById("payment-amt").value = amt;
            document.getElementById("payment-email").value = jsonResponse.email;
            document.getElementById("payment-phone").value = jsonResponse.phone;
        }else{
            errorAlert("Your session has expired. Please log in again");
            closeModal();
        }
    });
}