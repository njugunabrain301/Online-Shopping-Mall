var currentImg = 0;
var stackLeft = [];
var stackRight = [];
var numImages = 0;
const sliderImages = document.getElementsByClassName("slider-image");
var sliderIndicators;
$(document).ready(function(){
    try{
        numImages = sliderImages.length;
        var sliderIndicator = document.getElementById('slider-indicator');

        for(var i = 0; i < sliderImages.length; i++ ){
            stackLeft.push(i);
            sliderIndicator.innerHTML+="<span class='slider-indicator-unit'></span>";
        }
        stackLeft.reverse();
        sliderIndicators = document.getElementsByClassName('slider-indicator-unit');
        currentImg = stackLeft.pop();
        sliderImages[currentImg].classList.add('slider-current');
        sliderIndicators[currentImg].classList.add('active');
    }catch(err){
        console.log("No Slider functions detected");
    }
});

$("#slider-prev").click(function(){
    if(stackRight.length < 1) return;
    
    sliderImages[currentImg].classList.add('slider-hide-left');
    sliderImages[currentImg].classList.remove('slider-current');
    
    sliderIndicators[currentImg].classList.remove('active');
    
    stackLeft.push(currentImg);
    
    currentImg = stackRight.pop();
    
   sliderIndicators[currentImg].classList.add('active');
    sliderImages[currentImg].classList.remove("slider-hide-right");
    sliderImages[currentImg].classList.add('slider-current');
    
});

$("#slider-next").click(function(){
    if(stackLeft.length < 1) return;
    
    sliderImages[currentImg].classList.add('slider-hide-right');
    sliderImages[currentImg].classList.remove('slider-current');
    
    sliderIndicators[currentImg].classList.remove('active');
    
    stackRight.push(currentImg);
    
    currentImg = stackLeft.pop();
    
    sliderIndicators[currentImg].classList.add('active');
    
    sliderImages[currentImg].classList.remove("slider-hide-left");
    sliderImages[currentImg].classList.add('slider-current');
});
