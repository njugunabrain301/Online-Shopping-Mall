
function deleteProduct(id){
    canGo = false;
    
    postData = "deleteProduct=true&id="+id;
    getData = "getCart=true";
    ajaxId = "cart_ajax";
    reload = true;

    ajax("backend/Tenant.php",postData,"post","","","get","").then((response)=>{
        var jsonResponse = JSON.parse(response);
        if(jsonResponse.okay){
            left = true;
            disappear("product-"+id);   
        }else{
            errorAlert("You still have pending orders on this product");
        }
    });
    
    return false;
}