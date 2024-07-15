function cancel_change(){
    var classes = document.getElementsByClassName('change');
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "none";
    }
    
    try{event.preventDefault();}catch(err){}
}

function toggle_div(div){
    cancel_change();
    document.getElementById(div).style.display = "block";
    location.href = "#";
    location.href = "#"+div;
}

function hide_form(id){
    var classes = document.getElementsByClassName("input_"+id);
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "none";
    }
    
    var classes = document.getElementsByClassName("label_"+id);
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "block";
    }
    try{ event.preventDefault();}catch(err){}
}

function show_form(id){
    var classes = document.getElementsByClassName("label_"+id);
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "none";
    }
    
    var classes = document.getElementsByClassName("input_"+id);
    
    for(var i = 0; i < classes.length; i++){
        classes[i].style.display = "block";
    }
    try{ event.preventDefault();}catch(err){}
}

cancel_change();

$(document).ready(function(){
   $(".modal").modal(); 
});