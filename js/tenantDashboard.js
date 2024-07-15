var orders = false;
var apts = false;
var reports = false;

function setEnabled(){
    if(orders){
        document.getElementById("orders-link").href = "storeorders.php";
        document.getElementById("orders-indicator").innerHTML = "Enabled";
        if(document.getElementById("orders-indicator").classList.contains("grey")){
            document.getElementById("orders-indicator").classList.remove("grey");
        }
        if(!document.getElementById("orders-indicator").classList.contains("green")){
            document.getElementById("orders-indicator").classList.add("green");
        }
    }else{
        document.getElementById("orders-link").removeAttribute("href");
        document.getElementById("orders-indicator").innerHTML = "Disabled";
        if(document.getElementById("orders-indicator").classList.contains("green")){
            document.getElementById("orders-indicator").classList.remove("green");
        }
        if(!document.getElementById("orders-indicator").classList.contains("grey")){
            document.getElementById("orders-indicator").classList.add("grey");
        }
    }
    if(apts){
        document.getElementById("apts-link").href = "storeappointments.php";
        document.getElementById("apts-indicator").innerHTML = "Enabled";
        if(document.getElementById("apts-indicator").classList.contains("grey")){
            document.getElementById("apts-indicator").classList.remove("grey");
        }
        if(!document.getElementById("apts-indicator").classList.contains("green")){
            document.getElementById("apts-indicator").classList.add("green");
        }
    }else{
        document.getElementById("apts-link").removeAttribute("href");
        document.getElementById("apts-indicator").innerHTML = "Disabled";
        if(document.getElementById("apts-indicator").classList.contains("green")){
            document.getElementById("apts-indicator").classList.remove("green");
        }
        if(!document.getElementById("apts-indicator").classList.contains("grey")){
            document.getElementById("apts-indicator").classList.add("grey");
        }
    }
    if(reports){
        document.getElementById("reports-link").href = "reports.php";
        document.getElementById("reports-indicator").innerHTML = "Enabled";
        if(document.getElementById("reports-indicator").classList.contains("grey")){
            document.getElementById("reports-indicator").classList.remove("grey");
        }
        if(!document.getElementById("reports-indicator").classList.contains("green")){
            document.getElementById("reports-indicator").classList.add("green");
        }
    }else{
        document.getElementById("reports-link").removeAttribute("href");
        document.getElementById("reports-indicator").innerHTML = "Disabled";
        if(document.getElementById("reports-indicator").classList.contains("green")){
            document.getElementById("reports-indicator").classList.remove("green");
        }
        if(!document.getElementById("reports-indicator").classList.contains("grey")){
            document.getElementById("reports-indicator").classList.add("grey");
        }
    }
}

function getEnabled(){
    get("backend/Handler.php","getEnabled=set","get","").then((response) =>{
        var jsonResponse = JSON.parse(response);
        orders = jsonResponse.ORDERS;
        apts = jsonResponse.APTS;
        reports = jsonResponse.REPORTS;
        
        setEnabled();
    });
}

function checkEnabled(val){
    if(!val){
        event.preventDefault();
        messageAlert("You don't currently have access to this feature");
    }
}

function getProgressReport(){

    var getData = "getProgressReport=true";
    get("backend/reports.php",getData,"get","").then((response) => {
        var responseObject = JSON.parse(response);
        var bar = responseObject.bar;
        getDashBoardChart(bar.type, bar.labels, bar.dataSets, "totalsChart");
        var line = responseObject.line;
        getDashBoardChart(line.type, line.labels, line.dataSets, "progressChart");
    });
}

function getDashBoardChart(ctype, clabels, cdataSets, chartId){
    var chart = document.getElementById(chartId).getContext('2d');
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 14;
    Chart.defaults.global.defaultFontColor = '#000';
    var yAxes = {
            yAxes:[
                    {
                        display:true,
                        ticks:{
                            suggestedMin: 0,
                            precision: 0
                        }
                    }
                ]
        };

    var chartObject = new Chart(chart, {
        type: ctype,
        data:{
            labels: clabels,
            datasets: cdataSets
        },
        options:{
            legend:{
                position: 'top'
            },
            scales : yAxes
        }
    });
}

function formatDate(date){
    date = new Date(date);
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
    
    if(month.length < 2)
        month = '0'+month;
    if(day.length < 2)
        day = '0'+day;
    
    return [year,month,day].join('-');
}

function getMessageCount(){
    
}

function getInvoiceCount(){
    
}

getProgressReport(); 