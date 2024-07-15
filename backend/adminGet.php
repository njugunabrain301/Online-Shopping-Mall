<?php

require_once "Database.php";

class AdminGet extends Database{
    
    function getStoresAll(){
        if(!$this->isAdmin()) return;
        $res = $this->query("select s.id as storeId, s.ext as storeExt, s.name as storeName, s.type as storeType, s.phone as storePhone, s.email as storeEmail, s.description as storeDescription, l.building, l.street, l.stall, u.firstname as fName, u.lastname as lName, u.phone as userPhone, l.description as ldesc, s.status as sstatus, lu.start as lunchStart, lu.end as lunchEnd, h.start as hourStart, h.end as hourEnd, s.weekends, s.holidays, s.paid from db.section s left join db.locations l on s.id = l.web_id left join db.user u on u.id = s.user_id left join db.lunchhours lu on s.lunchbreak = lu.id left join db.hours h on s.hours = h.id group by s.id",[]);
        
        $ajax = '{"data": [';
        $dataCount = 0;
        while($row = $res->fetch()){
            
            if($dataCount > 0){
                $ajax.=", ";
            }
            
            $ajax.=$this->formatForTable($row);
            
            $dataCount++;
        }
        $ajax.="] }";
        echo $ajax;
    }
    
    function formatForTable($row){
        $storeId = $row['storeId'];
        $storeExt = $row['storeExt'];
        $img = "images/sections/".$row['storeId'].".".$row['storeExt'];
        $storeName = $this->encode($row['storeName']);
        $storeType = $this->encode($row['storeType']);
        $storePhone = $this->encode($row['storePhone']);
        $storeEmail = $this->encode($row['storeEmail']);
        $storeDescription = $this->encode($row['storeDescription']);
        $street = $this->encode($row['street']);
        $building = $this->encode($row['building']);
        $desc = $this->encode($row['ldesc']);
        $stall = $this->encode($row['stall']);
        $location = $street.", ".$building.", ".$stall."<br>".$desc;
        $userName = $this->encode($row['fName']." ".$row['lName']);
        $userPhone = $this->encode($row['userPhone']);
        $paid = $row['paid'];
        $availability = $this->getAdminAvailability($row);
        $button = "";
        $status = $row['sstatus'];
        if($row['sstatus'] == "PENDING"){
            $button = '<button onclick=\" approveStore(\''.$storeId.'\'.,\'pending_div\'.)\" class=\"btn-small green\">Approve</button>                        <button onclick=\" declineStore(\''.$storeId.'\'.)\" class=\"btn-small red\">Decline</button>';
        }else if($row['sstatus'] == "SUSPENDED"){
            $button = '<button onclick=\" approveStore(\''.$storeId.'\',\'suspended_div\')\" class=\"btn-small green\">Approve</button>';
        }else if($row['sstatus'] == "APPROVED"){
            $button = '<button onclick=\" suspendStore(\''.$storeId.'\')\" class=\"btn-small yellow  darken-3\">Suspend</button>';
            $status = "Running";
        }
        
        $button2 = "";
        
        if($paid == "NOT PAID"){
            $button2 = '<button onclick=\" expiredStore(\''.$storeId.'\')\" class=\"btn-small red  darken-4 white-text\">Expired</button>';
            $status = "EXPIRED";
        }
            
        $storeName = '<a href=\"AdminStore.php?sid='.$storeId.'\">'.$storeName.'</a>';
        $str = '[
                    "'.$storeName.'",
                    "'.$storePhone.'",
                    "'.$storeEmail.'",
                    "'.$storeType.'",
                    "'.$userName.'",
                    "'.$status.'"
                   ]';
        return $str;
    }
    
    function getStores($id){
        if(!$this->isAdmin()) return;
        $res = $this->query("select s.id as storeId, s.ext as storeExt, s.name as storeName, s.type as storeType, s.phone as storePhone, s.email as storeEmail, s.description as storeDescription, l.building, l.street, l.stall, u.firstname as fName, u.lastname as lName, u.phone as userPhone, l.description as ldesc, s.status as sstatus, lu.start as lunchStart, lu.end as lunchEnd, h.start as hourStart, h.end as hourEnd, s.weekends, s.holidays from db.section s left join db.locations l on s.id = l.web_id left join db.user u on u.id = s.user_id left join db.lunchhours lu on s.lunchbreak = lu.id left join db.hours h on s.hours = h.id",[]);
        $div_id = "suspended_div";
        $display = "none";
        if($div_id == $id){
            $display = "initial";
        }
        $s_str = "<div id='$div_id' class='container' style='display: $display'>";
        
        $div_id = "live_div";
        $display = "none";
        if($div_id == $id){
            $display = "initial";
        }
        $l_str = "<div id='$div_id' class='container' style='display: $display'>";
        
        $div_id = "pending_div";
        $display = "none";
        if($div_id == $id){
            $display = "initial";
        }
        $p_str = "<div id='$div_id' class='container' style='display: $display'>";
        
        while($row = $res->fetch()){
            
            if($row['sstatus'] == "SUSPENDED"){
                $s_str.= $this->format($row);
            }else if($row['sstatus'] == "APPROVED"){
                $l_str.= $this->format($row);
            }else if($row['sstatus'] == "PENDING"){
                $p_str.= $this->format($row);
            }
        }
        $s_str.="</div>";
        $l_str.="</div>";
        $p_str.="</div>";
        echo $s_str.$l_str.$p_str;
    }
    
    function getStoreAdmin($id){
        if(!$this->isAdmin()) return;
        $res = $this->query("select s.id as storeId, s.ext as storeExt, s.name as storeName, s.type as storeType, s.phone as storePhone, s.email as storeEmail, s.description as storeDescription, l.building, l.street, l.stall, u.firstname as fName, u.lastname as lName, u.phone as userPhone, l.description as ldesc, s.status as sstatus, lu.start as lunchStart, lu.end as lunchEnd, h.start as hourStart, h.end as hourEnd, s.weekends, s.holidays, s.paid from db.section s left join db.locations l on s.id = l.web_id left join db.user u on u.id = s.user_id left join db.lunchhours lu on s.lunchbreak = lu.id left join db.hours h on s.hours = h.id where s.id = ?",[$id]);
        
        $row = $res->fetch();
        
        echo $this->format($row);
    }
    
    function format($row){
        
        $storeId = $row['storeId'];
        $storeExt = $row['storeExt'];
        $img = "images/sections/".$row['storeId'].".".$row['storeExt'];
        $storeName = $this->encode($row['storeName']);
        $storeType = $this->encode($row['storeType']);
        $storePhone = $this->encode($row['storePhone']);
        $storeEmail = $this->encode($row['storeEmail']);
        $storeDescription = $this->encode($row['storeDescription']);
        $street = $this->encode($row['street']);
        $building = $this->encode($row['building']);
        $desc = $this->encode($row['ldesc']);
        $stall = $this->encode($row['stall']);
        $location = $street.", ".$building.", ".$stall."<br>".$desc;
        $userName = $this->encode($row['fName']." ".$row['lName']);
        $userPhone = $this->encode($row['userPhone']);
        $paid = $row['paid'];
        $availability = $this->getAdminAvailability($row);
        $button = "";
        if($row['sstatus'] == "SUSPENDED"){
            $button = "<button onclick=' approveStore(\"$storeId\",\"suspended_div\")' class='btn-small green'>Approve</button>";
        }else if($row['sstatus'] == "APPROVED"){
            $button = "<button onclick=' suspendStore(\"$storeId\")' class='btn-small yellow  darken-3' >Suspend</button>";
        }else if($row['sstatus'] == "PENDING"){
            $button = "<button onclick=' approveStore(\"$storeId\",\"pending_div\")' class='btn-small green'>Approve</button>
                        <button onclick=' declineStore(\"$storeId\")' class='btn-small red'>Decline</button>";
        }
        
        $status = $row['sstatus'];        
        
        if($paid == "NOT PAID"){
            $status = "EXPIRED";
        }
            
        $str = "<div class='row admin-store section'>
                    <img src='$img' class='col s12 m4 l3'>
                    <div class='row container left-align col s12 m8 l9'>
                        <div class='col l12 s12'>$storeName</div>
                        <div class='col l4'> $storePhone</div>
                        <div class='col l8'>$storeEmail</div>
                        <div class='col s12'>$storeType</div>
                        <span class='divider col s12'></span>
                        <label class='col s12'>Owner</label>
                        <div class='col l12 s12'>$userName</div>
                        <div class='col l12 s12'>$userPhone</div>
                        <span class='divider col s12'></span>
                        <label class='col s12'>Store Location</label>
                        <div class='col s12'>$location</div>
                        <span class='divider col s12'></span>
                        <label class='col s12'>Availability</label>
                        <div class='col s12'>$availability</div>
                        <span class='divider col s12'></span>
                        <div class='col s12'><div class='section'>$button</div></div>
                    </div>
                </div>";
        return $str;
    }
    
    function getAdminAvailability($row){
                
        $lunchhours = $this->encode($row['lunchStart']." - ".$row['lunchEnd']);
        $hours = $this->encode($row['hourStart']." - ".$row['hourEnd']);
        $weekend = $this->encode($row['weekends']);
        $holidays = $this->encode($row['holidays']);
        
        if($weekend == "none"){
            $weekend = "Not available";
        }else if($weekend == "both"){
            $weekend = "Available on weekends";
        }else if($weekend == "sartuday"){
            $weekend = "Available on Sartuday only";
        }else if($weekend == "sunday"){
            $weekend = "Available on Sunday only";
        }
        
        if($holidays == "none"){
            $holidays = "Not available";
        }else if($holidays == "all"){
            $holidays = "Available on all holidays";
        }else if($holidays == "national"){
            $holidays = "Available on National holidays only";
        }else if($holidays == "religious"){
            $holidays = "Available on Religious holidays only";
        }
        
        $str = "
            <div class='col s12'>
                <div class='flex'>
                    <div class=''><label>Hours open&nbsp;:</label></div>
                    <div class=''>&nbsp;$hours</div>
                </div>
                <div class='flex'>
                    <div class=''><label>Lunch Hours&nbsp;:</label></div>
                    <div class=''>&nbsp;$lunchhours</div>
                </div>
                <div class='flex'>
                    <div class=''><label>Weekends&nbsp;:</label></div>
                    <div class=''>&nbsp;$weekend</div>
                </div>
                <div class='flex'>
                    <div class=''><label>Holidays&nbsp;:</label></div>
                    <div class=''>&nbsp;$holidays</div>
                </div>
            </div>
        ";
        return $str;
    }
    
    function getAdminReport(){
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(s.type) as ct, s.type from db.section s where s.paid = ? and admin_verified = ? group by s.type",["PAID", 1]);

        $bronze = 0;
        $silver = 0;
        $gold = 0;
        $diamond = 0;
        $platinum = 0;
        while($row = $res->fetch()){
            $type = $row['type'];
            $ct = $row['ct'];
            if($type == "bronze"){
                $bronze = $ct;
            }else if($type == "silver"){
                $silver = $ct;
            }else if($type == "gold"){
                $gold = $ct;
            }else if($type == "diamond"){
                $diamond = $ct;
            }else if($type == "platinum"){
                $platinum = $ct;
            }
        }
        
        $res = $this->query("select count(s.status) as ct, s.status, s.paid from db.section s where s.paid = ? group by s.status",["PAID"]);

        $pending = 0;
        $suspended = 0;
        $approved = 0;
        while($row = $res->fetch()){
            $status = $row['status'];
            $ct = $row['ct'];
            if($status == "PENDING"){
                $pending = $ct;
            }else if($status == "SUSPENDED"){
                $suspended = $ct;
            }else if($status == "APPROVED"){
                $approved = $ct;
            }
        }
        
        $res = $this->query("select count(*) as ct from db.section where paid = ? and admin_verified = ?",["NOT PAID", 1]);
        
        $row = $res->fetch();
        
        $expired = $row['ct'];
        
        $output = '{
                "types":{
                    "dataSets" : [ {
                        "label" : "Number",
                        "data" : ['.$bronze.','.$silver.','.$gold.','.$diamond.','.$platinum.'],
                        "backgroundColor": ["#8d6e63","#bdbdbd","#ffeb3b","#80cbc4","#607d8b"]
                    } ],
                    "labels": ["Bronze","Silver","Gold","Diamond","Platinum"],
                    "type":"bar"
                    },
                "statuses":{
                    "dataSets" : [ {
                        "label": "Number",
                        "data": ['.$pending.','.$approved.','.$suspended.','.$expired.'],
                        "backgroundColor": ["#2196f3","#4caf50","#ffeb3b","#ff6f00"]
                    } ],
                    "labels": ["Pending", "Running","Suspended","Expired"],
                    "type":"horizontalBar"
                    }
                }
            ';
        echo $output;
        
    }

    function getRegionData(){
        $res = $this->query("select count(*) as ct from db.section where admin_verified = ?",[1]);
        $row = $res->fetch();
        $stores = $row['ct'];
        
        if($stores == ""){
            $stores = 0;
        }
        
        $res = $this->query("select count(DISTINCT(user_id)) as ct from db.section where admin_verified = ? group by user_id",[1]);
        $row = $res->fetch();
        $tenants = $row['ct'];
        
        if($tenants == ""){
            $tenants = 0;
        }
        
        $date = date('Y-m-01');
        
        $res = $this->query("select sum(mc) as sm from db.ipay_payments where DATE(dateReceived) >= DATE(?)",[$date]);
        $row = $res->fetch();
        $income = $row['sm'];
        
        if($income == ""){
            $income = 0;
        }
        
        
        echo '{"tStores": '.$stores.', "tTenants": '.$tenants.', "tIncome": '.$income.'}';
    }
    
    function getIncomeData(){
        if(!$this->isAdmin()) return;
        
        $date = date('Y-m-01');
        
        $res = $this->query("select p.msisdn_id, p.msisdn_idnum, p.message, p.mc, p.p1, p.dateReceived, i.id as invId, s.id as sid, s.name as sname, i.purpose from db.ipay_payments p left join db.invoices i on i.txncd = p.txncd left join db.section s on s.id = i.store_id where DATE(p.dateReceived) >= DATE(?)",[$date]);
        
        $ajax = '{"data": [';
        $dataCount = 0;
        while($row = $res->fetch()){
            
            $idnum = $row['msisdn_idnum'];
            $idname = $row['msisdn_id'];
            $message = $row['message'];
            $amt = $row['mc'];
            $p1 = $row['p1'];
            $dateReceived = $row['dateReceived'];
            $invId = $row['invId'];
            $sid = $row['sid'];
            $sname = $row['sname'];
            $purpose = $row['purpose'];
            
            if($dataCount > 0){
                $ajax.=", ";
            }
            
            $str = '[
                    "'.$invId.'",
                    "'.$p1.'",
                    "'.$sname.'",
                    "'.$amt.'",
                    "'.$purpose.'",
                    "'.$dateReceived.'",
                    "'.$idnum.'",
                    "'.$idname.'",
                    "'.$message.'"
                   ]';
            
            $ajax.=$str;
            
            $dataCount++;
        }
        $ajax.="] }";
        echo $ajax;
    }
}

$adminGet = new AdminGet();

function foward(){
    $adminGet = new AdminGet();
    if(isset($_GET['getStores']))   {
        $id = $_GET['id'];
        $adminGet->getStores($id);
    }else if(isset($_GET['getStoresAll']))   {
        $adminGet->getStoresAll();
    }else if(isset($_GET['getAdminReport']))   {
        $adminGet->getAdminReport();
    }else if(isset($_GET['getRegionData']))   {
        $adminGet->getRegionData();
    }else if(isset($_GET['getIncomeData']))   {
        $adminGet->getIncomeData();
    }
}

foward();
?>