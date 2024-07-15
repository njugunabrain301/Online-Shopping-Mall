var debug = false;

async function ajax(backend_url, backend_vars, backend_method, frontend_url, frontend_vars, front_end_method, frontend_dest){
    var frontend_vars_array = [];
    frontend_vars_array.push(frontend_url);
    frontend_vars_array.push(frontend_vars);
    frontend_vars_array.push(front_end_method);
    frontend_vars_array.push(frontend_dest);
 
    return new Promise(function (resolve, reject){
        send(backend_url,backend_vars, backend_method, frontend_vars_array).then((response) => {
           resolve(response);
        });
    });
}

async function send(url, vars, method, frontend_vars){
    
    return new Promise(function (resolve, reject){
       var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function (){
            if(this.readyState == 4 && this.status == 200){
                if(debug){
                    alert("Post: "+this.responseText);
                }
                
                if(frontend_vars[0].length == 0){
                    resolve(this.responseText);
                }else{
                    get(frontend_vars[0],frontend_vars[1], frontend_vars[2], frontend_vars[3]).then((response) => {
                        resolve(response);
                    });   
                }
            }
        }

        if(method == "get"){
            xhttp.open("GET",url+"?"+vars, true);
            xhttp.send();
        }else if(method == "post"){
            xhttp.open("POST",url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(vars);
        } 
        
    });
}

async function get(url, vars, method, dest){
    return new Promise(function(resolve, reject){
        var xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function (){
            if(this.readyState == 4 && this.status == 200){
                if(debug){
                    alert("Get: "+this.responseText);
                }
                if(dest.length > 0)
                    document.getElementById(dest).innerHTML = this.responseText;
                resolve(this.responseText);
            }
        }
    
        if(method == "get"){
            xhttp.open("GET",url+"?"+vars, true);
            xhttp.send();
        }else if(method == "post"){
            xhttp.open("POST",url, true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(vars);
        } 
    });
}