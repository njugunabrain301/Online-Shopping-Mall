<?php

require_once "Database.php";
@session_start();
class Report extends Database{
    
    function __construct(){
        
    }
    
    function colors($index){
        $colors = [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(255, 150, 200, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(200, 240, 64, 0.6)',
            'rgba(255, 240, 120, 0.6)',
            'rgba(20, 240, 100, 0.6)',
            'rgba(100, 100, 64, 0.6)'
        ];
        
        return $colors[$index];
    }
    
    function getStoresReport(){
        $id = $_SESSION['id'];
        $from = strtotime($_GET['from']);
        $to = strtotime($_GET['to']);
        
        $res = $this->query("select s.id as sid, p.id, a.day as day, p.price from db.appointments a left join product p on a.itemId = p.id left join db.section s on s.id = p.web_id where a.status = ? and (a.day between ? and ?)",["COMPLETE", date("Y-m-d", $from), date("Y-m-d", $to)]);

        $apts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($apts, $row);
            $i++;
        }
        
        $res = $this->query("select s.id as sid, p.id, c.quantity, c.ordered as day, p.price from db.carts c left join product p on c.itemId = p.id left join db.section s on s.id = p.web_id where c.status = ? and (ordered between ? and ?)",["COMPLETE", date("Y-m-d", $from), date("Y-m-d", $to)]);

        $carts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($carts, $row);
            $i++;
        }

        $res = $this->query("select v.product_id, number_of_views from db.views v left join product p on v.product_id = p.id left join db.section s on s.id = p.web_id where (day between ? and ?)",[date("Y-m-d", $from), date("Y-m-d", $to)]);
        $views = [];
        $i = 0;
        while($row = $res->fetch()){
            array_push($views, $row);
            $i++;
        }
        
        $stores = '<table id=\'stores-report-table\'>
                        <thead>
                            <tr>
                                <th>Store Name</th>
                                <th>Total Items</th>
                                <th>Total Views</th>
                                <th>Total Sales</th>
                                <th>Conversion</th>
                                <th>Total Income</th>
                            </tr>
                        </thead>
                        <tbody>';
        
        $result = $this->query("select id,name from db.section where user_id = ?",[$id]);
        $ct = $result->rowCount();
        $ctype = "line";
        $daysBetween = (int) (($to - $from)/84600);
        $labels = [];
        $gap = 0;
        $gapCt = 5;
        if($daysBetween > 10){
            $gap = 5;
        }
        $start = $from;
        for($i = 0; $i < $daysBetween; $i++){
            if($gapCt >= $gap || ($daysBetween-1) == $i){
                $gapCt = 0;
                $thisDay = date('M j Y', $start);
                array_push($labels, $thisDay);   
            }else{
                array_push($labels, "");
            }
            $gapCt++;
            $start+=86400;
        }
        $dataSetsString = '[';
    
        $storeCount = 0;
            
        while($rowmain = $result->fetch()){
            $sid = $this->encode($rowmain['id']);
            $sname = $this->encode($rowmain['name']);
            $totalViews = 0;
            $totalSales = 0;

            $res = $this->query("select p.id, p.name, p.amount, p.duration, p.price, s.type, p.classification as class from product p left join db.section s on s.id = p.web_id where s.id = ?",[$sid]);

            $numProducts = $res->rowCount();
            $totalIncome = 0;
            while($row = $res->fetch()){
                $name = $this->encode($row['name']);
                $amount = $this->encode($row['amount']);
                $duration = $this->encode($row['duration']);
                $price = $this->encode($row['price']);
                $type = $this->encode($row['type']);
                $class = $this->encode($row['class']);
                $pid = $this->encode($row['id']);
                if($type == "bronze"){
                    break;
                }
                
                $viewCount = $this->getViews($pid, $views);
                if($class == "PRODUCT"){
                    $salesCount = $this->getSales($pid, $carts,"PRODUCT");
                    $totalIncome += ($price * $salesCount);
                }else{
                    $salesCount = $this->getSales($pid, $apts,"SERVICE");
                    $totalIncome += ($price * $salesCount);
                }

                $totalViews+=$viewCount;
                $totalSales+=$salesCount;

            }

            if($totalViews > 0)
                $totalConversion = $totalSales/$totalViews * 100;
            else 
                $totalConversion = 0;

            $stores.= "<tr>
                        <td>$sname</td>
                        <td>$numProducts</td>
                        <td>$totalViews</td>
                        <td>$totalSales</td>
                        <td>$totalConversion%</td>
                        <td>Ksh. $totalIncome</td>
                    </tr>";
                        
            $data = $this->getData($sid, $carts, $apts, $from, $to);
            $dataString = $this->toArrayString($data, "num");

            if(strlen($dataSetsString) > 1){
                $dataSetsString.=",";
            }
            $dataSetsString.='{
                            "label": "'.$sname.'",
                            "data": '.$dataString.',
                            "backgroundColor": "'.$this->colors($storeCount).'"
                        }';
            
            $storeCount++;
        }
        
        $stores.='</tbody>
                </table>';
        $labelsString = $this->toArrayString($labels, "str");
        $dataString = $this->toArrayString($data, "num");
        $dataSetsString.="]";
        $stores = trim(preg_replace('/\s\s+/',' ',$stores));
        $output = '{
                "data":{
                    "dataSets" : '.$dataSetsString.',
                    "labels":'.$labelsString.',
                    "type":"'.$ctype.'",
                    "count": '.$daysBetween.',
                    "title": "Store Sales"
                },
                "text": "'.$stores.'"
                }
            ';
        echo $output;
        
    }
    
    function getData($sid, $cart, $apt, $from, $to){
        $data = [];
        for($time = $from; $time < $to; $time+=86400){
            $recorded = "";
            $sales = 0;
            for($i = 0; $i < count($cart); $i++){
                $row = $cart[$i];
                if($row['sid'] == $sid && $row['day'] == date('Y-m-d', $time)){
                    $pid = $row['id'];
                    if(strpos($recorded, $pid) !== false){

                    }else{
                        $recorded.=" ".$pid;
                        $sales+=($row['quantity'] * $row['price'])  ;
                    }
                }
            }
            for($i = 0; $i < count($apt); $i++){
                $row = $apt[$i];
                if($row['sid'] == $sid && $row['day'] == date('Y-m-d', $time)){
                    $pid = $row['id'];
                    if(strpos($recorded, $pid) !== false){

                    }else{
                        $recorded.=" ".$pid;
                        $sales+=($row['price'])  ;
                    }
                }
            }
            array_push($data, $sales);
        }
        return $data;
    }
    
    function toArrayString($array, $type){
        $str = "[";
        for($i = 0; $i < count($array); $i++){
            if(strlen($str) > 1){
                $str.=",";
            }
            if($type == "str"){
                $str.='"'.$array[$i].'"';
            }else{
                $str.=$array[$i];
            }
        }
        $str.="]";
        
        return $str;
    }
    
    function getStoreReport(){
        $sid = $_GET['sid'];
        $from = strtotime($_GET['from']);
        $to = strtotime($_GET['to']);
        
        $totalViews = 0;
        $totalSales = 0;
        $res = $this->query("select p.id from db.appointments a left join product p on a.itemId = p.id left join db.section s on s.id = p.web_id where s.id = ? and a.status = ? and (a.day between ? and ?)",[$sid, "COMPLETE", date("Y-m-d", $from), date("Y-m-d", $to)]);
        
        $apts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($apts, $row);
            $i++;
        }
        
        $res = $this->query("select p.id, c.quantity from db.carts c left join product p on c.itemId = p.id left join db.section s on s.id = p.web_id where s.id = ? and c.status = ? and (ordered between ? and ?)",[$sid,"COMPLETE", date("Y-m-d", $from), date("Y-m-d", $to)]);
        
        $carts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($carts, $row);
            $i++;
        }
        $res = $this->query("select v.product_id, number_of_views from db.views v left join product p on v.product_id = p.id left join db.section s on s.id = p.web_id where s.id = ? and (day between ? and ?)",[$sid, date("Y-m-d", $from), date("Y-m-d", $to)]);
        $views = [];
        $i = 0;
        while($row = $res->fetch()){
            array_push($views, $row);
            $i++;
        }
        
        $res = $this->query("select p.id, p.name, p.amount, p.duration, p.price, s.type, p.classification as class from product p left join db.section s on s.id = p.web_id where s.id = ?",[$sid]);
        
        $products = "<h6 class='center'>Products</h6><table id='products-report-table'>";
        $services = "<h6 class='center'>Services</h6><table id='services-report-table'>";
        $set = false;
        $numProducts = $res->rowCount();
        $productCount = 0;
        $serviceCount = 0;
        $totalIncome = 0;
        $productArray = [];
        while($row = $res->fetch()){
            $name = $this->encode($row['name']);
            $amount = $this->encode($row['amount']);
            $duration = $this->encode($row['duration']);
            $price = $this->encode($row['price']);
            $type = $this->encode($row['type']);
            $class = $this->encode($row['class']);
            $pid = $this->encode($row['id']);
            if($type == "bronze"){
                break;
            }
            if(!$set){
                $set = true;
                
                $products.= "<thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Views</th>
                                    <th>Orders</th>
                                    <th>Conversion</th>
                                </tr>
                        </thead>
                        <tbody>";


                $services.= "<thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Views</th>
                                    <th>Appointments</th>
                                    <th>Conversion</th>
                                </tr>
                        </thead>
                        <tbody>";

            }
            $viewCount = $this->getViews($pid, $views);
            if($class == "PRODUCT"){
                $salesCount = $this->getSales($pid, $carts,"PRODUCT");
                if($viewCount > 0)
                    $conversion = $salesCount/$viewCount * 100;
                else
                    $conversion = 0;
                $products.="
                        <tr>
                            <td>$name</td>
                            <td>$amount</td>
                            <td>$viewCount</td>
                            <td>$salesCount</td>
                            <td>$conversion%</td>
                        </tr>";
                $productCount++;
                $totalIncome += ($price * $salesCount);
            }
            else{
                $salesCount = $this->getSales($pid, $apts,"SERVICE");
                if($viewCount > 0)
                    $conversion = $salesCount/$viewCount * 100;
                else
                    $conversion = 0;
                $services.="<tr>
                        <td>$name</td>
                        <td>$viewCount</td>
                        <td>$salesCount</td>
                        <td>$conversion%</td>
                        </tr>";
                $serviceCount++;
                $totalIncome += ($price * $salesCount);
            }
            
            $totalViews+=$viewCount;
            $totalSales+=$salesCount;
            $productArray += [$name => $salesCount];
        }
        $products.="</tbody></table>";
        $services.="</tbody></table>";
        arsort($productArray);
        
        $data = [];
        $labels = [];
        $i = 0;
        $others = 0;
        $othersCt = 0;
        foreach( $productArray as $key => $value ){
            if($i <= 5){
                array_push($data, $value);
                array_push($labels, $key);   
            }else{
                $othersCt++;
                $others+=$value;
            }
            $i++;
        }
        
        if($othersCt > 0){
            array_push($data, $others);
            array_push($labels, "Others ($othersCt)"); 
        }
        
        if($totalViews > 0)
            $totalConversion = $totalSales/$totalViews * 100;
        else 
            $totalConversion = 0;
        
        $store = "<table>
                    <thead>
                        <tr>
                            <th>No. of Products</th>
                            <th>Total Views</th>
                            <th>Total Sales</th>
                            <th>Conversion</th>
                            <th>Total Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>$numProducts</td>
                            <td>$totalViews</td>
                            <td>$totalSales</td>
                            <td>$totalConversion%</td>
                            <td>Ksh. $totalIncome</td>
                        </tr>
                    </tbody>
                    </table>";
        
        $out = $store;
        
        if($serviceCount > 0){
            $out.=$services;
        }
        if($productCount > 0){
            $out.=$products;
        }
        $labelsString = $this->toArrayString($labels, "str");
        $dataString = $this->toArrayString($data, "num");
        $dataSetsString ='[{
                            "label": "Sales",
                            "data": '.$dataString.',
                            "backgroundColor": [
                                        "rgba(255, 99, 132, 0.6)",
                                        "rgba(54, 162, 235, 0.6)",
                                        "rgba(255, 206, 86, 0.6)",
                                        "rgba(75, 192, 192, 0.6)",
                                        "rgba(255, 150, 200, 0.6)",
                                        "rgba(153, 102, 255, 0.6)"
                                    ]
                        }]';
        
        $out = trim(preg_replace('/\s\s+/',' ',$out));
        
        $output = '{
                "data":{
                    "dataSets" : '.$dataSetsString.',
                    "labels":'.$labelsString.',
                    "type": "pie",
                    "title": "Top 5 Products"
                },
                "text": "'.$out.'",
                "type": "store"
                }
            ';
        echo $output;
        
    }
    
    function getViews($pid, $views){
        $viewCount = 0;
        for($i = 0; $i < sizeof($views); $i++){
            $row = $views[$i];
            if($row['product_id'] == $pid){
                $viewCount+=$row['number_of_views'];
            }
        }
        return $viewCount;
    }
    
    function getSales($pid, $array, $class){
        $orderCount = 0;
        for($i = 0; $i < sizeof($array); $i++){
            $row = $array[$i];
            if($row['id'] == $pid){
                if($class == "SERVICE")
                    $orderCount++;
                else
                    $orderCount+=$row['quantity'];
            }
        }
        return $orderCount;
    }
    
    function getProgressReport(){
        $id = $_SESSION['id'];
        
        $res = $this->query("select s.id as sid, p.id, a.day as day, p.price from db.appointments a left join product p on a.itemId = p.id left join db.section s on s.id = p.web_id where a.status = ?",["COMPLETE"]);

        $apts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($apts, $row);
            $i++;
        }
        
        $res = $this->query("select s.id as sid, p.id, c.quantity, c.ordered as day, p.price from db.carts c left join product p on c.itemId = p.id left join db.section s on s.id = p.web_id where c.status = ?",["COMPLETE"]);

        $carts = array();
        $i = 0;
        while($row = $res->fetch()){
            array_push($carts, $row);
            $i++;
        }
        
        $res = $this->query("select v.product_id as pid, number_of_views, s.id as sid, v.day as day from db.views v left join product p on v.product_id = p.id left join db.section s on s.id = p.web_id where s.user_id = ?",[$id]);
        $views = [];
        $i = 0;
        while($row = $res->fetch()){
            array_push($views, $row);
            $i++;
        }

        $today = strtotime(date('Y-m-d'));
        
        $result = $this->query("select id,name, dateCreated from db.section where user_id = ? order by dateCreated ASC",[$id]);
        $ct = $result->rowCount();
        
        $dataSetsString = '[';
        $dateCreated = null;
        
        $storeCount = 0;
        $labels = [];
        $setLabels = false;
        $totalsData = [];
        $totalsLabels = [];
        $bgColors = [];
        while($rowmain = $result->fetch()){
            $sid = $this->encode($rowmain['id']);
            $sname = $this->encode($rowmain['name']);
            if($dateCreated == null){
                $dateCreated = $this->encode($rowmain['dateCreated']);
            }
            $data = [];
            $from = strtotime($dateCreated);
            $to = strtotime("+1 month",$from);
            $total = 0;
            while($from < $today){

                $monthViews = $this->getTotalViews($sid, $views, $from, $to);
                $total+=$monthViews;
                array_push($data, $monthViews);
                if(!$setLabels){
                    array_push($labels, date('M Y',$to));
                }
                $from = $to;
                $to = strtotime("+1 month",$from);
            }
            $setLabels = true;
            array_push($totalsData, $total);
            array_push($totalsLabels, $sname);
            array_push($bgColors, $this->colors($storeCount));
            $dataString = $this->toArrayString($data, "num");

            if(strlen($dataSetsString) > 1){
                $dataSetsString.=",";
            }
            $dataSetsString.='{
                            "label": "'.$sname.'",
                            "data": '.$dataString.',
                            "backgroundColor": "'.$this->colors($storeCount).'"
                        }';
            
            $storeCount++;
        }
        
        $labelsString = $this->toArrayString($labels, "str");
        $dataSetsString.="]";
        $totalsDataString = $this->toArrayString($totalsData, "num");
        $totalsLabelsString = $this->toArrayString($totalsLabels, "str");
        $bgColorsString = $this->toArrayString($bgColors, "str");
        $output = '{
                "line":{
                    "dataSets" : '.$dataSetsString.',
                    "labels":'.$labelsString.',
                    "type":"line"
                    },
                "bar":{
                    "dataSets" : [ {
                        "label": "Total Views",
                        "data": '.$totalsDataString.',
                        "backgroundColor": '.$bgColorsString.'
                    } ],
                    "labels":'.$totalsLabelsString.',
                    "type":"bar"
                    }
                }
            ';
        echo $output;
        
    }
    
    function getTotalSales($sid, $cart, $apt, $from, $to){
        $salesTotal = 0;
        for($time = $from; $time < $to; $time+=86400){
            $recorded = "";
            $sales = 0;
            for($i = 0; $i < count($cart); $i++){
                $row = $cart[$i];
                if($row['sid'] == $sid && $row['day'] == date('Y-m-d', $time)){
                    $pid = $row['id'];
                    if(strpos($recorded, $pid) !== false){

                    }else{
                        $recorded.=" ".$pid;
                        $sales+=($row['quantity'] * $row['price'])  ;
                    }
                }
            }
            for($i = 0; $i < count($apt); $i++){
                $row = $apt[$i];
                if($row['sid'] == $sid && $row['day'] == date('Y-m-d', $time)){
                    $pid = $row['id'];
                    if(strpos($recorded, $pid) !== false){

                    }else{
                        $recorded.=" ".$pid;
                        $sales+=($row['price'])  ;
                    }
                }
            }
            $salesTotal+=$sales;
        }
        return $salesTotal;
    }
    
    function getTotalViews($sid, $views, $from, $to){
        $viewsTotal = 0;
        for($time = $from; $time < $to; $time+=86400){
            $recorded = "";
            $viewsCount = 0;
            for($i = 0; $i < count($views); $i++){
                $row = $views[$i];
                if($row['sid'] == $sid && $row['day'] == date('Y-m-d', $time)){
                    $pid = $row['pid'];
                    if(strpos($recorded, $pid) !== false){

                    }else{
                        $viewsCount+=($row['number_of_views'])  ;
                    }
                }
            }
            $viewsTotal+=$viewsCount;
        }
        return $viewsTotal;
    }
}

function foward(){
    $report = new Report();
    if(isset($_GET['getStoreReport'])){
        $report->getStoreReport();
    }
    
    if(isset($_GET['getStoresReport'])){
        $report->getStoresReport();
    }
    
    if(isset($_GET['getProgressReport'])){
        $report->getProgressReport();
    }
}

foward();
?>