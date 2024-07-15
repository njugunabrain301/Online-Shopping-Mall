function addColor(id, type){
    var elm = document.getElementById(id);
    elm.innerHTML += "<div class='color' style='width:100%'><input type='color' class='"+type+"-color-input'><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>";
}

function getFeatures(elm){
    var option = elm.options[elm.selectedIndex].innerHTML;
    var activeCategory = "";
    var modalCategoryLink = document.getElementById('select-info');
    if(option == "Shoes"){
        activeCategory = "#Shoes-modal";
        $("#Shoes-modal").modal('open');
    }else if(option == "Televisions"){
        activeCategory = "#Televisions-modal";
        $("#Televisions-modal").modal('open');
    }else if(option.includes("Phones")){
        activeCategory = "#Phones-modal";
        $("#Phones-modal").modal('open');
    }else if(option.includes("Clothes")){
        activeCategory = "#Clothes-modal";
        $("#Clothes-modal").modal('open');
    }else if(option.includes("Computers")){
        activeCategory = "#Computers-modal";
        $("#Computers-modal").modal('open');
    }
    if(activeCategory == ""){
        modalCategoryLink.removeAttribute("href");
        if(!modalCategoryLink.classList.contains("disable-select-info-icon")){
            modalCategoryLink.classList.add("disable-select-info-icon")
        }
    }else{
        modalCategoryLink.href = activeCategory;
        if(modalCategoryLink.classList.contains("disable-select-info-icon")){
            modalCategoryLink.classList.remove("disable-select-info-icon")
        }
    }
}

function addSize(id, type){
    var elm = document.getElementById(id);
    elm.innerHTML += "<div class='text' style='width:100%'><input type='text' maxlength='3' class='"+type+"-size-input' required><span class='btn-small red white-text' onclick ='removeSpec(this.parentNode)'><i class='fas fa-times'></i></span></div>";
}

function removeSpec(elm){
    $(elm).slideUp(200,function(){
        elm.innerHTML = ""; 
        elm.parentNode.removeChild(elm);
    });
}
