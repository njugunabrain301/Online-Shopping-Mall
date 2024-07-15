document.getElementById('filter_btn').onclick = function(){
    filterToggle();
}

function filterToggle(){
    event.preventDefault();
    document.getElementById("filter-div").classList.toggle("filter-hidden");
}

function set_filter_values(){
    if(store == "on"){
        document.getElementById('f_stores').checked = true;
    }else{
        document.getElementById('f_stores').checked = false;
    }
    
    if(product == "on"){
        document.getElementById('f_product').checked = true;
    }else{
        document.getElementById('f_product').checked = false;
    }
    
    if(service == "on"){
        document.getElementById('f_service').checked = true;
    }else{
        document.getElementById('f_service').checked = false;
    }
    
    if(category == ""){
        category = "All Categories";
    }
    
    document.getElementById('f_category').value = category;
    document.getElementById('f_from').value = from;
    document.getElementById('f_to').value = to;
    document.getElementById('search_field').value = search;

}

set_filter_values();