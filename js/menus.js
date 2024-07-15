 $(document).ready(function(){
     checkWidth();
 });
     
$(window).resize(function(){
    checkWidth();
});
function checkWidth(){
    var width = $(document).width();
    if(width <= 990){
        if(!$("#nav-links").hasClass("sidenav")){
            $("#nav-links").addClass("sidenav");
            $("#nav-links-trigger").removeClass("hide");
            $('.sidenav.header-nav').sidenav({
                menuWidth: 200,
                edge: 'right'
            });
        }
    }else 
    if(width > 990){
        if($("#nav-links").hasClass("sidenav")){
            $("#nav-links").removeClass("sidenav");
            $("#nav-links-trigger").addClass("hide");
        }
    }
    try{
        if(width <= 990){
            if(!$("#menu-links").hasClass("sidenav")){
                $("#menu-links").addClass("sidenav");
                $("#menu-links-trigger").removeClass("hide");
                $('.sidenav.menu-nav').sidenav();
            }
        }else 
        if(width > 990){
            if($("#menu-links").hasClass("sidenav")){
                $("#menu-links").removeClass("sidenav");
                $("#menu-links-trigger").addClass("hide");
            }
        }   
    }catch(err){
        console.log("Menu error");
    }
}