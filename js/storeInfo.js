function rate(id){
    document.getElementById('rate-id').value = id;
    document.getElementById('rate-type').value = 'store';
}

function refreshStoreComments(id){
    get("backend/Handler.php","getStoreRating=set&id="+id,"get","store-rating").then((response) =>{
       get("backend/Handler.php","getStoreComments=set&id="+id,"get","store-comments"); 
    });
}

function delayScrollIntoView(){
    var classes = document.querySelectorAll(".store-slide-in");
    
    var observer = new IntersectionObserver((entries, observer)=>{
        entries.forEach( entry =>{
            if(!entry.isIntersecting){
                return;
            }else{
                entry.target.classList.add("appear");
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: "0px 0px -50px 0px"
    });
    
    classes.forEach(elem =>{
        observer.observe(elem);
    })
}

function loadStoreIntroSection(){
    var imgClass = document.querySelector(".store-about-image");
    var txtClass = document.querySelector(".store-about-text");
    var cmtClass = document.querySelector(".store-comments-slide-in");
    
    var observer = new IntersectionObserver((entries, observer)=>{
        entries.forEach( entry =>{
            if(!entry.isIntersecting){
                return;
            }else{
                entry.target.classList.add("appear");
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0
    });
    
    observer.observe(imgClass);
    observer.observe(txtClass);
    observer.observe(cmtClass);
}


