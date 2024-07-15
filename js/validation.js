function validate_login(form){
    
    return true;
}

function validate_login(form, modal){
    var email = form.email.value;
    var pass = form.password.value;
    //var type = form.type.value;
    
    var getData = "setIsLoggedIn=set";
    var postData = "login=set&email="+email+"&password="+pass+"&type=customer&modal=set";
    ajax("backend/User.php",postData,"post","backend/Handler.php",getData,"get","loggedIn").then((response)=>{
        confirmLoggedIn();
    });
    
    return false;
}

function validate_register(form){
    
    var err = document.getElementById('error');
    var suc = document.getElementById('success');
    var ret = true;
    var mailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var idReg = /^\d+$/;
    var phoneReg = /^0(6|7)[0-9]{8}$/;
    
    if(form.fname.value.length < 3){
        err.innerHTML = "* Enter a valid first name";
        form.fname.focus();
        ret = false;
    }else if(form.lname.value.length < 3){
        err.innerHTML = "* Enter a valid last name";
        form.lname.focus();
        ret = false;
    }else if(form.idnum.value.length < 7 || !form.idnum.value.match(idReg)){
        err.innerHTML = "* Enter a valid Id Number";
        form.idnum.focus();
        ret = false;
    }else if(form.phone.value.length != 10 || !form.phone.value.match(phoneReg)){
        err.innerHTML = "* Enter a valid Phone Number";
        form.phone.focus();
        ret = false;  
    }else if(form.email.value.length < 3 || !form.email.value.match(mailReg)){
    
        err.innerHTML = "* Enter a valid email address!";
        form.email.focus();
        ret = false;
        
    }else if(form.password.value.length < 6){
        err.innerHTML = "* Password is too short";
        form.password.focus();
        ret = false;     
    }else if(form.password.value != form.cpassword.value){
        err.innerHTML = "* Passwords do not match";
        form.password.focus();
        ret = false;
    }
    
    setIntervals();
    
    return ret;
}

function validate_add_product(form){
    
    return true;
}

function validate_add_service(form){
    
    return true;
}

function validate_physical_address(form){
    var ret = true;
    var err = document.getElementById('error');
    var suc = document.getElementById('success');
    var phoneReg = /^0(6|7)[0-9]{8}$/;
    var mailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    
    if(form.street.value.length < 3){
        err.innerHTML = "* Enter a valid Street Name";
        ret = false;
    }else if(form.building.value.length < 3){
        err.innerHTML = "* Enter a valid Building Name";
        ret = false;
    }else if(form.name.value == ""){
        err.innerHTML = "* Enter a valid Store Name";
        ret = false;
    }else if(form.stall.value == ""){
        err.innerHTML = "* Enter a valid stall Number";
        ret = false;
    }else if(form.email.value.length < 5 || !form.email.value.match(mailReg)){
        err.innerHTML = "* Enter a valid email";
        ret = false;
    }else if(form.phone.value.length != 10 || !form.phone.value.match(phoneReg)){
        err.innerHTML = "* Enter a valid Phone Number";
        ret = false;
    }else if(form.description.value == ""){
        err.innerHTML = "* Provide a description of your store";
        ret = false;
    }else{
        var img = form.image;
        if(img.files.length == 0){
            err.innerHTML = "* Select an image";
            ret = false;
        }else{
           for(var i = 0; i < img.files.length; i++){

                var img = form.image;
                for(var i = 0; i < img.files.length; i++){
                    var ext = img.files.item(i).name.split(".").pop();
                    var exts = ["jpg","jpeg","png","gif","ico"];
                    if(!exts.includes(ext)){
                        err.innerHTML = "* Select a valid image file";
                        ret = false;
                        break;
                    }else if(img.files.item(i).size > (1024 * 1024 * 5)){
                        err.innerHTML = "* File should be less than 5MB";
                        ret = false;
                        break;
                    }   
                }  
            } 
        }
            
    }
    
    
    return ret;
}

function validate_profile_change(form, type){
    var ret = true;
    var val = form.new.value;
    var err = document.getElementsByClassName(type)[0];
    var data = "";
    if(type == "fname" || type == "lname"){
        if(val.length < 3){
            ret = false;
            err.innerHTML = "* Enter a valid value";
        }else{
            if(type == "fname"){
                data="changeFname=set";
            }else{
                data="changeLname=set";
            }
        }
    }else if(type == "email"){
        var mailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(!val.match(mailReg)){
            ret = false;
            err.innerHTML = "* Enter a valid email";
        }else{
            data = "changeEmail=set";
        }
    }else if(type == "phone"){
        var phoneReg = /^0(6|7)[0-9]{8}$/;
        if(!val.match(phoneReg)){
            ret = false;
            err.innerHTML = "* Enter a valid phone number";
        }else{
            data = "changePhone=set";
        }
    }else if(type == "password"){
        var cval = form.cnew.value;
        if(cval != val){
            ret = false;
            err.innerHTML = "* Passwords do not match";
        }else{
            data = "changePass=set";
        }
    }else if(type == "changeImage"){

        var img = form.new;
        if(img.files.length == 0){
            err.innerHTML = "* Select an image";
            ret = false;
        }else{
           for(var i = 0; i < img.files.length; i++){

                var img = form.image;
                for(var i = 0; i < img.files.length; i++){
                    var ext = img.files.item(i).name.split(".").pop();
                    var exts = ["jpg","jpeg","png","gif","ico"];
                    if(!exts.includes(ext)){
                        err.innerHTML = "* Select a valid image file";
                        ret = false;
                        break;
                    }else if(img.files.item(i).size > (1024 * 1024 * 5)){
                        err.innerHTML = "* File should be less than 5MB";
                        ret = false;
                        break;
                    }   
                }  
            } 
        }  
        setIntervals();
        return ret;
    }
    if(ret){        
        closeModal();
        ajax("backend/User.php","manageProfile=set&"+data+"&new="+val,"post","backend/Handler.php","profile=true","get","ajax");
    }
    
    setIntervals();
    
    return false;
}

function validate_store_change(form, type){
    var ret = true;
    var val = form.new.value;
    var err = document.getElementsByClassName(type)[0];
    var id = document.getElementById('store_id').value;
    var getData = "id="+id;
    var data = type+"=set&"+getData;
    var mailReg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var phoneReg = /^0(6|7)[0-9]{8}$/;
    if(type == "changeImage"){

        var img = form.new;
        if(img.files.length == 0){
            err.innerHTML = "* Select an image";
            ret = false;
        }else{
           for(var i = 0; i < img.files.length; i++){

                var img = form.image;
                for(var i = 0; i < img.files.length; i++){
                    var ext = img.files.item(i).name.split(".").pop();
                    var exts = ["jpg","jpeg","png","gif","ico"];
                    if(!exts.includes(ext)){
                        err.innerHTML = "* Select a valid image file";
                        ret = false;
                        break;
                    }else if(img.files.item(i).size > (1024 * 1024 * 5)){
                        err.innerHTML = "* File should be less than 5MB";
                        ret = false;
                        break;
                    }   
                }  
            } 
        }  
        setIntervals();
        return ret;
    }else if(type == "changeSemail" && (val.length < 3 || !val.match(mailReg))){
        err.innerHTML = "* Enter a valid email";
        ret = false;
    }else if(type == "changeSphone" && (val.length != 10 || !val.match(phoneReg))){
        err.innerHTML = "* Enter a valid phone number";
        ret = false;
    }else if(val.length < 3){
        err.innerHTML = "* Enter a valid value";
        ret = false;
    }
    if(ret){        
       closeModal();
       ajax("backend/Tenant.php","manageStore=set&"+data+"&new="+val,"post","backend/Handler.php","store=true&"+getData,"get","ajax_store").then((response) =>{
           var jsonResponse = JSON.parse(response);
           if(jsonResponse.type){
                $("#package_change_modal").modal();
                $("#package_change_modal").modal('open');
           }
       });
    }
    
    setIntervals();
    
    return false;
}

function setIntervals(){
    
    setTimeout(function(classes){
         var classes = document.getElementsByClassName('message');
        for(var i = 0; i < classes.length; i++){
            classes[i].innerHTML= "";
        }
    },30000);
    
}

async function confirm_delete(src){
    var str = "Are you sure you want to delete the "+src;
    var ret = false;
    await swal({
        text : str,
        icon : "warning",
        buttons: true
    }).then((value) =>{
        if(value == true){
            ret = true;
        }
    });
    return ret;
}

function messageAlert(mess){
    swal({
        text : mess,
        icon : "info"
    });
}

function errorAlert(mess){
    swal({
        text : mess,
        icon : "error"
    });
}

function successAlert(mess){
    swal({
        text : mess,
        icon : "success"
    });
}

async function confirm_delete_store(src, id){
    var postData = "delete=set&id="+id+"&type="+src;
    var ret = await confirm_delete(src);
    if(ret){  
        ajax("backend/Tenant.php",postData,"post","","","get","").then((response) =>{
            var jsonResponse = JSON.parse(response);
            if(jsonResponse.okay){
                disappear("store-"+id);
            }else{
                errorAlert(jsonResponse.message);
            }
        });
    }
    
    return false;
}

function validate_modify_location(form, loc_id){
    var ret = true;
    var err = document.getElementById("loc_"+loc_id);
    var getData = "location=set&id="+loc_id;
    var postData = "modifyLocation=set&id="+loc_id+"&street="+form.street.value+"&building="+form.building.value+"&stall="+form.stall.value+"&description="+form.description.value;
    
    if(form.street.value.length < 3){
        err.innerHTML = "* Enter a valid Street name";
        ret = false;
    } else if(form.building.value.length < 3){
        err.innerHTML = "* Enter a valid Building name";
        ret = false;
    } else if(form.description.value.length < 3){
        err.innerHTML = "* Provide a description";
        ret = false;
    }
    if(ret){        
       ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData,"get","loc_"+loc_id);
    }
    
    setIntervals();
    
    return false;
}

function validate_outlet_form(form){
    var ret = true;
    var err = document.getElementById("outlet_error");
    var getData = "locations=set";
    var postData = "addLocation=set&street="+form.street.value+"&building="+form.building.value+"&stall="+form.stall.value+"&id="+form.id.value+"&description="+form.description.value;
    if(form.street.value.length < 3){
        err.innerHTML = "* Enter a valid Street name";
        ret = false;
    } else if(form.building.value.length < 3){
        err.innerHTML = "* Enter a valid Building name";
        ret = false;
    } else if(form.description.value.length < 3){
        err.innerHTML = "* Provide a description";
        ret = false;
    }
    if(ret){        
       form.building.value = "";
       form.stall.value = "";
       form.street.value = "";
       form.description.value = "";
       err.innerHTML = "";
        ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData+"&id="+form.id.value,"get","ajax_outlets");
        closeModal();
    }
    
    setIntervals();
    return false;
}

async function delete_loc(id, store_id){
    var postData = "deleteLocation=set&id="+id;
    
    if(confirm_delete("outlet")){        
        ajax("backend/Tenant.php",postData,"post","","","get","").then((response) =>{
           var jsonResponse = JSON.parse(response);
            if(jsonResponse.okay){
                check = true;
                disappear("loc_"+id);
            }else{
                errorAlert(jsonResponse.message);
            }
        });
    }
    
    return false;
}

function validate_product_change(form, id, name, type){
    
    var ret = true;
    var err = document.getElementById("prod_error");
    var name = form.name.value;
    var type = form.type.value;
    var price = form.price.value;
    var qty = form.qty.value;
    var description = form.description.value;

    var pkg = form.pkg.value;
    var getData = "product=set&id="+id+"&item_name="+name+"&type="+type;

    var postData = "saveChanges=set&id="+id+"&name="+name+"&type="+type+"&qty="+qty+"&description="+description+"&pkg="+pkg;

    if(name.length < 3){
        err.innerHTML = "* Enter a valid name";
        ret = false;
    } else if(type.length < 3){
        err.innerHTML = "* Enter a valid type";
        ret = false;
    }else if(price < 1){
        err.innerHTML = "* Enter a valid price";
        ret = false;
    }else if(description.length < 20){
        err.innerHTML = "* Enter a minimum of 20 characters description";
        ret = false;
    }else if(qty < 0){
        err.innerHTML = "* Enter a valid quantity";
        ret = false;
    }

    if(ret){        
       ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData,"get","ajax_product");
    }
    
    setIntervals();
    
    return false;
}

async function validate_remove_image(form, id, name){
    var getData = "";
    var postData = "removeImage=set&img_id="+id+"&name="+name;
    var ret = await confirm_delete("Image");
    if(ret){        
        ajax("backend/Tenant.php",postData,"post","","","get", "").then((response) =>{
            var jsonResponse = JSON.parse(response);
            if(jsonResponse.okay){
                check = true;
                disappear("ajax_"+id);
            }else{
                errorAlert(jsonResponse.message);
            }
            
        });
    }
    
    return false;
}

function validate_product_listing(form){
    var ret = true;
    var err = document.getElementById("product_error");
    var getData = "productServiceListing=set&id="+form.id.value;
    var postData = "addProductServiceListing=set&title="+form.title.value+"&id="+form.id.value;
    err.innerHTML = "";
    if(form.title.value.length < 2){
        err.innerHTML = "* The description should be atleast 20 characters";
        ret = false;
    }else if(form.content.value.length < 20){
        err.innerHTML = "* The description should be atleast 20 characters";
        ret = false;
    }else{
        var img = form.image;
        if(img.files.length > 0){
            for(var i = 0; i < img.files.length; i++){
                var ext = img.files.item(i).name.split(".").pop();
                var exts = ["jpg","jpeg","png","gif","ico"];
                if(!exts.includes(ext)){
                    err.innerHTML = "* Select a valid image file";
                    ret = false;
                    break;
                }else if(img.files.item(i).size > (1024 * 1024 * 5)){
                    err.innerHTML = "* File should be less than 5MB";
                    ret = false;
                    break;
                }   
            }   
        }
            
    }
    if(ret){      
        closeModal();
        var formData = new FormData(form);
        formData.append("addProductServiceListing","set");
        form.title.value = "";
        form.content.innerHTML = "";
        form.image.value = "";
        $.ajax({
            url : "backend/Tenant.php",
            type : 'POST',
            data : formData,
            async : false,
            success : function(data){
                get("backend/Handler.php",getData,"get","ajax_products_listing");
            },
            cache : false,
            contentType : false,
            processData : false
        });
    }
    
    setIntervals();
    return false;
}

async function validate_delete_product_listing(form, id){
    var postData = "removeProductServiceListing=set&id="+id;
    var ret = await confirm_delete("Product Listing");
    if(ret){
        ajax("backend/Tenant.php",postData,"post","","","get","").then((response) => {
            var jsonResponse = JSON.parse(response);
            if(jsonResponse.okay){
               disappear("product-listing-"+id);
            }else{
                errorAlert(jsonResponse.message);
            }
        });
    }
    
    setIntervals();
    return false;
}

function closeModal(){
    var btns = document.getElementsByClassName("modal-close");
    
    for(var i = 0; i < btns.length; i++){
        btns[i].click();
    }
}

function validate_add_hours(form){
    var from = form.from.value;
    var to = form.to.value;
    
    var getData = "getHours=set";
    var postData = "addHours=set&from="+from+"&to="+to;
    from = from.replace(":","");
    to = to.replace(":","");
    if(from < to){
        ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData,"get","ajax_hours");
        closeModal();
    }else{
       document.getElementById('err-hours').innerHTML = "Enter valid values";
        setIntervals();
    }
    return false;
}

function validate_add_lunch_hours(form){
    var from = form.from.value;
    var to = form.to.value;
    
    var getData = "getLunchHours=set";
    var postData = "addLunchHours=set&from="+from+"&to="+to;
    from = from.replace(":","");
    to = to.replace(":","");
    if(from < to && from > 1100 && to < 1500){
        ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData,"get","ajax_lunch_hours");
        closeModal();
    }else{
       document.getElementById('err-lunch-hours').innerHTML = "Enter valid values";
        setIntervals();
    }
         
    return false;
}

function validate_modify_availability(form){
    var hours = form.hours.value;
    var lunch = form.lunchhours.value;
    var weekends = form.weekends.value;
    var holidays = form.holidays.value;
    var id = form.id.value;
    
    var getData = "getAvailability=set&id="+id;
    var postData = "modifyAvailability=set&hours="+hours+"&lunch="+lunch+"&weekends="+weekends+"&holidays="+holidays+"&id="+id;
            
     ajax("backend/Tenant.php",postData,"post","backend/Handler.php",getData,"get","ajax_availability");
    closeModal();
    return false;
}

function validate_shoes_modal(form, id){
    var brand = form.brand.value;
    var colors = "";
    var sizes = "";
    
    var colorDivs = document.getElementsByClassName('shoe-color-input');
    
    for(var i = 0; i < colorDivs.length; i++){
        var div = colorDivs[i];
        if(colors.length > 0){
            colors+=",";
        }
        colors+= div.value;
    }
    var sizeDivs = document.getElementsByClassName('shoe-size-input');
    
    for(var i = 0; i < sizeDivs.length; i++){
        var div = sizeDivs[i];
        if(sizes.length > 0){
            sizes+=",";
        }
        sizes+= div.value;
    }
    
    if(id != ""){
        ajax("backend/Tenant.php","modifyCategory=set&brand="+brand+"&colors="+colors+"&sizes="+sizes+"&category=Shoes&pid="+id,"post","backend/Handler.php","getspecs=set&category=Shoes&pid="+id,"get","specs-div").then((response) => {
            
        });
    }else{
        var elm = document.getElementById('specs-div-final');
        elm.innerHTML = "";
        
        var str = "<input type='hidden' name='brand' value='"+brand+"'><input type='hidden' name='colors' value='"+colors+"'><input type='hidden' name='sizes' value='"+sizes+"'>";
        elm.innerHTML = str;
    }
    
    closeModal();
    return false;
}

function validate_clothes_modal(form, id){
    var brand = form.brand.value;
    var colors = "";
    var sizes = "";
    
    var colorDivs = document.getElementsByClassName('clothe-color-input');
    
    for(var i = 0; i < colorDivs.length; i++){
        var div = colorDivs[i];
        if(colors.length > 0){
            colors+=",";
        }
        colors+= div.value;
    }
    var sizeDivs = document.getElementsByClassName('clothe-size-input');
    
    for(var i = 0; i < sizeDivs.length; i++){
        var div = sizeDivs[i];
        if(sizes.length > 0){
            sizes+=",";
        }
        sizes+= div.value;
    }
    
    if(id != ""){
        ajax("backend/Tenant.php","modifyCategory=set&brand="+brand+"&colors="+colors+"&sizes="+sizes+"&category=Clothes&pid="+id,"post","backend/Handler.php","getspecs=set&category=Clothes&pid="+id,"get","specs-div");
    }else{
        var elm = document.getElementById('specs-div-final');
        elm.innerHTML = "";
        
        var str = "<input type='hidden' name='brand' value='"+brand+"'><input type='hidden' name='colors' value='"+colors+"'><input type='hidden' name='sizes' value='"+sizes+"'>";
        elm.innerHTML = str;    
    }
    
    closeModal();
    return false;
}

function validate_tv_modal(form, id){
    var make = form.make.value;
    var model = form.model.value;
    var inches = form.inches.value;
    var display = form.display.value;
    
    if(id != ""){
        ajax("backend/Tenant.php","modifyCategory=set&make="+make+"&model="+model+"&inches="+inches+"&display="+display+"&category=Televisions&pid="+id,"post","backend/Handler.php","getspecs=set&category=Televisions&pid="+id,"get","specs-div");
    }else{
        var elm = document.getElementById('specs-div-final');
        elm.innerHTML = "";

        var str = "<input type='hidden' name='make' value='"+make+"'><input type='hidden' name='model' value='"+model+"'><input type='hidden' name='inches' value='"+inches+"'><input type='hidden' name='display' value='"+display+"'>";
        elm.innerHTML = str;    
    }
    
    closeModal();
    return false;
}

function validate_computer_modal(form, id){
    var make = form.make.value;
    var model = form.model.value;
    var inches = form.inches.value;
    var memory = form.memory.value;
    var storage = form.storage.value;
    var ptype = form.ptype.value;
    var pspeed = form.pspeed.value;
    
    if(id != ""){
        ajax("backend/Tenant.php","modifyCategory=set&make="+make+"&model="+model+"&inches="+inches+"&memory="+memory+"&storage="+storage+"&ptype="+ptype+"&pspeed="+pspeed+"&category=Computers&pid="+id,"post","backend/Handler.php","getspecs=set&category=Computers&pid="+id,"get","specs-div");
    }else{
        var elm = document.getElementById('specs-div-final');
        elm.innerHTML = "";

        var str = "<input type='hidden' name='make' value='"+make+"'><input type='hidden' name='model' value='"+model+"'><input type='hidden' name='inches' value='"+inches+"'><input type='hidden' name='memory' value='"+memory+"'><input type='hidden' name='storage' value='"+storage+"'><input type='hidden' name='ptype' value='"+ptype+"'><input type='hidden' name='pspeed' value='"+pspeed+"'>";
        elm.innerHTML = str;
    }
    
        
    closeModal();
    return false;
}

function validate_phone_modal(form, id){
    var make = form.make.value;
    var model = form.model.value;
    var inches = form.inches.value;
    var memory = form.memory.value;
    var storage = form.storage.value;
    var fcamera = form.fcamera.value;
    var bcamera = form.bcamera.value;
    var bcapacity = form.bcapacity.value;
    
    if(id != ""){
        ajax("backend/Tenant.php","modifyCategory=set&make="+make+"&model="+model+"&inches="+inches+"&memory="+memory+"&storage="+storage+"&fcamera="+fcamera+"&bcamera="+bcamera+"&bcapacity="+bcapacity+"&category=Phones&pid="+id,"post","backend/Handler.php","getspecs=set&category=Phones&pid="+id,"get","specs-div");
    }else{
        var elm = document.getElementById('specs-div-final');
        elm.innerHTML = "";

        var str = "<input type='hidden' name='make' value='"+make+"'><input type='hidden' name='model' value='"+model+"'><input type='hidden' name='inches' value='"+inches+"'><input type='hidden' name='memory' value='"+memory+"'><input type='hidden' name='storage' value='"+storage+"'><input type='hidden' name='fcamera' value='"+fcamera+"'><input type='hidden' name='bcamera' value='"+bcamera+"'><input type='hidden' name='bcapacity' value='"+bcapacity+"'>";
        elm.innerHTML = str; 
    }
        
    closeModal();
    return false;
}

function toggleUserType(elm){
    if(elm.innerHTML == "Tenant"){
        elm.innerHTML = "Customer";
        document.getElementById("user-type").value = "tenant";
        document.getElementById("log-in-title").innerHTML = "Tenant Log In";
    }else{
        elm.innerHTML = "Tenant";
        document.getElementById("user-type").value = "customer";
        document.getElementById("log-in-title").innerHTML = "Log In";
    }
}

function validate_forgot_password(form){
    var email = form.email.value;
    ajax("backend/User.php","forgotPassword=set&email="+email,"post","","","","").then((response) =>{
        alert(response);
        var jsonResponse = JSON.parse(response);
        
        if(jsonResponse.okay){
            form.innerHTML = jsonResponse.message;
        }else{
            document.getElementById("forgot-password-error").innerHTML = jsonResponse.message;
        }
    });
    return false;
}

function validate_password_reset(form){
    var newP = form.new.value;
    var cNew = form.cnew.value;
    var key = form.key.value;

    if(newP === cNew){
        ajax("backend/User.php","resetPassword=set&password="+newP+"&key="+key,"post","","","","").then((response) =>{
            alert(response);
            var jsonResponse = JSON.parse(response);

            if(jsonResponse.okay){
                form.innerHTML = jsonResponse.message;
            }else{
                document.getElementById("reset-password-error").innerHTML = jsonResponse.message;
            }
        });
    }else{
        document.getElementById("reset-password-error").innerHTML = "Passwords do not match";
    }
    
    return false;
}
setIntervals();