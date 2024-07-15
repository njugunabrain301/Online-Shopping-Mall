
function getReport(){
    set = true;
    var select = document.getElementById('store-selected');
    
    var sid = select.value;
    var sname = select.options[select.selectedIndex].text;
    var from = document.getElementById('from-date').value;
    var to = document.getElementById('to-date').value;
    
    if(from == "" || to == ""){
        var date = new Date();
        var year = date.getFullYear();
        var month = date.getMonth();
        var day = date.getDate();
        var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]
        from = new Date(year, month, 1);
        to = new Date(year, month, day);
        document.getElementById('from-date').value = months[month]+" 1 "+year;
        document.getElementById('to-date').value = months[month]+" "+day+" "+year;
    }
    from = formatDate(from);
    to = formatDate(to);
    
    document.getElementById('store-name').innerHTML = sname;
    var dest = "getStoreReport=true";
    if(sid == "All Stores"){
        dest = "getStoresReport=true";
    }
    var getData = dest+"&from="+from+"&to="+to+"&sid="+sid;
    get("backend/reports.php",getData,"get","").then((response) => {
        var responseObject = JSON.parse(response);
        var data = responseObject.data;
        document.getElementById('ajax-report').innerHTML = responseObject.text;
        setDataTables();
        document.getElementById('chartTitle').innerHTML = "Store Sales";
        getChart(data.type, data.labels, data.dataSets);
    });
}

function setDataTables(){
    $('#products-report-table').DataTable();
    $('#services-report-table').DataTable();
    $('#stores-report-table').DataTable();
}

function getChart(ctype, clabels, cdataSets){
    var chart = document.getElementById('myChart').getContext('2d');
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
    if(ctype == 'pie'){
        yAxes = {};
    }
    var chartObject = new Chart(chart, {
        type: ctype,
        data:{
            labels: clabels,
            datasets: cdataSets,
            backgroundColor: 'green'
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
getReport(); 