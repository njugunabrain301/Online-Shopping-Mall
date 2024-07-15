var disableDays = function (day){
    
    var dates = [
        
    ];
    var wDates = getDates();
    for(var i = 0; i < wDates.length; i++){
        h.push(wDates[i]);
    }
    for(var i = 0; i < h.length; i++){
        var obj = h[i];
        var d = new Date(day.getFullYear(), obj.month, obj.day).toDateString();
        dates.push(d);
    }
    
    dates.concat(getDates());
    if(dates.indexOf(day.toDateString()) >= 0)
        return true;
    return false;
}

function getDates(){
    var dates = [];
    
    if(w == "sartuday"){
        w = 0;
    }else if(w == "sunday"){
        w = 6;
    }else{
        return dates;
    }
    var year = now.getFullYear();
    var month = now.getMonth();
    var date = new Date(year, (month), 1);
    for(var i = 0; i < 62; i++){
        var day = date.getDay();
        if(day == w){
            var month = date.getMonth();
            var dayDate = date.getDate();
            var arr = {
                month: month,
                day: dayDate
            };
            dates.push(arr);
        }
        date.setDate(date.getDate() + 1);
    }
    
    return dates;
}
var options;

if(w == "none"){
    options = {
                disableWeekends: true,
                showClearBtn: true,
                minDate : now,
                maxDate : lates,
                disableDayFn : disableDays 
            };   
}else{
    options = {
                
                showClearBtn: true,
                minDate : now,
                maxDate : lates,
                disableDayFn : disableDays 
            };
}