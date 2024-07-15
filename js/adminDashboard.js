function getProgressReport(){

    var getData = "getAdminReport=true";
    get("backend/adminGet.php",getData,"get","").then((response) => {
        var responseObject = JSON.parse(response);
        var bar = responseObject.statuses;
        getDashBoardChart(bar.type, bar.labels, bar.dataSets, "statusChart");
        var line = responseObject.types;
        getDashBoardChart(line.type, line.labels, line.dataSets, "typesChart");
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
                ],
            xAxes:[
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
                display: false
            },
            scales : yAxes
        }
    });
}

function fetchData(){
    var getData = "getRegionData=true";
    get("backend/adminGet.php",getData,"get","").then((response) => {
        var responseObject = JSON.parse(response);
        document.getElementById("tStores").innerHTML = responseObject.tStores;
        document.getElementById("tTenants").innerHTML = responseObject.tTenants;
        document.getElementById("tIncome").innerHTML = "Ksh. "+responseObject.tIncome+"/=";
    });
}

fetchData();

getProgressReport();