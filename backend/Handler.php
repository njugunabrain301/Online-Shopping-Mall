<?php
require_once "Database.php";
@session_start();

class Handler extends Database{
    
    function __construct(){
        $this->cookieLogIn();
        $this->checkExpired();
    }
    
    function garbageCollection(){
//        $this->query("");
    }
    
    function generateInvoice(){
        require_once "fpdf/fpdf.php";
        
        $iid = $_GET['iid'];
        
        $res = $this->query("select i.status, i.amount, i.purpose, i.dateIssued, i.datePaid, s.name, s.phone, s.email, p.msisdin_id, p.msisdin_idnum, u.firstname, u.lastname from db.invoices i inner join db.section s on s.id = i.store_id inner join ipay_payments p on p.txncd = i.txncd inner join db.user u.id = s.user_id where i.id = ?",[$iid]);
        
        $row = $res->fetch();
        
        $status = $row['status'];
        $amt = $row['amount'];
        $purpose = $row['purpose'];
        $dateIssued = $row['dateIssued'];
        $datePaid = $row['datePaid'];
        $sname = $row['name'];
        $sphone = $row['phone'];
        $semail = $row['email'];
        $userName = $row['firstname']." ".$row['lastname'];
        $custName = $row['msisdin_id'];
        $custPhone = $row['msisdin_idnum'];
        
        $fpdf = new FPDF('p','mm','A4');
        
        $fpdf->AddPage();
        
        if($status == "PAID"){
            $fpdf->SetFont('Arial','B',25);

            $fpdf->cell(100, 20, "Receipt", 0, 0, 'L');
            $fpdf->cell(0, 30, "Shop Online", 0, 1, 'R');
            $fpdf->SetFont('Arial','B',14);

            $fpdf->cell(80, 13, "Invoice Number", 0, 0, 'L');
            $fpdf->cell(80, 13, "Date Of Issue", 0, 1, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(80, 13, "INV-".$iid, 0, 0, 'L');
            $fpdf->cell(80, 13, $dateIssued, 0, 1, 'L');
            $fpdf->cell(0, 10, "", 1, 0, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Billed to: ", 0, 0, 'L');
            $fpdf->cell(100, 10, "From: ", 0, 1, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, $userName, 0, 0, '');
            $fpdf->cell(100, 10, "Shop Online", 0, 1, '');
            
            $fpdf->cell(100, 10, $sname, 0, 0, '');
            $fpdf->cell(100, 10, "0717563148", 0, 1, '');
            
            $fpdf->cell(100, 10, $sphone, 0, 0, '');
            $fpdf->cell(100, 10, "bjmbugua7@gmail.com", 0, 1, '');
            
            $fpdf->cell(100, 10, $semail, 0, 0, '');
            $fpdf->cell(100, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 1, 0, '');
            $fpdf->cell(0, 10, "", 1, 0, '');

            $fpdf->SetFont('Arial','',12);
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Purpose ", 0, 0, 'L');
            $fpdf->cell(100, 10, "Amount", 0, 1, 'L');

            $fpdf->cell(100, 10, $purpose, 0, 0, 'L');
            $fpdf->cell(100, 10, $amt, 0, 1, 'L');
            
            $fpdf->SetFont('Arial','',12);
            $fpdf->SetFont('Arial','',12);
            
            $fpdf->cell(0, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 0, 1, '');
            
            $fpdf->cell(0, 10, "Total: Ksh. ".$amt."/= ", 0, 1, 'R');
            
            $fpdf->cell(0, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 0, 1, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Paid By: ", 0, 1, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, $custName, 0, 1, '');
            $fpdf->cell(100, 10, $custPhone, 0, 1, '');
            $fpdf->cell(100, 10, $sphone, 0, 1, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "On: ", 0, 0, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, $datePaid, 0, 1, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Amount Paid: ", 0, 0, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, "Ksh. ".$amt."/=", 0, 1, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Balance: ", 0, 0, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, "Ksh. 0/=", 0, 1, '');
            
            $fpdf->cell(0, 10, "", 1, 0, '');
            $fpdf->cell(0, 10, "", 1, 0, '');
            
        }else{
            $fpdf->SetFont('Arial','B',25);

            $fpdf->cell(100, 20, "INVOICE", 0, 0, 'L');
            $fpdf->cell(0, 30, "Shop Online", 0, 1, 'R');
            $fpdf->SetFont('Arial','B',14);

            $fpdf->cell(80, 13, "Invoice Number", 0, 0, 'L');
            $fpdf->cell(80, 13, "Date Of Issue", 0, 1, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(80, 13, "INV-".$iid, 0, 0, 'L');
            $fpdf->cell(80, 13, $dateIssued, 0, 1, 'L');
            $fpdf->cell(0, 10, "", 1, 0, '');
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Billed to: ", 0, 0, 'L');
            $fpdf->cell(100, 10, "From: ", 0, 1, 'L');
            $fpdf->SetFont('Arial','',13);
            $fpdf->cell(100, 10, $userName, 0, 0, '');
            $fpdf->cell(100, 10, "Shop Online", 0, 1, '');
            
            $fpdf->cell(100, 10, $sname, 0, 0, '');
            $fpdf->cell(100, 10, "0717563148", 0, 1, '');
            
            $fpdf->cell(100, 10, $sphone, 0, 0, '');
            $fpdf->cell(100, 10, "bjmbugua7@gmail.com", 0, 1, '');
            
            $fpdf->cell(100, 10, $semail, 0, 0, '');
            $fpdf->cell(100, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 1, 0, '');
            $fpdf->cell(0, 10, "", 1, 0, '');

            $fpdf->SetFont('Arial','',12);
            
            $fpdf->SetFont('Arial','B',13);
            $fpdf->cell(100, 10, "Purpose ", 0, 0, 'L');
            $fpdf->cell(100, 10, "Amount", 0, 1, 'L');

            $fpdf->cell(100, 10, $purpose, 0, 0, 'L');
            $fpdf->cell(100, 10, $amt, 0, 1, 'L');
            
            $fpdf->SetFont('Arial','',12);
            $fpdf->SetFont('Arial','',12);
            
            $fpdf->cell(0, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 0, 1, '');
            
            $fpdf->cell(0, 10, "Total: Ksh. ".$amt."/= ", 0, 1, 'R');
            
            $fpdf->cell(0, 10, "", 0, 1, '');
            $fpdf->cell(0, 10, "", 0, 1, '');
            
            $fpdf->cell(0, 10, "N/B. In order to pay you have to log in to your account, go to the invoices tab and click on the 'Pay' option. Thank you", 0, 1, '');
        }
        
        $fpdf->Output();   
    }
    
    function checkExpired(){
        $now = date('Y-m-d');
        $time = time();
        
        $res = $this->query("select checked_on from db.expiry_check",[]);
        
        $row = $res->fetch();
        
        $date = $row['checked_on'];

        if(strcmp($now,$date) != 0){
            
            $this->query("update db.expiry_check set checked_on = ? ",[$now]);
            
            $res = $this->query("select id, paid_until, email, type, sent_renew_email as sent from db.section where admin_verified = ?",[1]);
            
            while($row = $res->fetch()){
                $paid_until_timestamp = strtotime($row['paid_until']) ;
                $diff = $paid_until_timestamp - $time;
                $package = $row['type'];
                $sid = $row['id'];
                $email = $row['email'];
                $sent = $row['sent'];
                
                if($diff < 3){
                    if($diff < 0){
                        $msg = "<center>Your account has expired. Please log in to renew your monthly fee</center>";
                        $subj = "Your customers are looking for you";
                    }else{
                        $msg = "<center>Your account is about to expire. Please log in to renew your monthly fee</center>";
                        $subj = "Your account is about to expire";
                    }
                    $to = $email;
                    
                    $from = 'response@buynsell.co.ke';
                    $name = 'Market Palace';
                    
                    $amt = 499;
        
                    if($package == "bronze"){
                        $amt = 499;
                    }else if($package == "silver"){
                        $amt = 1199;
                    }else if($package == "gold"){
                        $amt = 1999;
                    }else if($package == "diamond"){
                        $amt = 2399;
                    }else if($package == "platinum"){
                        $amt = 3999;
                    }
                    
                    if($sent == 0){
                        $this->query("update db.section set sent_renew_email = 0 where id = ?",[$sid]);
                        $this->query("insert into db.invoices (store_id, purpose, amount, reference, dateIssued) values (?,?,?,?,?)",[$sid, "Renew your $package package", $amt, $sid."_RENEW", date('Y-m-d')]);  
//                    $this->sendEmail($to,$from, $name ,$subj, $msg);
                    }else if($diff  < 0 && $sent == 0){
                        $this->query("update db.section set sent_renew_email = -1 where id = ?",[$sid]);
//                    $this->sendEmail($to,$from, $name ,$subj, $msg);
                    }
                }
            }
            $this->garbageCollection();
        }
    }
    
    function getInvoices(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "DATA": "'.$mess.'"}'; 
            
            echo $out;  
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select i.id, i.purpose, i.reference, i.dateIssued, i.datePaid, i.amount, i.status, s.name, s.id as sid, s.admin_verified from db.invoices i left join db.section s on s.id = i.store_id where s.user_id = ? ", [$id]);
        
        $data = "";
        
        while($row = $res->fetch()){
            $invid = $row['id'];
            $purpose = $this->encode($row['purpose']);
            $amt = $row['amount'];
            $status = $row['status'];
            $sname = $this->encode($row['name']);
            $sid = $row['sid'];
            $dateIssued = $this->formatDate($row['dateIssued']);
            $datePaid = $this->formatDate($row['datePaid']);
            $admin_verified = $row['admin_verified'];
            $aboutUrl = "viewStoreInfo.php?store_id=$sid&name=$sname";
            $ref = $row['reference'];
            
            $inspection = $sid."_INSPECTION";
            $button = "";
            if($status == "NOT PAID"){
                if($admin_verified == 1 || $ref == $inspection ){
                    $button = '<button onclick=\"payInvoice(\''.$invid.'\', '.$amt.')\" class=\"btn-small green\"><a href=\"#payment-modal\" class=\"white-text modal-trigger\">Pay</a></button>';   
                }else{
                    $button = "<span>Not Verified</span>";
                }
                $datePaid = $status;
            }else if($status == "PAID"){
                $button = "<span class='green-text'></span>";
            }
            
            $data .= '<tr id=\'INV-'.$invid.'\'>
                        <td>'.$invid.'</td>
                        <td>'.$purpose.'</td>
                        <td>'.$amt.'</td>
                        <td><a href=\"'.$aboutUrl.'\">'.$sname.'</a></td>
                        <td>'.$dateIssued.'</td>
                        <td>'.$datePaid.'</td>
                        <td>'.$button.'</td>
                        <td><form action=\"backend/handler.php\"><input type=\'hidden\' name=\'iid\' value=\''.$invid.'\'/><button type=\'submit\' name=\'printInvoice\'></button></form></td>
                        <td><span><i class=\'fas fa-trash-alt white-text btn-small red\' onclick=\"deleteInvoice(\''.$invid.'\')\"></i></span></td>
                    </tr>';
        }
        
       $data = trim(preg_replace('/\s\s+/',' ',$data));
        $out = '{ "DATA": "'.$data.'"}'; 
        echo $out;
    
    }
    
    function cookieLogIn(){
        if($this->isLoggedIn()){
            return;
        }
        if(!isset($_COOKIE['id']) || !isset($_COOKIE['type'])){
            return;
        }
        $type = $_COOKIE['type'];
        $result = $this->query("SELECT * from db.User WHERE remember_me = ?",[$_COOKIE['id']]);
        if($result->rowCount() == 0){
            return;
        }else{
            $found = false;
            while($row = $result->fetch()){

                $_SESSION['firstname'] = $row['firstname'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['type'] = $type;
                $_SESSION['id']=$row['id'];
                $_SESSION['phone'] = $row['phone'];
                $rank = $row['type'];
                $ext = $row['ext'];
                $imgPath = 'images/users/'.$row['id'].".".$ext;
                if(!file_exists("../".$imgPath)){
                    $imgPath = 'images/users/default.png';
                }

                $_SESSION['profile-image']=$imgPath;
                if($ext == "" || $ext == NULL){
                    $_SESSION['profile-image']='images/users/default.png';
                }
                if($rank=='ADMIN'){
                    $_SESSION['type'] = $rank;
                }
                $found = true;
            }
            
            if($found){
                header("Refresh: 0");
            }
        }
    }
    
    function getProductOrdered(){
        $id = $_GET['id'];
        $name = $_GET['item_name'];
        $location = $_GET['loc'];
        $ldesc = $_GET['locDesc'];
        $type = $_GET['type'];
        
        if($type == "apt"){
            $res = $this->query("select p.id as pid, p.description, p.price, p.duration, p.category, p.amount, p.type as pType, user_id as owner, h.start as hourstart, h.end as hourend, l.start as lunchstart, l.end as lunchend, weekends, holidays, s.id as sid, sm.sstars as nstars, sm.srevs as nrevs, s.name as sname, s.type as stype, s.phone as sphone from db.appointments ap left join db.product p on ap.itemId = p.id left join db.section s on s.id = p.web_id left join (select SUM(stars) as sstars, COUNT(stars) as srevs , itemId from db.carts where stars > 0 GROUP BY itemId) sm on sm.itemId = p.id left join db.hours h on h.id = s.hours left join db.lunchhours l on l.id = s.lunchbreak where ap.id = ?",[$id]);
        }else{
            $res = $this->query("select p.id as pid, p.description, p.price, p.duration, p.category, p.amount, p.type as pType, user_id as owner, h.start as hourstart, h.end as hourend, l.start as lunchstart, l.end as lunchend, weekends, holidays, s.id as sid, sm.sstars as nstars, sm.srevs as nrevs, s.name as sname, s.type as stype, s.phone as sphone from db.carts ca left join db.product p on ca.itemId = p.id left join db.section s on s.id = p.web_id left join (select SUM(stars) as sstars, COUNT(stars) as srevs , itemId from db.carts where stars > 0 GROUP BY itemId) sm on sm.itemId = p.id left join db.hours h on h.id = s.hours left join db.lunchhours l on l.id = s.lunchbreak where ca.id = ?",[$id]);
        }
        
        
        
        $product = $res->fetch();
        $pid = $product['pid'];
        $images = $this->query("select ext,id,num from db.product_images where product_id = ?",[$pid]);
        
        $type = $this->encode($product['pType']);
        $price = $this->encode($product['price']);
        $description = $this->encode($product['description']);
        $category = $this->encode($product['category']);
        $owner = $this->encode($product['owner']);
        $hourStart = $this->encode($product['hourstart']);
        $hourEnd = $this->encode($product['hourend']);
        $lunchStart = $this->encode($product['lunchstart']);
        $lunchEnd = $this->encode($product['lunchend']);
        $weekends = $this->encode($product['weekends']);
        $holidays = $this->encode($product['holidays']);
        $sname = $this->encode($product['sname']);
        $stars = $product['nstars'];
        $reviewers = $product['nrevs'];
        $stype = $this->encode($product['stype']);
        $sphone = $this->encode($product['sphone']);
        if($reviewers == ""){
            $reviewers = 0;
        }
        $class = "item";
        if($type == "SERVICE"){
            $class = "service";
        }
        $label = "Duration (hrs)";
        $sid = $this->encode($product['sid']);
        $target = "";
        $displayBtn = "initial";
        $starsString = $this->rating($stars, $reviewers, "part");
        if($class=="service"){
            $qty = $this->encode($product['duration']);
            $target = "apt-modal";
        }else{
            $label = "Quantity";
            $target = "order-modal";
            $qty = $_GET['qty'];
        }
        if($stype == "silver"){
            $displayBtn = "none";
        }
        $disabled = "";
        if($this->isLoggedIn() && $owner == $_SESSION['id']){
            $disabled = "disabled";
        }
        $imagePath = "";
        $imagesStr = "";
        if($holidays == "national"){
            $res = $this->query("select * from db.holidays where type = ?",['RELIGIOUS']);
        }else if($holidays == "religious"){
            $res = $this->query("select * from db.holidays where type = ?",['NATIONAL']);
        }else if($holidays == "none"){
            $res = $this->query("select * from db.holidays",[]);
        }
        $holidaysArray = "[";
        if($holidays != "both"){
            while($row = $res->fetch()){
                if(strlen($holidaysArray) > 1){
                    $holidaysArray.=",";
                }
                $month = $row['month'];
                $day = $row['day'];
                $holidaysArray.= "{ month: '$month', day: '$day'}";
            }
        }
        $holidaysArray .="]";
        
        
        if(isset($_SESSION['id'])){
            echo "<div class='hide' id='loggedIn'>true</div>";
        }else{
            echo "<div class='hide' id='loggedIn'>false</div>";
        }   
            
            $imagesStr = "
                <h6></h6>
                <div id='product'>
                <div id='image-slider'> <div class='slider-indicator' id='slider-indicator'></div>";
            $ct = 0;
            while($image = $images->fetch()){
                $image_id = $image['num'];
                $img_id = $image['id'];
                $imagePath = "images/products/".$pid."_".$image_id.".".$image['ext'];
                    $imagesStr.= "<img src='$imagePath' class='slider-image slider-hide-left'>";   
                
                $ct++;
            }
            $imagesStr.="
                <i class='fas fa-arrow-circle-left' id='slider-prev'></i>
                <i class='fas fa-arrow-circle-right' id='slider-next'></i>
                </div>";
            echo $imagesStr;
            $order = "Add To Cart";
            if($class == "service"){
                $order = "Book Appointment";
            }
            $str = "
                <input type='hidden' id='sid' value='$sid'>
                <form method='post'>
                    <h1>$name</h1>
                    <table>
                        <tr>
                            <td><label>$type</label></td>
                        </tr>
                        <tr>
                            <td>$starsString</td>
                        </tr>
                        <tr>
                            <td colspan='2'><p>$description</p></td>
                        </tr>
                        <tr>
                            <td><h5>Ksh. $price/=</h5></td>
                            <td>";
                        if($label == "Quantity"){
                            $str.="$label : $qty</td>";
                        }else{
                            $str.="<span>Duration: $qty (hrs)</span></td>";
                        }
                        $str.="</tr>
                    </table>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='type' value='$class' id='item-type'>
                    <p><label>Store</label></p>
                    <p><a href='viewStoreInfo.php?store_id=$sid&name=$name'>$sname&nbsp;&nbsp;&nbsp;</a><span><i class='fas fa-phone green-text text-lighten-2'></i>  $sphone</span>
                    <span><p><i class='fas fa-map-marker-alt green-text text-lighten-2'></i> $location</p><p>$ldesc</p></span></p>
                </form>
             </div>
            ";
            echo $str; 
    
        
    }
    
    function getItemComments($id){
        $comments = $this->query("select comment, stars, firstname from db.comments c left join db.user u on u.id = c.user_id where item_id = ?",[$id]);
        
        $commentsDiv = "<div>";
        $set = false;
        if($comments->rowCount() > 0){

            while($row = $comments->fetch()){
                if(!$set){
                    $commentsDiv .= "<label class='col s12'>User Reviews</label>";
                    $set = true;
                }
                $text = $this->encode($row['comment']);
                $stars = $this->encode($row['stars']);
                $fname = $this->encode($row['firstname']);
                $sString = $this->rating($stars, 1, "part");
                
                $commentsDiv .="<div class='col s12 row grey lighten-4 border-radius-1'>
                                    <span class='col s12'>$fname</span>
                                    <span class='col s12'>$sString</span>
                                    <span class='col s12'>$text</span>
                                </div>";
            }
        }
        
        $commentsDiv .= "</div>";
        
        
        return $commentsDiv;
    }
    
    function getItemRating($id){
        $getRating = $this->query("select count(*) as reviewers, sum(stars) as totalStars from db.comments where item_id = ?",[$id]);
        $product = $getRating->fetch();
        $stars = $product['totalStars'];
        $reviewers = $product['reviewers'];
        
        $starsString = $this->rating($stars, $reviewers, "part");
        
        return $starsString;
    }
    
    function getProduct(){
        $id = $_GET['id'];
        $name = $_GET['item_name'];
        $class = $_GET['type'];
        
        $res = $this->query("select p.description, p.price, p.duration, p.category, p.amount, p.type as pType, s.user_id as owner, h.start as hourstart, h.end as hourend, l.start as lunchstart, l.end as lunchend, weekends, holidays, s.id as sid, sm.sstars as nstars, sm.srevs as nrevs, s.name as sname, s.type as stype, s.phone as sphone from db.product p left join db.section s on s.id = p.web_id left join (select SUM(stars) as sstars, COUNT(stars) as srevs , itemId from db.carts where stars > 0 GROUP BY itemId) sm on sm.itemId = p.id left join db.hours h on h.id = s.hours left join db.lunchhours l on l.id = s.lunchbreak where p.id = ?",[$id]);
        
        $product = $res->fetch();
        
        $images = $this->query("select ext,id,num from db.product_images where product_id = ?",[$id]);
        
        $type = $this->encode($product['pType']);
        $price = $this->encode($product['price']);
        $description = $this->encode($product['description']);
        $category = $this->encode($product['category']);
        $owner = $this->encode($product['owner']);
        $hourStart = $this->encode($product['hourstart']);
        $hourEnd = $this->encode($product['hourend']);
        $lunchStart = $this->encode($product['lunchstart']);
        $lunchEnd = $this->encode($product['lunchend']);
        $weekends = $this->encode($product['weekends']);
        $holidays = $this->encode($product['holidays']);
        $sname = $this->encode($product['sname']);
        $stars = $product['nstars'];
        $reviewers = $product['nrevs'];
        $stype = $this->encode($product['stype']);
        $sphone = $this->encode($product['sphone']);
        if($reviewers == ""){
            $reviewers = 0;
        }
        $label = "Duration (hrs)";
        $sid = $this->encode($product['sid']);
        $qty = "";
        $target = "";
        $displayBtn = "initial";
        $starsString = $this->rating($stars, $reviewers, "part");
        if($class=="service"){
            $qty = $this->encode($product['duration']);
            $target = "apt-modal";
        }else{
            $label = "Quantity";
            $qty = $this->encode($product['amount']);
            $target = "order-modal";
        }
        $selectable = "true";
        if($stype == "silver"){
            $selectable = "false";
            $displayBtn = "none";
        }
        $disabled = "";
        if($this->isLoggedIn() && $owner == $_SESSION['id']){
            $disabled = "disabled";
        }
        $imagePath = "";
        $imagesStr = "";
        if($holidays == "national"){
            $res = $this->query("select * from db.holidays where type = ?",['RELIGIOUS']);
        }else if($holidays == "religious"){
            $res = $this->query("select * from db.holidays where type = ?",['NATIONAL']);
        }else if($holidays == "none"){
            $res = $this->query("select * from db.holidays",[]);
        }
        $holidaysArray = "[";
        if($holidays != "both"){
            while($row = $res->fetch()){
                if(strlen($holidaysArray) > 1){
                    $holidaysArray.=",";
                }
                $month = $row['month'];
                $day = $row['day'];
                $holidaysArray.= "{ month: '$month', day: '$day'}";
            }
        }
        $holidaysArray .="]";
        echo "<script>
            var hs = $hourStart;
            var he = $hourEnd;
            var ls = $lunchStart;
            var le = $lunchEnd;
            var h = $holidaysArray;
            var w = '$weekends';
            var d = $qty;
            var selectable = $selectable;
            var now = new Date();
            var lates = new Date();
            lates.setDate(now.getDate() + 21);
            var pid = '$id';
        </script>";
        
        if(isset($_SESSION['id'])){
            echo "<div class='hide' id='loggedIn'>true</div>";
        }else{
            echo "<div class='hide' id='loggedIn'>false</div>";
        }
        
        $specsDiv = $this->getSpecs($id, $category, ($this->isLoggedIn() && $owner == $_SESSION['id'] && $_SESSION['type'] == "tenant"), $selectable);
                
        $commentsDiv = "<div id='item-comments'>".$this->getItemComments($id)."</div>";
        
        $commentsDiv = trim(preg_replace('/\s\s+/',' ',$commentsDiv));
        
        $locationsRes = $this->query("select street, building, stall from db.locations where web_id = ?",[$sid]);
        $locations = "";
        $i = 0;
        while($row = $locationsRes->fetch()){
            $street = $this->encode($row['street']);
            $stall = $this->encode($row['stall']);
            $building = $this->encode($row['building']);
            
            $locations.="<p><i class='fas fa-map-marker-alt green-text text-lighten-2'></i>  $street, $building, $stall</p>";
            $i++;
            if($i >= 5){
                break;
            }
        }
        $commentOption = "";
        if($this->isLoggedIn() && $owner != $_SESSION['id']){
           $commentOption = "<a style='z-index: 5;' href=\"#rate-modal\" class=\"modal-trigger green-text float-right\" onclick =\"rate('$id')\"><i class=\"material-icons\">comment</i></a>"; 
        }
        
        
        if($this->isLoggedIn() && $owner == $_SESSION['id'] && $_SESSION['type'] == "tenant"){
            echo "<script> setComments = false; </script>";
            $imagesStr = "<div class='flex-wrap-center images-admin'> ";
            while($image = $images->fetch()){
                $image_id = $image['num'];
                $img_id = $image['id'];
                $imagePath = "images/products/".$id."_".$image_id.".".$image['ext'];
                $imagesStr.= "<div id='ajax_$img_id'>
                    <form action='backend/Tenants.php' method='post' onsubmit='return validate_remove_image(this, \"$img_id\", \"$imagePath\")'>
                    <input type='hidden' name='id' value='$image_id'>
                    <input type='hidden' name='name' value='$imagePath'>
                    <button type='submit' name='removeImage' class='btn-floating red'><i class='material-icons'>close</i></button>
                    </form>
                    <img src='$imagePath'>
                </div>";
            }
            $imagesStr.="</div>";

            $str = "<h3 class='center-align'>$name</h3>
                <form action='backend/Tenant.php' method='post' onsubmit='return validate_product_change(this,\"$id\",\"$name\",\"$type\")' class='container center-align admin-product'>
                    <table>
                        <tr>
                            <td><label>Name :</label></td>
                            <td><input type='text' name='name' value='$name'></td>
                        </tr>
                        <tr>
                            <td><label>Type :</label></td>
                            <td><input type='text' name='type' value='$type'></td>
                        </tr>
                        <tr>
                            <td><label>$label :</label></td>
                            <td><input type='text' name='qty' value='$qty'></td>
                        </tr>
                        <tr>
                            <td><label>Price :</label></td>
                            <td><input type='number' name='price' value='$price'></td>
                        </tr>
                        <tr>
                            <td><label>Description :</label></td>
                            <td><textarea name='description' class='materialize-textarea'>$description</textarea></td>
                        </tr>
                    </table>
                    <input type='hidden' name='pkg' value='$class'>
                    <p id='prod_error' class='error message'></p>
                    <button type='submit' name='saveProductChanges' class='btn-small green'>Save Changes</button>
                </form>
                <div class='center-align'>
                    <h4>Specifications</h4>
                    <div>
                        <div class='left-align' style='width: auto; margin:auto; display:inline-block' id='specs-div'>
                        $specsDiv
                        <div>
                    </div>
                </div>
                <div class='center-align add-image-form'>
                    <h4>Add Images</h4>
                    <form action='backend/Tenant.php' method='post' enctype='multipart/form-data' class='flex-wrap-center'>
                        <input type='hidden' name='prod_id' value='$id'>
                        <input type='hidden' name='name' value='$name'>
                        <input type='hidden' name='type' value='$class' >
                        <div class='file-field input-field'>
                            <div class='btn-small grey'>
                                <span>Select Image</span>
                                <input type='file' name='files[]' multiple >
                            </div>
                            <div class='file-path-wrapper'>
                                <input class='file-path' type='text' id='image2' placeholder='Upload File'>
                            </div>
                        </div>&nbsp;&nbsp;
                        <button type='submit' name='addImages' class='btn-small green add-btn'>Add</button>
                    </form>
                    <h4>Images</h4>
                </div>
                <div>
                    $imagesStr
                </div>
            ";
            echo $str; 
            
            return "no";
        }
        else{
            
            echo "<script> commentSecond = \"$commentsDiv\"; setComments = true; </script>";
            
            $imagesStr = "
                <h6></h6>
                <div id='product'>
                <div id='image-slider'> <div class='slider-indicator' id='slider-indicator'></div>";
            $ct = 0;
            while($image = $images->fetch()){
                $image_id = $image['num'];
                $img_id = $image['id'];
                $imagePath = "images/products/".$id."_".$image_id.".".$image['ext'];
                    $imagesStr.= "<img src='$imagePath' class='slider-image slider-hide-left'>";   
                
                $ct++;
            }
            $imagesStr.="
                <i class='fas fa-arrow-circle-left' id='slider-prev'></i>
                <i class='fas fa-arrow-circle-right' id='slider-next'></i>
                </div>";
            echo $imagesStr;
            $order = "Add To Cart";
            if($class == "service"){
                $order = "Book Appointment";
            }
            $str = "
                <input type='hidden' id='sid' value='$sid'>
                <form method='post'>
                    <h1>$name</h1>
                    <table>
                        <tr>
                            <td><label>$type</label></td>
                        </tr>
                        <tr>
                            <td><div id='item-rating'>$starsString</div></td>
                        </tr>
                        <tr>
                            <td colspan='2'><p>$description</p></td>
                        </tr>
                        <tr>
                            <td>$specsDiv</td>
                        </tr>
                        <tr>
                            <td><h5>Ksh. $price/=</h5></td>
                            <td>";
                        if($label == "Quantity"){
                            $str.="<span style='display: $displayBtn'>$label : <input name='qty' type='number' max='$qty' min='1' value='1'/ id='item-qty'></span></td>";
                        }else{
                            $str.="<span>Duration: $qty (hrs)</span></td>";
                        }
                        $str.="</tr>
                    </table>
                    <input type='hidden' name='id' value='$id'>
                    <input type='hidden' name='type' value='$class' id='item-type'>
                    <a href='#$target' type='submit' name='order' class='modal-trigger order-btn btn-small green $disabled' id='order-btn' style='display: $displayBtn'>$order</a>
                    <p><label>Store</label></p>
                    <p><a href='viewStoreInfo.php?store_id=$sid&name=$name'>$sname&nbsp;&nbsp;&nbsp;</a><span><i class='fas fa-phone green-text text-lighten-2'></i>  $sphone</span>
                    <span>$locations</span>
                    </p>
                    $commentOption
                </form>
             </div>
            ";
            echo $str; 
    
            return $sid;
        }
    }
    
    function getSpecs($id, $category, $tenant, $selectable){
        $specsDiv = "<span>";
        $link = "";
        if($category == "Shoes"){
            $link = "<a class='modal-trigger' href='#Shoes-modal'><i class='fas fa-edit'></i></a>";
            $specs = $this->query("select number, colors, brand from db.shoes where pid = ?",[$id]);
            $row = $specs->fetch();
            $colors = explode(",",$row['colors']);
            $colorsDiv = "<div> <span style='top: -10px; width:50px; display:inline-block;'>Colors: </span>";
            $setSelected = "";
            if($selectable == "true")
                $setSelected = "selectedSpec";
            for($i = 0; $i < sizeof($colors); $i++){
                $colorsDiv.="<div onclick='selectColor(\"".$colors[$i]."\",this)'class='shadow pointer $setSelected colors-available' style='padding: 2px; margin: 5px; display:inline-block; width: 20px; height:20px;'><div style='background-color: ".$colors[$i]."; width:16px; height:16px;'></div></div>";
                if($setSelected != ""){
                    echo "<script> selectedColor = '".$colors[$i]."';</script>";
                }
                $setSelected = "";
            }
            $colorsDiv.="</div>";
            $specsDiv .= $colorsDiv;
            $sizes = explode(",",$row['number']);
            $numbersDiv = "<div> <span style='width: 50px; display:inline-block;'>Sizes: </span>";
            $setSelected = "";
            if($selectable == "truer")
                $setSelected = "selectedSpec";
            for($i = 0; $i < sizeof($sizes); $i++){
                $numbersDiv.="<div onclick='selectSize(\"".$sizes[$i]."\",this)'class='shadow pointer $setSelected sizes-available' style='padding: 2px; margin: 5px; display:inline-block; width: 20px; height:25px;'><div style='background-color: white; width:16px; height:16px;'>".$sizes[$i]."</div></div>";
                if($setSelected != ""){
                    echo "<script> selectedSize = '".$sizes[$i]."';</script>";
                }
                $setSelected = "";
            }
            $numbersDiv.="</div>";
            $specsDiv.=$numbersDiv;
        }
        else if(strpos($category,"Clothes") !== false){
            $specs = $this->query("select size, colors, brand from db.clothes where pid = ?",[$id]);
            $row = $specs->fetch();
            $colors = explode(",",$row['colors']);
            $colorsDiv = "<div> <span style='top: -10px; width:50px; display:inline-block;'>Colors: </span>";
            $setSelected = "";
            if($selectable == "true")
                $setSelected = "selectedSpec";
            for($i = 0; $i < sizeof($colors); $i++){
                $colorsDiv.="<div onclick='selectColor(\"".$colors[$i]."\",this)'class='shadow pointer $setSelected colors-available' style='padding: 2px; margin: 5px; display:inline-block; width: 20px; height:20px;'><div style='background-color: ".$colors[$i]."; width:16px; height:16px;'></div></div>";
                if($setSelected != ""){
                    echo "<script> selectedColor = '".$colors[$i]."';</script>";
                }
                $setSelected = "";
            }
            $colorsDiv.="</div>";
            $specsDiv .= $colorsDiv;
            $sizes = explode(",",$row['size']);
            $numbersDiv = "<div> <span style='width: 50px; display:inline-block;'>Sizes: </span>";
            $setSelected = "";
            if($selectable == "truer")
                $setSelected = "selectedSpec";
            for($i = 0; $i < sizeof($sizes); $i++){
                $numbersDiv.="<div onclick='selectSize(\"".$sizes[$i]."\",this)'class='shadow pointer $setSelected sizes-available' style='padding: 2px; margin: 5px; display:inline-block; width: 20px; height:25px;'><div style='background-color: white; width:16px; height:16px;'>".$sizes[$i]."</div></div>";
                if($setSelected != ""){
                    echo "<script> selectedSize = '".$sizes[$i]."';</script>";
                }
                $setSelected = "";
            }
            $numbersDiv.="</div>";
            $specsDiv.=$numbersDiv;
        }
        else if(strpos($category,"Televisions") !== false){
            $specs = $this->query("select make, model, inches, display from db.televisions where pid = ?",[$id]);
            $row = $specs->fetch();
            $make = $this->encode($row['make']);
            $model = $this->encode($row['model']);
            $inches = $this->encode($row['inches']);
            $display = $this->encode($row['display']);
            $specsDiv.="<table>
                        <tr>
                            <th>Make</th>
                            <td>$make</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>$model</td>
                        </tr>
                        <tr>
                            <th>Screen Size</th>
                            <td>$inches inches</td>
                        </tr>
                        <tr>
                            <th>Display</th>
                            <td>$display</td>
                        </tr>
                    </table>";
        }
        else if(strpos($category,"Computers") !== false){
            $specs = $this->query("select make, model, screenSize, ram, storage, processorType, processorSpeed from db.computers where pid = ?",[$id]);
            $row = $specs->fetch();
            $make = $this->encode($row['make']);
            $model = $this->encode($row['model']);
            $inches = $this->encode($row['screenSize']);
            $storage = $this->encode($row['storage']);
            $memory = $this->encode($row['ram']);
            $pspeed = $this->encode($row['processorSpeed']);
            $ptype = $this->encode($row['processorType']);
            $specsDiv.="<table>
                        <tr>
                            <th>Make</th>
                            <td>$make</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>$model</td>
                        </tr>
                        <tr>
                            <th>Screen Size</th>
                            <td>$inches inches</td>
                        </tr>
                        <tr>
                            <th>Memory</th>
                            <td>$memory</td>
                        </tr>
                        <tr>
                            <th>Storage</th>
                            <td>$storage</td>
                        </tr>
                        <tr>
                            <th>Processor Type</th>
                            <td>$ptype</td>
                        </tr>
                        <tr>
                            <th>Processor Speed</th>
                            <td>$pspeed</td>
                        </tr>
                    </table>";
        }
        else if(strpos($category,"Phones") !== false){
            $specs = $this->query("select make, model, screenSize, ram, storage, frontCamera, backCamera, batteryCapacity from db.phones where pid = ?",[$id]);
            $row = $specs->fetch();
            $make = $this->encode($row['make']);
            $model = $this->encode($row['model']);
            $inches = $this->encode($row['screenSize']);
            $storage = $this->encode($row['storage']);
            $memory = $this->encode($row['ram']);
            $fcamera = $this->encode($row['frontCamera']);
            $bcamera = $this->encode($row['backCamera']);
            $bcapacity = $this->encode($row['batteryCapacity']);
            $specsDiv.="<table>
                        <tr>
                            <th>Make</th>
                            <td>$make</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>$model</td>
                        </tr>
                        <tr>
                            <th>Screen Size</th>
                            <td>$inches inches</td>
                        </tr>
                        <tr>
                            <th>Memory</th>
                            <td>$memory</td>
                        </tr>
                        <tr>
                            <th>Storage</th>
                            <td>$storage</td>
                        </tr>
                        <tr>
                            <th>Front Camera</th>
                            <td>$fcamera</td>
                        </tr>
                        <tr>
                            <th>Back Camera</th>
                            <td>$bcamera</td>
                        </tr>
                        <tr>
                            <th>Battery Capacity</th>
                            <td>$bcapacity</td>
                        </tr>
                    </table>";
        }
        
        if($tenant){
            $specsDiv.=$link;
        }
        $specsDiv.="</span>";
        return $specsDiv;
    }
    
    function getPickUpLocations(){
        $id = $_GET['id'];
        
        $res = $this->query("select l.id, l.street, l.building, l.stall from db.Locations l left join db.section s on s.id = l.web_id inner join db.product p on p.web_id = s.id where p.id = ?",[$id]);
        $str = "";
        while($row = $res->fetch()){
            $lid = $row['id'];
            $street = $this->encode($row['street']);
            $building = $this->encode($row['building']);
            $stall = $this->encode($row['stall']);
            $str .= "<option value='$lid'>$street, $building, $stall <br/> description</option>";
        }
        echo $str;
    }
    
    function getProductListing(){
        $id = $_GET['id'];
        
        $res = $this->query("select * from db.product_listing where web_id = ? ",[$id]);
        
        $str = "<div class='section'>";
        $int = 1;
        while($row = $res->fetch()){
            $def = $this->encode($row['listing']);
            $l_id = $this->encode($row['id']);
            $title = $this->encode($row['title']);
            $ext = $this->encode($row['ext']);
            $img = $l_id.".".$ext;
            $str.= "<div class='row' id='product-listing-$l_id'>
                        <div class='col s3'><img src='images/features/$img' style='width:100%; max-with: 150px; height: 200px;'> </div>
                        <div class='col s2'>$title </div>
                        <div class='col s6'>$def</div>
                        <div class='s1'>
                            <form action='backend/Tenant.php' method='post' onsubmit = 'return validate_delete_product_listing(this, \"$l_id\")'>
                                <input type='hidden' name='id' value='$id'>
                                <button type='submit' name='deleteProductListing' class='transparent red-text'><i class='fas fa-trash-alt'></i></button>
                            </form>
                        </div>
                </div>";
            $int++;
        }
        $str.= "</div>";
        
        echo $str;
    }
    
    function getProfile(){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select * from db.User where id = ?",[$id]);
        
        $row = $res->fetch();
        
        $fname = $this->encode($row['firstname']);
        $lname = $this->encode($row['lastname']);
        $email = $this->encode($row['email']);
        $phone = $this->encode($row['phone']);
        $idnum = $this->encode($row['id_number']);
        $ext = $this->encode($row['ext']);
        $img = "images/users/";
        
        $table = "<table>
                    <tr>
                        <td><label>First name :</label></td>
                        <td>$fname</td>
                        <td><a href='#divFname' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>Last name :</label></td>
                        <td>$lname</td>
                        <td><a href='#divLname' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>Email :</label></td>
                        <td>$email</td>
                        <td><a href='#divEmail' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>Phone :</label></td>
                        <td>$phone</td>
                        <td><a href='#divPhone' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>ID Number :</label></td>
                        <td>$idnum</td>
                        <td><a href='#divIdnum' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>Password</label></td>
                        <td><a href='#divPassword' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                </table>";
        
        if($ext == "" || $ext == NULL){
            $img .= "default.png";
        }else{
            $img .= $id.".".$ext;
        }
        if(!file_exists("../".$img)){
            $img = "images/users/default.png";
        }
        $str = "<div class='row'>
                    <div class='col s12 m4 flex-center vertical-wrapper'> <img src='$img'/><a href='#divImage' class='modal-trigger'><i class='fas fa-edit'></i></a></div>
                    <div class='col s12 m8'>".$table."</div>
                    </div>";
        echo $str;
    }
    
    function getLocations(){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $id = $_GET['id'];
        
        $res = $this->query("select * from db.locations where web_id = ?",[$id]);
        
        while($row = $res->fetch()){
            $i = $row['id'];
            
            $this->getLocation($i);
        }
    }
    
    function rating($stars, $reviewers, $type){
        $starsString = "<div class='star-rating hide-on-small-only'>";
        $starsStringXs = "<div class='star-rating xs hide-on-med-and-up'>";
        if($reviewers > 0)
            $rating = $stars/$reviewers;
        else
            $rating = 0;
        $starsSet = 0;
        for(; $starsSet < $rating; $starsSet++){
            if($rating - $starsSet >= 1){
                $starsString.="<i class='material-icons yellow-text'>star</i>";
                $starsStringXs.="<i class='material-icons yellow-text'>star</i>";   
            }
        }
        $diff = $starsSet - $rating;
        if($starsSet > $rating){
            if($diff < 0.3){
                $starsString.="<i class='material-icons yellow-text'>star</i>";
                $starsStringXs.="<i class='material-icons yellow-text'>star</i>";
            }else if($diff < 0.7){
                $starsString.="<i class='material-icons yellow-text'>star_half</i>";
                $starsStringXs.="<i class='material-icons yellow-text'>star_half</i>";
            }else{
                $starsString.="<i class='material-icons grey-text'>star_border</i>";
                $starsStringXs.="<i class='material-icons grey-text'>star_border</i>";
            }   
        }
        for(; $starsSet < 5; $starsSet++){
            $starsString.="<i class='material-icons grey-text'>star_border</i>";
            $starsStringXs.="<i class='material-icons grey-text'>star_border</i>";
        }
        
        if($type == "full"){
            $starsString.=" <span>($reviewers)</span> </div>";
            $starsStringXs.=" <span>($reviewers)</span> </div>";
        }else{
            $starsString.="</div>";
            $starsStringXs.="</div>";
        }
        return $starsString.$starsStringXs;   
    }
    
    function getList($pageFrom, $reqsrc){
        $page = 1;
        $limit = 30;
        if(isset($_GET['filter']) || isset($_GET['filter_reset'])){
            unset($_SESSION['filter_store']);
            unset($_SESSION['filter_product']);
            unset($_SESSION['filter_service']);
            unset($_SESSION['filter_from']);
            unset($_SESSION['filter_to']);
            unset($_SESSION['filter_category']);
            unset($_SESSION['filter_search']);
        }

        $store = "on";
        if(isset($_SESSION['filter_store']))
            $store = $_SESSION['filter_store'];
        if(isset($_GET['f_stores']))
            $store = $_GET['f_stores'];
        else if(isset($_GET['filter']))
            $store = "";
        else if(isset($_GET['filter_reset']))
            $store = "on";
        $_SESSION['filter_store'] = $store;
        
        
        $product = "on";
        if(isset($_SESSION['filter_product']))
            $product = $_SESSION['filter_product'];
        if(isset($_GET['f_product']))
            $product = $_GET['f_product'];
        else if(isset($_GET['filter']))
            $product = "";
        else if(isset($_GET['filter_reset']))
            $product = "on";
        $_SESSION['filter_product'] = $product;   
        
        
        $service = "on";
        if(isset($_SESSION['filter_service']))
            $service = $_SESSION['filter_service'];
        if(isset($_GET['f_service']))
            $service = $_GET['f_service'];
        else if(isset($_GET['filter'])){
            $service = "";
        }else if(isset($_GET['filter_reset']))
            $service = "on";
        $_SESSION['filter_service'] = $service;
        
        $price_from = 0;
        if(isset($_SESSION['filter_from']))
            $price_from = $_SESSION['filter_from'];
        if(isset($_GET['f_from']))
            $from = $_GET['f_from'];
        else if(isset($_GET['filter_reset']))
            $price_from = 0;
        $_SESSION['filter_from'] = $price_from;
        
        $price_to = 100000;
        if(isset($_SESSION['filter_to']))
            $price_to = $_SESSION['filter_to'];
        if(isset($_GET['f_to']))
            $price_to = $_GET['f_to'];
        else if(isset($_GET['filter_reset']))
            $price_to = 100000;
        $_SESSION['filter_to'] = $price_to;
        
        $category = "";
        if(isset($_SESSION['filter_category']))
            $category = $_SESSION['filter_category'];
        if(isset($_GET['f_category']))
            $category = $_GET['f_category'];
        if($category == "All Categories" || isset($_GET['filter_reset']))
            $category = "";
        $_SESSION['filter_category'] = $category;
        
        $search = "";
        if(isset($_SESSION['filter_search']))
            $search = $_SESSION['filter_search'];
        $search_items = [];
        if(isset($_GET['page'])){
            $page = $_GET['page'];
            if($page < 1){
                $page = 1;
            }
        }
        if(isset($_GET['search'])){
            $search = $_GET['search'];
            $search_items = explode(" ",$search);
        }    
        $_SESSION['filter_search'] = $search;
        
        $fetch_query = "";
        $array_to_send = [];
        
        if(sizeof($search_items) > 1){
            for($i = 0; $i < sizeof($search_items); $i++){
                if($i == 0){
                    $fetch_query .= " ( search like ?";
                }else{
                    $fetch_query .= " OR search like ?";   
                }
                $item = $search_items[$i];
                array_push($array_to_send, "%$item%");
            }
        }else{
            $fetch_query = " ( p.search like ?";
            $array_to_send = ["%$search%"];
        }
        $fetch_query .= " ) "; 
        $displayProducts = true;
        if($service == "on" && $product == "on"){
            $fetch_query .= " AND s.type like ? ";
            array_push($array_to_send, "%%");
        }else if($service == "on"){
            $fetch_query .= " AND s.type = ?";
            array_push($array_to_send, "gold");
        }else if($product == "on"){
            $fetch_query .= " AND (s.type = ? OR s.type = ?)"; 
            array_push($array_to_send, "silver");
            array_push($array_to_send, "platinum");
        }else{
            $displayProducts = false;
        }
        echo "
            <script>
                var store = '$store';
                var product = '$product';
                var service = '$service';
                var category = '$category';
                var from = '$price_from';
                var to = '$price_to';
                var search = '$search';
            </script>
        ";
        $fetch_query .= " AND category like ?";
        array_push($array_to_send, "%$category%");
        
        $fetch_query .= " AND price > ?";
        array_push($array_to_send, $price_from);
        
        $fetch_query .= " AND price < ?";
        array_push($array_to_send, $price_to);
        
        $fetch_query .= " AND p.status = ?";
        array_push($array_to_send, "ACTIVE");
        
        $offset = ($page - 1) * $limit;
        $itemsFound = 0;
        
        if($store == "on" && $reqsrc == "search"){
            $store_array = $array_to_send;
            array_push($store_array, $search);
            array_push($store_array, $search);
            array_push($store_array, "APPROVED");
            $res = $this->query("select s.id, s.name, s.description, s.ext, s.type, number_of_stars, number_of_reviewers from db.section s left join db.product_listing pl on s.id = pl.web_id left join product p on p.web_id = s.id where (($fetch_query) || s.description like ? || pl.listing like ?) AND s.status = ?  AND s.admin_verified = 1 AND s.paid != 'NOT PAID' group by s.id LIMIT $limit OFFSET $offset ", $store_array);
            while($row = $res->fetch()){
                $itemsFound++;
                $s_id = $this->encode($row['id']);
                $s_name = $this->encode($row['name']);
                $s_desc = $this->encode($row['description']);
                $s_ext = $this->encode($row['ext']);
                $src = "images/sections/$s_id.$s_ext";
                $pkg = $this->encode($row['type']);
                $stars = $row['number_of_stars'];
                $reviewers = $row['number_of_reviewers'];
                $aboutUrl = "viewStoreInfo.php?store_id=$s_id&name=$s_name";
                $productsUrl = "viewproducts.php?store_id=$s_id&name=$s_name";
                $following = "";
                if($this->isLoggedIn()){
                    $following = $this->getFollowing($_SESSION['id'], $s_id, "text");   
                }
                if($pkg == "bronze"){
                    $productsUrl = $aboutUrl;
                }
                $starsString = $this->rating($stars, $reviewers, "full");
                $str = "<div class='row store-div' onclick='goTo(\"$productsUrl\")'>
                            <img src='$src' class='s hide-on-small-only float-left'>
                            <img src='$src' class='xs hide-on-med-and-up float-left'>
                            <div class='store-info'>
                                <p>$following&nbsp;$s_name</p>
                                <p>$starsString</p>
                                <p class='s hide-on-small-only'>$s_desc</p>
                                <p class='xs hide-on-med-and-up'>$s_desc</p>
                                <div class='fade-in-abs-bottom-right right-align'><a href='$aboutUrl'>More</a></div>
                            </div>
                        </div>";
                
                echo $str;
            }
        }
        
        //echo $fetch_query."<br>";
        //print_r($array_to_send);
        
        $result = $this->query("SELECT count(p.id) as num FROM db.product p, db.section s WHERE ($fetch_query)",$array_to_send);
        $row = $result->fetch();
        $total = $row['num'];
        
        $totalPages = round($total/$limit);
        if($page > ($totalPages) && $page > 1){
            $page = $totalPages - 1;
        }
        
        $result = null;
        if($reqsrc == "search"){
            $result = $this->query("SELECT s.name as sname, p.classification as ptype, im.ext, num, amount, duration, p.price, p.name, p.id as itemId, s.id as store_id, p.type as prod_type FROM db.product p inner join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id WHERE ($fetch_query) AND s.admin_verified = 1 AND s.paid != 'NOT PAID' ORDER BY p.id DESC LIMIT $limit OFFSET $offset ", $array_to_send);   
        }else if($reqsrc == "store"){
            $sid = $_GET['store_id'];
            $displayProducts = true;
            $result = $this->query("SELECT s.name as sname, p.classification as ptype, im.ext, num, amount, duration, p.price, p.name, p.id as itemId, s.id as store_id, p.type as prod_type, s.type as stype, s.user_id as sowner FROM db.product p inner join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id WHERE s.id = ? AND p.status = ? AND s.admin_verified = 1 AND s.paid != 'NOT PAID' ORDER BY p.id DESC LIMIT $limit OFFSET $offset ", [$sid, "ACTIVE"]);
        }
        
        echo "<div class='contents products flex-wrap-center'>"; 
        if($result->rowCount() == 0){
            echo "<center style='padding:30px;'><p>No match was found</p></center>";
        }
        $itemsFound+=$result->rowCount();
            
        
        //*****************************************************************************************************************
        
        
        if($displayProducts){
            if($reqsrc == "search"){
                $this->formatProduct($result, "list");   
            }else if($reqsrc == "store"){
                $this->formatProduct($result, "store");
            }
        }
        
        //*****************************************************************************************************************
        
        while($row = $result->fetch()){
            

        }
        echo "</div>";
        
        $sname = "";
        $sid = "";
        
        if(isset($_GET['store_id'])){
            $sid = $_GET['store_id'];
            $sname = $_GET['name'];
        }
        
        $displayPage = $page;
        $next = $page + 1;
        $prev = $page - 1;
        
        if(isset($_GET['search'])){
            $s = $_GET['search'];
            echo "<script>document.getElementById('search_field').value = '$s'</script>";
        }
        
        $curr_page = "<p>Page $displayPage</p>";
        echo "<center id='page_nav'>";
        if($total > ($offset + $limit) && $offset > 0 && $itemsFound > 0 && $total > ($offset + $limit)){
            echo "<form action='$pageFrom' method='get'>
                    <input type='hidden' name='name' value='$sname'>
                    <input type='hidden' name='store_id' value='$sid'>
                    <input type='hidden' name='page' value='$prev'>
                    <input type='submit' value='<'>
                  </form> 
                     $curr_page 
                  <form action='$pageFrom' method='get'>
                      <input type='hidden' name='name' value='$sname'>
                      <input type='hidden' name='store_id' value='$sid'>
                      <input type='hidden' name='page' value='$next'>
                      <input type='submit' value='>'>
                  </form>";
        }else if($total > ($offset + $limit) && $offset == 0 && $itemsFound > 0){
            echo "$curr_page 
                    <form action='$pageFrom' method='get'>
                      <input type='hidden' name='name' value='$sname'>
                      <input type='hidden' name='store_id' value='$sid'>
                      <input type='hidden' name='page' value='$next'>
                      <input type='submit' value='>'>
                  </form>";
        }else if(($total <= ($offset + $limit) && $offset > 0) || $itemsFound <= 0){
             echo "<form action='$pageFrom' method='get'>
                    <input type='hidden' name='name' value='$sname'>
                    <input type='hidden' name='store_id' value='$sid'>
                    <input type='hidden' name='page' value='$prev'>
                    <input type='submit' value='<'>
                  </form>
                    $curr_page";
        }else{
            echo "$curr_page";
        }
        echo "</center>";
    }
    
    function getStore(){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $id = $_GET['id'];
        $res = $this->query("select * from db.section where id = ?",[$id]);
        
        $row = $res->fetch();
        
        $name = $this->encode($row['name']);
        $type = $this->encode($row['type']);
        $email = $this->encode($row['email']);
        $phone = $this->encode($row['phone']);
        $description = $this->encode($row['description']);
        $img_ext = $this->encode($row['ext']);
        $website = $this->encode($row['website']);
        echo "<input type='hidden' id='store_id' value='$id'>";
        $image_path = $id.".".$img_ext;
        $image = "<img src='images/sections/$image_path' alt = 'Image'><a href='#divSimage' class='modal-trigger'><i class='fas fa-edit'></i></a> ";
        echo $image;
        $table = "<table>
                    <tr>
                        <td><label>Store Name :</label></td>
                        <td>$name</td>
                        <td>
                        <a href='#divSname' class='modal-trigger'><i class='fas fa-edit'></i></a></td>
                    </tr>
                    <tr>
                        <td><label>Store Type :</label></td>
                        <td>$type</td>
                        <td>
                        <a href='#divStype' class='modal-trigger'><i class='fas fa-edit'></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Store Email :</label></td>
                        <td>$email</td>
                        <td>
                        <a href='#divSemail' class='modal-trigger'><i class='fas fa-edit'></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Store Phone :</label></td>
                        <td>$phone</td>
                        <td>
                        <a href='#divSphone' class='modal-trigger'><i class='fas fa-edit'></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>External website :</label></td>
                        <td><a href='$website'>$website</a></td>
                        <td>
                        <a href='#divSwebsite' class='modal-trigger'><i class='fas fa-edit'></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Description :</label></td>
                        <td>$description</td>
                        <td>
                        <a href='#divDesc' class='modal-trigger'><i class='fas fa-edit'></i></a>
                        </td>
                    </tr>
                </table>";
        echo $table;
    }
    
    function getCart(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "PENDING": "'.$mess.'",
                    "DELIVERY": "'.$mess.'",
                    "PICKUP": "'.$mess.'",
                    "COMPLETE": "'.$mess.'",
                    "CANCELLED": "'.$mess.'"
                    }'; 
            
            echo $out;   
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, c.quantity as qty, p.price as productPrice, c.id as cartId, s.name as storeName, s.phone as storePhone, p.procurement as method, c.status as itemStatus, s.id as storeId, c.ordered as orderDate, c.received as receiveDate, l.building as aBuilding, l.street as aStreet, l.stall as aStall, c.stars as cstars from db.carts c left join db.product p on c.itemId = p.id left join db.section s on p.web_id = s.id left join db.user u on u.id = s.user_id left join (select ext,product_id from db.product_images group by product_id) im on im.product_id = p.id left join db.locations l on c.locationId = l.id where c.userId = ? ", [$id]);
        $pending = '';
        $delivery = '';
        $pickup = '';
        $complete = '';
        $cancelled ='';
        $ct_de = 0;
        $ct_pi = 0;
        $ct_co = 0;
        $ct_ca = 0;
        $ct_pe = 0;
        while($row = $res->fetch()){
            $img = $this->encode("images/products/".$row['imgName']."_0.".$row['extension']);
            $name = $this->encode($row['prodName']);
            $amt = $row['qty'];
            $totalCost = $amt * $row['productPrice'];
            $phone = $this->encode($row['storePhone']);
            $storeName = $this->encode($row['storeName']);
            $method = $this->encode($row['method']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $cartId = $row['cartId'];
            $status = $row['itemStatus'];
            $storeId = $row['storeId'];
            $orderDate = $this->formatDate($row['orderDate']);
            $receiveDate = $row['receiveDate'];
            $cstars = $row['cstars'];
            $date = "";
            $button = "";
            if($status == "PENDING"){
                $button = '<button onclick=\"remove_cart_item(\''.$cartId.'\")\" class=\"btn-small red float-right\"><i class=\"fas fa-trash-alt\"></i></button>
                        <button onclick = \"setPaymentDetails(\''.$cartId.'\',\''.$totalCost.'\')\" class=\"btn-small green\"><a class=\"modal-trigger white-text\" href=\"#payment-modal\">Confirm</a></button>';
            }else if($status == "PICK UP" || $status == "DELIVERY"){
                $date = "<label>Ordered on: $orderDate</label>";
                $button = '<button onclick = \"rate(\''.$cartId.'\')\" class=\"btn-small green\"><a href=\"#rate-modal\" class=\"modal-trigger white-text\">Received</a></button>';
            }else if($status != "CANCELLED"){
                $date = "<label>Ordered on: $orderDate</label>";
                $button = $this->rating($cstars,1, "part");
            }else{
                $button = "CANCELLED";
            }
            
            $str = '
                <div id=\"cart-'.$cartId.'\">
                    <div class=\"row cart_item section hide-on-xs\" id=\"cart-'.$cartId.'\">
                            <img src=\"'.$img.'\" class=\"col s4 l3\">
                            <div class=\"row container left-align col s8 l9\">
                                <div class=\"col l12 s12\">'.$name.'</div>
                                <div class=\"col l4\">'.$amt.'</div>
                                <div class=\"col l8\">Ksh '.$totalCost.'</div>
                                <div class=\"col s12\">'.$date.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"ol s12\">Store Information</label>
                                <div class=\"col l12 s12\">'.$storeName.'</div>
                                <div class=\"col l12 s12\">'.$phone.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Store Location</label>
                                <div class=\"col s12\">'.$location.'</div>
                                <span class=\"divider col s12\"></span>
                                <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>'.
                        '<div class=\"row cart_item section show-on-xs\">
                            <img src=\"$img\" class=\"col s12 l3\">
                            <div class=\"row container left-align col s12 l9\">
                                <div class=\"col l12 s12\">'.$name.'</div>
                                <div class=\"col l4\"> '.$amt.'</div>
                                <div class=\"col l8\">Ksh '.$totalCost.'</div>
                                <div class=\"col s12\">'.$date.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Store Information</label>
                                <div class=\"col l12 s12\">'.$storeName.'</div>
                                <div class=\"col l12 s12\">'.$phone.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Store Location</label>
                                <div class=\"col s12\">'.$location.'</div>
                                <span class=\"divider col s12\"></span>
                                <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>
                    </div>';
            if($status == "PENDING"){
                $pending.=$str;
                $ct_pe++;
            }else if($status == "COMPLETE"){
                $complete.=$str;
                $ct_co++;
            }else if($status == "CANCELLED"){
                $cancelled.=$str;
                $ct_ca++;
            }else if($method == "PICK UP"){
                $pickup.=$str;
                $ct_pi++;
            }else if($method == "DELIVERY"){
                $delivery.=$str;
                $ct_de++;
            }
        }
        $pending = trim(preg_replace('/\s\s+/',' ',$pending));
        $delivery = trim(preg_replace('/\s\s+/',' ',$delivery));
        $pickup = trim(preg_replace('/\s\s+/',' ',$pickup));
        $complete = trim(preg_replace('/\s\s+/',' ',$complete));
        $cancelled = trim(preg_replace('/\s\s+/',' ',$cancelled));
        
        $out = '{ "PENDING": "'.$pending.'",
                    "DELIVERY": "'.$delivery.'",
                    "PICKUP": "'.$pickup.'",
                    "COMPLETE": "'.$complete.'",
                    "CANCELLED": "'.$cancelled.'"
                    }'; 
        echo $out;
    }
    
    function getNewArrivals(){
        $result = $this->query("SELECT s.name as sname, p.classification as ptype, im.ext, num, amount, duration, p.price, p.name, p.id as itemId, s.id as store_id, p.type as prod_type FROM db.product p inner join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id where s.admin_verified = 1 AND s.paid = 'PAID' ORDER BY p.id DESC LIMIT 3", []); 
        
        echo "<div class='contents products flex-wrap-center'>"; 
        
        $this->formatProduct($result, "list");
        
        echo "</div>";
    }
    
    function getPopularStores(){
        $res = $this->query("select s.id, s.name, s.description, s.ext, s.type, number_of_stars, number_of_reviewers, count(s.id) as pnum FROM (select itemId from db.carts union select itemId from db.appointments) c left join db.product p on p.id = c.itemId left join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id where s.admin_verified = 1 AND s.paid != 'NOT PAID'  GROUP BY s.id ORDER BY pnum DESC LIMIT 3",[]);
        
        $ct = 0;
        while($row = $res->fetch()){
            $s_id = $this->encode($row['id']);
            $s_name = $this->encode($row['name']);
            $s_desc = $this->encode($row['description']);
            $s_ext = $this->encode($row['ext']);
            $src = "images/sections/$s_id.$s_ext";
            $pkg = $this->encode($row['type']);
            $stars = $row['number_of_stars'];
            $reviewers = $row['number_of_reviewers'];
            $aboutUrl = "viewStoreInfo.php?store_id=$s_id&name=$s_name";
            $productsUrl = "viewproducts.php?store_id=$s_id&name=$s_name";
            if($pkg == "bronze"){
                $productsUrl = $aboutUrl;
            }
            $starsString = $this->rating($stars, $reviewers, "part");
            $str = "<div class='row store-div'>
                        <img src='$src' class='clickable s hide-on-small-only float-left' onclick='goTo(\"$productsUrl\")'>
                        <img src='$src' class='clickable xs hide-on-med-and-up float-left' onclick='goTo(\"$productsUrl\")'>

                            <div class='store-info'>
                                <p class='clickable'onclick='goTo(\"$productsUrl\")'>$s_name</p>
                                <p>$starsString</p>
                                <p class='s hide-on-small-only'>$s_desc</p>
                                <p class='xs hide-on-med-and-up'>$s_desc</p>
                                <div class='fade-in-abs-bottom-right right-align'><a href='$aboutUrl'>More</a></div>
                            </div>
                    </div>";
            if($ct == 1){
                $str = "<div class='row store-div'>
                        <div class='col s6 m7 l9 store-info' style='padding-left: 0px;'>
                            <p class='clickable'onclick='goTo(\"$productsUrl\")'>$s_name</p>
                            <p>$starsString</p>
                            <p class='s hide-on-small-only' >$s_desc </p>
                            <p class='xs hide-on-med-and-up'>$s_desc</p>
                            <div class='fade-in-abs-bottom-right right-align'><a href='$aboutUrl'>More</a></div>
                        </div>
                        <img src='$src' class='clickable s hide-on-small-only float-left' onclick='goTo(\"$productsUrl\")'>
                        <img src='$src' class='clickable xs hide-on-med-and-up float-left' onclick='goTo(\"$productsUrl\")'>
                    </div>";
            }
            $ct++;
            echo $str;
        }
    }
    
    function getBestSellers(){
        $result = $this->query("SELECT s.name as sname, p.classification as ptype, im.ext, num, amount, duration, p.price, p.name, p.id as itemId, s.id as store_id, p.type as prod_type , count(c.itemId) as pnum FROM (select itemId from db.carts union select itemId from db.appointments) c left join db.product p on p.id = c.itemId left join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id where s.admin_verified = 1 AND s.paid != 'NOT PAID'  GROUP BY p.id ORDER BY pnum DESC LIMIT 3", []); 
        
        echo "<div class='contents products flex-wrap-center'>"; 
        
        $this->formatProduct($result, "list");
        
        echo "</div>";
    }
    
    function getStoreBestSellers($sid){
        $result = $this->query("SELECT s.name as sname, p.classification as ptype, im.ext, num, amount, duration, p.price, p.name, p.id as itemId, s.id as store_id, p.type as prod_type , count(c.itemId) as pnum FROM (select itemId from db.appointments union select itemId from db.carts) c right join db.product p on p.id = c.itemId left join db.section s on p.web_id = s.id left join (select * from db.product_images group by product_id) as im on p.id = im.product_id where s.id = ? GROUP BY p.id ORDER BY pnum DESC LIMIT 3", [$sid]); 
                
        echo "<div class='contents products flex-wrap-center'>"; 
        $this->formatProduct($result, "list");
        
        echo "</div>";
    }
    
    function getAppointments(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "UPCOMING": "'.$mess.'",
                    "PAST": "'.$mess.'",
                    "CANCELLED": "'.$mess.'"
                }';
            
            echo $out; 
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, p.price as productPrice, a.id as aptId, s.name as storeName, s.phone as storePhone, a.status as itemStatus, s.id as storeId, a.start as aptFrom, a.end as aptTo, a.day as aptDay, l.building as aBuilding, l.street as aStreet, l.stall as aStall, ln.start as ls, ln.end as le, hr.start as hs, hr.end as he, p.duration as d, a.stars as astars from db.appointments a left join db.product p on a.itemId = p.id left join db.section s on p.web_id = s.id left join db.user u on u.id = s.user_id left join (select ext,product_id from product_images group by product_id) im on im.product_id = p.id left join db.locations l on a.locationId = l.id left join db.lunchhours ln on ln.id = s.lunchbreak left join db.hours hr on hr.id = s.hours where a.userId = ? ", [$id]);
        $upcoming = '';
        $past = '';
        $cancelled ='';
        $ct_up = 0;
        $ct_pa = 0;
        $ct_ca = 0;
    
        while($row = $res->fetch()){
            $iid = $row['imgName'];
            $img = $this->encode("images/products/".$row['imgName']."_0.".$row['extension']);
            $name = $this->encode($row['prodName']);
            $totalCost = $row['productPrice'];
            $phone = $this->encode($row['storePhone']);
            $storeName = $this->encode($row['storeName']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $aptId = $row['aptId'];
            $status = $row['itemStatus'];
            $storeId = $row['storeId'];
            $from = $this->formatTime($row['aptFrom']);
            $to = $this->formatTime($row['aptTo']);
            $date = $this->formatDate($row['aptDay']);
            $hs = $row['hs'];
            $he = $row['he'];
            $ls = $row['ls'];
            $le = $row['le'];
            $d = $row['d'];
            $astars = $row['astars'];
            $button = "";
            if($status == "PENDING"){
                $button = '<button onclick=\"remove_apt_item(\''.$aptId.'\')\" class=\"btn-small green\">Cancel</button>
                        <button onclick = \"reschedule_apt(\''.$aptId.'\', \''.$iid.'\', \''.$hs.'\', \''.$he.'\', \''.$ls.'\', \''.$le.'\', \''.$d.'\')\" class=\"btn-small green\"><a href=\"#reschedule-modal\" class=\"modal-trigger white-text\">Reschedule</a></button>';
            }else if($status == "RATE"){
                $button = '<button onclick = \"rate(\''.$aptId.'\')\" class=\"btn-small green\"><a href=\"#rate-modal\" class=\"modal-trigger white-text\">Received</a></button>';
            }else if($status == "CANCELLED"){
                $button = "CANCELLED";
            }else if($astars > 0){
                $str = $this->rating($astars, 1, "part");
                $button = $str;
            }else{
                $button = "MISSED";
            }
            
            $str = '
                <div id=\"apt-'.$aptId.'\">
                    <div class=\"apt_item row section hide-on-xs\">
                            <img src=\"'.$img.'\" class=\"col s4 l3\">
                            <div class=\"col s8 l9 container row left-align\">
                                    <div class=\"col s8\">'.$name.'</div><div class=\"col s4\">'.$totalCost.'</div>
                                    <div class=\"col s12\">'.$date.' : '.$from.' - '.$to.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Store Information</label>
                                    <div class=\"col s6\">'.$storeName.'</div>
                                    <div class=\"col s6\">'.$phone.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Location</label>
                                    <div class=\"col s12\">'.$location.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>'.
                        '<div class=\"apt_item row section show-on-xs\">
                            <img src=\"'.$img.'\" class=\"col s12 m4 l3\">
                            <div class=\"col s12 m8 l9 container row left-align\">
                                    <div class=\"col s8\">'.$name.'</div><div class=\"col s4\">'.$totalCost.'</div>
                                    <div class=\"col s12\">'.$date.' : '.$from.' - '.$to.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Store Information</label>
                                    <div class=\"col s6\">'.$storeName.'</div>
                                    <div class=\"col s6\">'.$phone.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Location</label>
                                    <div class=\"col s12\">'.$location.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>
                    </div>';
            if($status == "PENDING"){
                $upcoming.=$str;
                $ct_up++;
            }else if($status == "CANCELLED"){
                $cancelled.=$str;
                $ct_ca++;
            }else{
                $past.=$str;
                $ct_pa++;
            }
        }
        
        $upcoming = trim(preg_replace('/\s\s+/',' ',$upcoming));
        $past = trim(preg_replace('/\s\s+/',' ',$past));
        $cancelled = trim(preg_replace('/\s\s+/',' ',$cancelled));
        $out = '{ "UPCOMING": "'.$upcoming.'",
                    "PAST": "'.$past.'",
                    "CANCELLED": "'.$cancelled.'"
                }';
        echo $out;
    }
    
    function formatProduct($result, $ftype){
        $storeSet = false;
        $sowner = -1;
        $showDeleteBtn = "none";
        while($row=$result->fetch()){
            if($ftype == "store" && !$storeSet && isset($_SESSION['type']) && $_SESSION['type'] == "tenant"){
                $sowner = $this->encode($row['sowner']);
                if($sowner == $_SESSION['id']){
                    $storeId = $this->encode($row['store_id']);
                    $sname = $this->encode($row['sname']);
                    $stype = $row['stype'];
                    $addService = "<a class='btn-small green white-text' href='addservice.php?type=$stype&store_id=$storeId&sname=$sname'>Add Service</a>";
                    $addProduct = "<a class='btn-small green white-text' href='addproduct.php?type=$stype&store_id=$storeId&sname=$sname'>Add Product</a>";
                    if($stype == "silver"){
                        echo "<div style='width:100%; display:block;'>".$addService."&nbsp;&nbsp;".$addProduct."</div>";
                    }else if($stype == "gold"){
                        echo "<div style='width:100%; display:block;'>".$addProduct."</div>";
                    }else if($stype == "diamond"){
                        echo "<div style='width:100%; display:block;'>".$addService."</div>";
                    }else if($stype == "platinum"){
                        echo "<div style='width:100%; display:block;'>".$addService."&nbsp;&nbsp;".$addProduct."</div>"; 
                    }   
                    $showDeleteBtn = "block";
                }
                $storeSet = true;
            }
            $name = $this->encode($row['name']);
            $type = $this->encode($row['prod_type']);
            $price = $this->encode($row['price']);
            $storeId = "";
            $sname = "";
            if($ftype == "list"){
                $storeId = $this->encode($row['store_id']);
                $sname = $this->encode($row['sname']);
            }
            $qty = "";
            $class = "item";
            if($row['ptype'] == 'SERVICE'){
                $class='service';
            }
            if($class == "service"){
                $qty = $row['duration'];
            }else{
                $qty = $row['amount'];
            }
            $ext = $this->encode($row['ext']);
            $itemId = $this->encode($row['itemId']);
            $num = $this->encode($row['num']);
            $imagePath = "images/products/".$itemId."_".$num.".".$ext;

            $str = "<div onclick='goTo(\"viewItem.php?id=$itemId&item_name=$name&type=$class\")' class='hide-on-small-only' id='product-$itemId'>
                <div class='product $class'>
                <img src='$imagePath'/>
                <table>
                    <tr>
                        <td colspan='2'><h5>$name</h5></td>
                    </tr>
                    <tr>
                        <td><label>$type</label></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><h6>Ksh $price</h6></td>
                    <td style='text-align: right'>"; 
            $str2 = "<div onclick='goTo(\"viewItem.php?id=$itemId&item_name=$name&type=$class\")' class='hide-on-med-and-up'>
                <div class='product product-small $class'>
                <img src='$imagePath'/>
                <table>
                    <tr>
                        <td colspan='2'><h5 class='truncate'>$name</h5></td>
                    </tr>
                    <tr>
                        <td colspan='2'><label class='truncate' >$type</label></td>
                    </tr>
                    <tr>
                        <td><h6>$price/=</h6></td>
                    <td style='text-align: right'>";
            if($ftype == "list"){
                $str.="<a href='viewproducts.php?store_id=$storeId&name=$sname'>Visit Store</a>";
                $str2.="<a href='viewproducts.php?store_id=$storeId&name=$sname'>Visit</a>"; 
            }else if(isset($_SESSION['type']) && $_SESSION['type'] == "tenant" && $ftype == "store" && $sowner == $_SESSION['id']){
                $str.="<button onclick='return deleteProduct(\"$itemId\")' class='delete-prod btn-small red white-text float-right' style='display:$showDeleteBtn !important; margin-bottom: 5px;'><i class='fas fa-trash-alt'></i></button>";
                $str2.="<button onclick='return deleteProduct(\"$itemId\")'class='delete-prod btn-small red white-text float-right' style='display:$showDeleteBtn !important;'><i class='fas fa-trash-alt'></i></button>";
            }
            $str.="</td></tr></table>"; 
            $str2.="</td></tr></table>"; 
            
            $str.="</div></div>";
            $str2.="</div></div>";
            
            echo $str.$str2;
        }
    }
    
    function getLocation($id){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $res = $this->query("select * from db.locations where id = ?",[$id]);
        $i = $id;
        if($row = $res->fetch()){
            $street = $this->encode($row['street']);
            $building = $this->encode($row['building']);
            $stall = $this->encode($row['stall']);
            $description = $this->encode($row['description']);
            
            $table = "
            <div id='loc_$i'>
            <form action='backend/Tenant.php' method='post' onsubmit='return validate_modify_location(this,\"$i\")'>
                <div class='location'>
                    <div class='row'>
                        <div class='col s5'><label>Street :</label></div>
                        <div class='label_loc_$i col s7'>$street</div>
                        <div class='col s7'>
                        <input type='text' name='street' value='$street' class='input_loc_$i' style=\"display:none\"></div>
                    </div>
                    <div class='row'>
                        <div class='col s5'><label>Building :</label></div>
                        <div class='label_loc_$i col s7'>$building</div>
                        <div class='col s7'>
                        <input type='text' name='building' value='$building' class='input_loc_$i' style=\"display:none\"></div>
                    </div>
                    <div class='row'>
                        <div class='col s5'><label>Stall :</label></div>
                        <div class='label_loc_$i col s7'>$stall</div>
                        <div class='col s7'><input type='text' name='stall' value='$stall' class='input_loc_$i' style=\"display:none\"></div>
                    </div>
                    <div class='row' style='height: 50px'>
                        <div class='col s5'><label>Description :</label></div>
                        <textarea class='label_loc_$i col s7' style='height: 50px; border:none; resize:none' editable=false class='materialize-textarea'>$description</textarea>
                        <div class='col s7'><textarea name='description' class='input_loc_$i' style=\"display:none; height: 50px; border: none;resize:none;border-bottom:solid 1px black;\" >$description</textarea></div>
                    </div>
                    <div class='row panel'>
                        <div class='col s6 blue-text'><i src='edit' alt='Edit' class='label_loc_$i fas fa-edit pointer' onclick='show_form(\"loc_$i\")'></i>
                            <button type='submit' name='modifyLocation' class='input_loc_$i btn-small green' style=\"display:none\">Save</button></div>
                        <div class='col s6 red-text'><i alt='Delete' class='label_loc_$i fas fa-trash-alt pointer' onclick='delete_loc(\"$i\", \"$id\")'></i>
                            <button  class='input_loc_$i btn-small green' onclick='hide_form(\"loc_$i\")' style=\"display:none\">Cancel</button></div>
                    </div>
                    <div>
                        <p id='error_loc_$i' class='error message'></p>
                    </div>
                </div>
            </form>
            </div>";
            
            echo $table;
        }
        
    }
    
    function getAvailability(){
        $id = $_GET['id'];
        
        $res = $this->query("select l.start as lunchStart, l.end as lunchEnd, h.start as hourStart, h.end as hourEnd, s.weekends, s.holidays from db.section s left join db.lunchhours l on s.lunchbreak = l.id left join db.hours h on s.hours = h.id where s.id = ? ",[$id]);
        
        $row = $res->fetch();
        
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
            <div class='row'>
                <div class='col s12 row'>
                    <div class='col s5'><label>Hours open :</label></div>
                    <div class='col s7'>$hours</div>
                </div>
                <div class='col s12 row'>
                    <div class='col s5'><label>Lunch Hours :</label></div>
                    <div class='col s7'>$lunchhours</div>
                </div>
                <div class='col s12 row'>
                    <div class='col s5'><label>Weekends :</label></div>
                    <div class='col s7'>$weekend</div>
                </div>
                <div class='col s12 row'>
                    <div class='col s5'><label>Holidays :</label></div>
                    <div class='col s7'>$holidays</div>
                </div>
            </div>
        ";
        echo $str;
    }
    
    function getStores(){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select name,id, status,type, paid from db.section where user_id = ? and status <> ?",[$id, "DELETED"]);
        
        while($row = $res->fetch()){
            $store_id = $this->encode($row['id']);
            $name = $this->encode($row['name']);
            $status = $row['status'];
            $type = $row['type'];
            $paid = $row['paid'];
            $followerCount = $this->getFollowerCount($store_id);
            if($type == "bronze"){
                $type = "";
            }else if($type == "silver"){
                $type = "<a href='viewproducts.php?store_id=$store_id&name=$name'><span class='hide-on-small-only'>View Items</span><i class='fas fa-external-link-alt hide-on-med-and-up'></i></a>";
            }else if($type == "gold"){
               $type = "<a href='viewproducts.php?store_id=$store_id&name=$name'><span class='hide-on-small-only'>View Products</span><i class='fas fa-external-link-alt hide-on-med-and-up'></i></a>";
            }else if($type == "diamond"){
                $type = "<a href='viewproducts.php?store_id=$store_id&name=$name'><span class='hide-on-small-only'>View Services</span><i class='fas fa-external-link-alt hide-on-med-and-up'></i></a>";
            }else if($type == "platinum"){
                $type = "<a href='viewproducts.php?store_id=$store_id&name=$name'><span class='hide-on-small-only'>View Items</span><i class='fas fa-external-link-alt hide-on-med-and-up'></i></a>";
            }else {
                $type = "";
            }
            $canEdit = "initial";
            if($status == "PENDING"){
                $type = "";
                $canEdit = "none";
                $status = "<label class='hide-on-med-and-down indigo-text'>Pending</label><i class='material-icons hide-on-large-only greyitext'>done</i>";
            }else if($status == "REJECTED"){
                $type = "";
                $canEdit = "none";
                $status = "<label class='red-text hide-on-med-and-down'>Rejected</label>
                <i class='material-icons hide-on-large-only red-text'>error</i>";
            }else if($status == "SUSPENDED"){
                $status = "<label class='yellow-text hide-on-med-and-down'>Suspended</label><i class='material-icons hide-on-large-only yellow-text'>report_problem</i>";
            }else if($paid == "NOT PAID"){
                $status = "<label class='amber-text hide-on-med-and-down text-darken-4'>Expired</label><i class='fas fa-clock-o hide-on-large-only amber-text'>report_problem</i>";
            }else if($status == "APPROVED"){
                $status = "<label style='color:green' class='hide-on-med-and-down'>Approved</label><i class='material-icons hide-on-large-only green-text'>done_all</i>";
            }
            $str = "<div class='row my-store' id='store-$store_id'>
                <div class='col s4 m3 l5 left-align'>
                <i class='fa fa-user blue-text'></i><span class='blue-text'>($followerCount)</span>&nbsp;<a href='viewStoreInfo.php?type=store&store_id=$store_id&name=$name'>$name</a>
                </div>
                <div class='col s2 m1 l1'>$status </div>
                <div class='col s2 m3 l2'>$type</div>
                <a href='editStore.php?type=store&id=$store_id&name=$name' class='col s2' ><i class='material-icons' style=\"display: $canEdit\">edit</i></a>
                <div class='col s2'><i class='fas fa-trash-alt red-text text-darken-2' onclick='confirm_delete_store(\"store\",\"$store_id\")'></i></div>
            </div>";
            
            echo $str;
        }
    }
    
    function getCartNum($type){
        if(!$this->isLoggedIn()){
            echo '{ "PENDING": 0,
                    "DELIVERY": 0,
                    "PICKUP": 0,
                    "COMPLETE": 0,
                    "CANCELLED": 0,
                    "total": 0, 
                    "incomplete": 0
                    }';   
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select count(id) as num, status from db.carts where userId = ? group by status ",[$id]);
                        
        $total = 0;
        $incomplete = 0;
        $pending = 0;
        $pickup = 0;
        $delivery = 0;
        $complete = 0;
        $cancelled = 0;
        while($row = $res->fetch()){
            $total+=$row['num'];
            if($row['status'] == "PENDING" || $row['status'] == "DELIVERY" || $row['status'] == "PICK UP"){
                $incomplete+=$row['num'];
                if($row['status'] == "PENDING"){
                    $pending = $row['num'];
                }else if($row['status'] == "DELIVERY"){
                    $delivery = $row['num'];
                }else if($row['status'] == "PICK UP"){
                    $pickup = $row['num'];
                }
            }else if($row['status'] == "COMPLETE"){
                    $complete = $row['num'];
            }else {
                $cancelled = $row['num'];
            }
        }
        $output ='{ "PENDING": '.$pending.',
            "DELIVERY": '.$delivery.',
            "PICKUP": '.$pickup.',
            "COMPLETE": '.$complete.',
            "CANCELLED": '.$cancelled.',
            "total":'.$total.', 
            "incomplete": '.$incomplete.'
            }';

        if($type == "text"){
            echo $incomplete;   
        }else{
            echo $output;
        }
        
    }

    function getAptNum($type){
        if(!$this->isLoggedIn()){
            echo '{ "UPCOMING": 0,
                    "PAST": 0,
                    "CANCELLED": 0,
                    "total": 0 
                    }';   
            return;
        }
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(id) as num, status from db.appointments where userId = ? group by status",[$id]);        
        
        $total = 0;
        $upcoming = 0;
        $past = 0;
        $cancelled = 0;
        while($row = $res->fetch()){
            $total+=$row['num'];
            
            if($row['status'] == "PENDING"){
                $upcoming = $row['num'];
            }else if($row['status'] == "CANCELLED"){
                $cancelled = $row['num'];
            }else{
                $past = $row['num'];
            }
        }
        $output ='{ "UPCOMING": '.$upcoming.',
            "PAST": '.$past.',
            "CANCELLED": '.$cancelled.',
            "total": '.$total.'
            }';

        if($type == "text"){
            echo $upcoming;   
        }else{
            echo $output;
        }
        
    }
    
    function checkAvailability(){
        $iid = $_GET['iid'];
        $date = $_GET['date'];
        $time = $_GET['time'];
        $opening = $_GET['opening'];
        $closing = $_GET['closing'];
        $duration = $_GET['duration']*100;
        $lunchStart = $_GET['lunchStart'];
        $lunchEnd = $_GET['lunchEnd'];
        $capacity = 100;
        if(($time > $lunchStart && $time < $lunchEnd)){
            echo "start time lunch error";
        }
        if((($time + $duration) > $lunchStart && ($time + $duration) < $lunchEnd) ){
            echo "end time lunch error ".($time + $duration)." > ".$lunchStart." && ".$time." < ".$lunchEnd ;
        }
        
        if($time < $opening || ($time + $duration) > $closing || ($time > $lunchStart && $time < $lunchEnd) || (($time + $duration) > $lunchStart && ($time + $duration) < $lunchEnd) || ($time <= $lunchStart && ($time + $duration) >= $lunchEnd)){
            $count = 10000;
        }else{
           $res = $this->query("select count(*) as ct, s.capacity from db.appointments a left join db.product p on a.itemId = p.id left join db.section s on s.id = p.web_id where day = ? AND itemId = ? and ( (? between (start) and (end - 1)) || ((? + (p.duration * 100)) between (start) and (end - 1)))", [$date, $iid, $time, $time]);
            $row = $res->fetch();
            $count = $row['ct'];
            $capacity = $row['capacity'];
        }
        
        if($count < $capacity){
            echo "{\"result\":\"Okay\"}";
        }else{
            
            $str = "{\"result\":\"Not Okay\",";
            date_default_timezone_set('Africa/Nairobi');
            if($date == date('Y-m-d')){
                $time = date('Hi');
                $time = (int)$time;
                $time = ceil($time / 100) * 100;
                if($time < $opening){
                    $time = $opening;
                }
            }else{
                $time = $opening;
            }
                        
            $ct = 0;
            $str.="\"free\": [";
            while($ct < 10){
                if(($time + $duration) > $closing){
                    $date=date_create($date);
                    date_add($date,date_interval_create_from_date_string("1 days"));
                    $date = date_format($date,"Y-m-d");
                    $time = $opening;
                }
                if(($time > $lunchStart && $time < $lunchEnd) || (($time + $duration) > $lunchStart && ($time + $duration) < $lunchEnd) || ($time <= $lunchStart && ($time + $duration) >= $lunchEnd)){
                    $time+=100;
                }else{
                    $res = $this->query("select count(*) as ct from db.appointments, db.product p where day = ? AND itemId = ? and ( (? between (start + 1) and (end - 1)) || ((? + (p.duration * 100)) between (start + 1) and (end - 1)) or (start = ? and (? + p.duration) = end))", [$date, $iid, $time, $time, $time, $time]);
                    $row = $res->fetch();
                    $count = $row['ct'];
                    if($count == 0){
                        if($ct > 0){
                            $str.=",";
                        }
                        $str.="{\"date\":\"$date\",\"from\":\"$time\",\"to\":\"".($time+$duration)."\"}";
                        $ct++;
                    }   
                    $time+=$duration;
                }
            }
            
            $str.="] }";
            echo $str;
        }
    }
    
    function getDetailedStoreOrders(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "DATA": "'.$mess.'"}'; 
            
            echo $out;  
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, c.quantity as qty, p.price as productPrice, c.id as cartId, u.firstname as fName, u.lastname as lName, u.phone as userPhone, c.status as itemStatus, p.procurement as method, c.ordered as orderDate, c.received as receiveDate, s.name as storeName, l.building as aBuilding, l.street as aStreet, l.stall as aStall, l.description as ldesc, c.stars as cstars, c.reason as creason from db.carts c left join db.product p on c.itemId = p.id left join section s on p.web_id = s.id left join db.user u on u.id = c.userId left join (select ext,product_id from db.product_images group by product_id) im on im.product_id = p.id left join db.locations l on c.locationId = l.id where s.user_id = ? and c.status <> ?", [$id,"PENDING"]);
        
        $data = "";
        
        while($row = $res->fetch()){
            $cid = $row['cartId'];
            $name = $this->encode($row['prodName']);
            $amt = $row['qty'];
            $totalCost = $amt * $row['productPrice'];
            $phone = $this->encode($row['userPhone']);
            $userName = $this->encode($row['fName']." ".$row['lName']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $method = $this->encode($row['method']);
            $storeName = $this->encode($row['storeName']);
            $cartId = $row['cartId'];
            $status = $row['itemStatus'];
            $orderDate = $this->formatDate($row['orderDate']);
            $cstars = $row['cstars'];
            $reason = $this->encode($row['creason']);
            $date = $orderDate;
            $ldesc = $this->encode($row['ldesc']);
            $button = "";
            if($status == "PICK UP" || $status == "DELIVERY"){
                $button = '<button onclick=\"cancel_order(\''.$cartId.'\')\" class=\"btn-small green\"><a href=\"#reason-modal\" class=\"white-text modal-trigger\">Cancel</a></button>';
            }else if($status == "CANCELLED"){
                $button = '<div class=\"truncate\">CANCELLED : '.$reason.'</div>';
            }else if($status == "COMPLETE"){
                $button = $this->rating($cstars, 1, "part");
            }
            
            $data.='<tr>
                                
                                <td><a href=\"viewOrder.php?type=cart&id='.$cid.'&item_name='.$name.'&loc='.$location.'&locDesc='.$ldesc.'\">'.$name.'</a></td>
                                <td>'.$amt.'</td>
                                <td>'.$totalCost.'</td>
                                <td>'.$date.'</td>
                                <td>'.$status.'</td>
                                <td>'.$method.'</td>
                                <td>'.$userName.'</td>
                                <td>'.$phone.'</td>
                                <td>'.$location.'</td>
                                <td>'.$button.'</td>
                        </tr>';
        }
        
       $data = trim(preg_replace('/\s\s+/',' ',$data));
        $out = '{ "DATA": "'.$data.'"}'; 
        echo $out;
    
        
    }
    
    function getStoreOrders(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "DELIVERY": "'.$mess.'",
                    "PICKUP": "'.$mess.'",
                    "COMPLETE": "'.$mess.'",
                    "CANCELLED": "'.$mess.'"
                    }'; 
            
            echo $out;  
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, c.quantity as qty, p.price as productPrice, c.id as cartId, u.firstname as fName, u.lastname as lName, u.phone as userPhone, c.status as itemStatus, p.procurement as method, c.ordered as orderDate, c.received as receiveDate, s.name as storeName, l.building as aBuilding, l.street as aStreet, l.stall as aStall, l.description as  ldesc, c.stars as cstars, c.reason as creason from db.carts c left join db.product p on c.itemId = p.id left join section s on p.web_id = s.id left join db.user u on u.id = c.userId left join (select ext,product_id from db.product_images group by product_id) im on im.product_id = p.id left join db.locations l on c.locationId = l.id where s.user_id = ? and c.status <> ?", [$id,"PENDING"]);
        $delivery = "";
        $pickup = "";
        $complete = "";
        $cancelled = "";
        $ct_de = 0;
        $ct_pi = 0;
        $ct_co = 0;
        $ct_ca = 0;
        
        while($row = $res->fetch()){
            $img = $this->encode("images/products/".$row['imgName']."_0.".$row['extension']);
            $name = $this->encode($row['prodName']);
            $amt = $row['qty'];
            $totalCost = $amt * $row['productPrice'];
            $phone = $this->encode($row['userPhone']);
            $userName = $this->encode($row['fName']." ".$row['lName']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $method = $this->encode($row['method']);
            $storeName = $this->encode($row['storeName']);
            $cartId = $row['cartId'];
            $status = $row['itemStatus'];
            $orderDate = $this->formatDate($row['orderDate']);
            $cstars = $row['cstars'];
            $reason = $row['creason'];
            $ldesc = $this->encode($row['ldesc']);
            $date = "<label class='order_date'>Ordered on: $orderDate</label>";
            $button = "";
            if($status == "PICK UP" || $status == "DELIVERY"){
                $button = '<button onclick=\"cancel_order(\''.$cartId.'\')\" class=\"btn-small green\"><a href=\"#reason-modal\" class=\"white-text modal-trigger\">Cancel</a></button>';
            }else if($status == "CANCELLED"){
                $button = '<div class=\"truncate\">CANCELLED : '.$reason.'</div>';
            }else if($status == "COMPLETE"){
                $button = $this->rating($cstars, 1, "part");
            }
            
                $str = '
                    <div id=\"cart-'.$cartId.'\">
                        <div class=\"cart_item row section hide-on-xs\" >
                            <a href=\"viewOrder.php?type=cart&id='.$cartId.'&item_name='.$name.'&loc='.$location.'&locDesc='.$ldesc.'\"><img src=\"'.$img.'\" class=\"col s4 l3\"></a>
                            <div class=\"col s8 l9 container row left-align\">
                                <div class=\"col l12 s12\">'.$name.'</div>
                                <div class=\"col l4\"> '.$amt.'</div>
                                <div class=\"col l8\">Ksh '.$totalCost.'</div>
                                <div class=\"col s12\">'.$date.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Client Information</label>
                                <div class=\"col s8\">'.$userName.'</div>
                                <div class=\"col s4\">'.$phone.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Pick-Up Location</label>
                                <div class=\"col s12\">'.$location.'</div>
                                <span class=\"divider col s12\"></span>
                                <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>'.
                        '<div class=\"cart_item row section show-on-xs\">
                            <img src=\"'.$img.'\" class=\"col s12 m4 l3\">
                            <div class=\"col s12 m8 l9 container row left-align\">
                                <div class=\"col l12 s12\">'.$name.'</div>
                                <div class=\"col l4\"> '.$amt.'</div>
                                <div class=\"col l8\">Ksh '.$totalCost.'</div>
                                <div class=\"col s12\">'.$date.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Client Information</label>
                                <div class=\"col s6\">'.$userName.'</div>
                                <div class=\"col s6\">'.$phone.'</div>
                                <span class=\"divider col s12\"></span>
                                <label class=\"col s12\">Pick-Up Location</label>
                                <div class=\"col s12\">'.$location.'</div>
                                <span class=\"divider col s12\"></span>
                                <div class=\"col s12\">'.$button.'</div>
                            </div>
                        </div>
                    </div>';
            if($status == "COMPLETE"){
                $complete.=$str;
                $ct_co++;
            }else if($status == "CANCELLED"){
                $cancelled.=$str;
                $ct_ca++;
            }else if($method == "PICK UP"){
                $pickup.=$str;
                $ct_pi++;
            }else{
                $delivery.=$str;
                $ct_de++;
            }
        }
        
        $delivery = trim(preg_replace('/\s\s+/',' ',$delivery));
        $pickup = trim(preg_replace('/\s\s+/',' ',$pickup));
        $complete = trim(preg_replace('/\s\s+/',' ',$complete));
        $cancelled = trim(preg_replace('/\s\s+/',' ',$cancelled));
        
        $out = '{ "DELIVERY": "'.$delivery.'",
                    "PICKUP": "'.$pickup.'",
                    "COMPLETE": "'.$complete.'",
                    "CANCELLED": "'.$cancelled.'"
                    }'; 
        echo $out;
    
    }
    
    function getDetailedStoreApts(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "DATA": "'.$mess.'"}'; 
            
            echo $out;  
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, p.price as productPrice, a.id as aptId, s.name as storeName, u.firstname as fName, u.lastname as lName, u.phone as userPhone, a.status as itemStatus, a.start as aptFrom, a.end as aptTo, a.day as aptDay, l.building as aBuilding, l.street as aStreet, l.stall as aStall, l.description as ldesc, a.stars as astars, a.reason as areason from db.appointments a left join db.product p on a.itemId = p.id left join db.section s on p.web_id = s.id left join db.user u on u.id = a.userId left join (select ext,product_id from product_images group by product_id) im on im.product_id = p.id left join db.locations l on a.locationId = l.id where s.user_id = ? ", [$id]);
        
        $data = "";
        
        while($row = $res->fetch()){
            $pid = $row['imgName'];
            $name = $this->encode($row['prodName']);
            $totalCost = $row['productPrice'];
            $userName = $this->encode($row['fName']." ".$row['lName']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $phone = $this->encode($row['userPhone']);
            $storeName = $this->encode($row['storeName']);
            $aptId = $row['aptId'];
            $status = $row['itemStatus'];
            $from = $this->formatTime($row['aptFrom']);
            $to = $this->formatTime($row['aptTo']);
            $date = $this->formatDate($row['aptDay']);
            $astars = $row['astars'];
            $reason = $row['areason'];
            $ldesc = $this->encode($row['ldesc']);
            $button = "";
            if($status == "PENDING"){
                $button = '<button onclick=\"cancel_apt(\''.$aptId.'\')\" class=\"btn-small green\"><a href=\"#reason-modal\" class=\"white-text modal-trigger\">Cancel</a></button>';
            }else if($status == "COMPLETE"){
                $button = $this->rating($astars, 1, "part");
            }else if($status == "PAST"){
                $button = "MISSED";
            }else if($status == "CANCELLED"){
                $button = "CANCELLED : ".$reason;
            }
            
            $data .= '<tr>
                        <td><a href=\"viewOrder.php?type=apt&id='.$aptId.'&item_name='.$name.'&loc='.$location.'&locDesc='.$ldesc.'\">'.$name.'</a></td>
                        <td>'.$totalCost.'</td>
                        <td>'.$date.'</td>
                        <td> '.$from.' - '.$to.'</td>
                        <td>'.$userName.'</td>
                        <td>'.$phone.'</td>
                        <td>'.$location.'</td>
                        <td>'.$status.'</td>
                        <td>'.$button.'</td>
                    </tr>';
        }
        
       $data = trim(preg_replace('/\s\s+/',' ',$data));
        $out = '{ "DATA": "'.$data.'"}'; 
        echo $out;
    
    }
    
    function getStoreAppointments(){
        if(!$this->isLoggedIn()){
            $mess = '<center style=\"padding:20px;\"><a href=\"login.php\">Session expired... Log In</a></center>';
            $out = '{ "UPCOMING": "'.$mess.'",
                    "PAST": "'.$mess.'",
                    "CANCELLED": "'.$mess.'"
                }';
            
            echo $out; 
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select p.id as imgName, im.ext as extension, p.name as prodName, p.price as productPrice, a.id as aptId, s.name as storeName, u.firstname as fName, u.lastname as lName, u.phone as userPhone, a.status as itemStatus, a.start as aptFrom, a.end as aptTo, a.day as aptDay, l.building as aBuilding, l.street as aStreet, l.stall as aStall, l.description as ldesc, a.stars as astars, a.reason as areason from db.appointments a left join db.product p on a.itemId = p.id left join db.section s on p.web_id = s.id left join db.user u on u.id = a.userId left join (select ext,product_id from product_images group by product_id) im on im.product_id = p.id left join db.locations l on a.locationId = l.id where s.user_id = ? ", [$id]);
        $upcoming = "";
        $past = "";
        $cancelled = "";
        $ct_up = 0;
        $ct_pa = 0;
        $ct_ca = 0;
        
        while($row = $res->fetch()){
            $img = $this->encode("images/products/".$row['imgName']."_0.".$row['extension']);
            $name = $this->encode($row['prodName']);
            $totalCost = $row['productPrice'];
            $userName = $this->encode($row['fName']." ".$row['lName']);
            $location = $this->encode($row['aBuilding'].", ".$row['aStreet'].", ".$row['aStall']);
            $phone = $this->encode($row['userPhone']);
            $storeName = $this->encode($row['storeName']);
            $aptId = $row['aptId'];
            $status = $row['itemStatus'];
            $from = $this->formatTime($row['aptFrom']);
            $to = $this->formatTime($row['aptTo']);
            $date = $this->formatDate($row['aptDay']);
            $ldesc = $this->encode($row['ldesc']);
            $astars = $row['astars'];
            $reason = $row['areason'];
            $button = "";
            if($status == "PENDING"){
                $button = '<button onclick=\"cancel_apt(\''.$aptId.'\')\" class=\"btn-small green\"><a href=\"#reason-modal\" class=\"white-text modal-trigger\">Cancel</a></button>';
            }else if($status == "COMPLETE"){
                $button = $this->rating($astars, 1, "part");
            }else if($status == "PAST"){
                $button = "MISSED";
            }else if($status == "CANCELLED"){
                $button = "CANCELLED : ".$reason;
            }
            
            $str = '<div id=\"apt-'.$aptId.'\">
                      <div class=\"apt_item row section hide-on-xs\">
                            <a href=\"viewOrder.php?type=apt&id='.$aptId.'&item_name='.$name.'&loc='.$location.'&locDesc='.$ldesc.'\"><img src=\"'.$img.'\" class=\"col s4 l3\"></a>
                            <div class=\"col s8 l9 row container section left-align\">
                                    <div class=\"col s8\">'.$name.'</div><div class=\"col s4\">'.$totalCost.'</div>
                                    <div class=\"col s12\">'.$date.' : '.$from.' - '.$to.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Client Information</label>
                                    <div class=\"col s8\">'.$userName.'</div>
                                    <div class=\"col s4\">'.$phone.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Selected Outlet</label>
                                    <div class=\"col s12\">'.$location.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <div class=\"col\">'.$button.'</div>
                            </div>
                        </div>
                        <div class=\"apt_item row section show-on-xs\">
                            <img src=\"'.$img.'\" class=\"col s12 m4 l3\">
                            <div class=\"col s12 m8 l9 row container section left-align\">
                                    <div class=\"col s8\">'.$name.'</div><div class=\"col s4\">'.$totalCost.'</div>
                                    <div class=\"col s12\">'.$date.' : '.$from.' - '.$to.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Client Information</label>
                                    <div class=\"col s6\">'.$userName.'</div>
                                    <div class=\"col s6\">'.$phone.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <label class=\"col s12\">Selected Outlet</label>
                                    <div class=\"col s12\">'.$location.'</div>
                                    <span class=\"divider col s12\"></span>
                                    <div class=\"col\">'.$button.'</div>
                            </div>
                        </div>
                      </div>';
            if($status == "PENDING"){
                $upcoming.=$str;
                $ct_up++;
            }else if($status == "CANCELLED"){
                $cancelled.=$str;
                $ct_ca++;
            }else{
                $past.=$str;
                $ct_pa++;
            }
        }
        $upcoming = trim(preg_replace('/\s\s+/',' ',$upcoming));
        $past = trim(preg_replace('/\s\s+/',' ',$past));
        $cancelled = trim(preg_replace('/\s\s+/',' ',$cancelled));
        $out = '{ "UPCOMING": "'.$upcoming.'",
                    "PAST": "'.$past.'",
                    "CANCELLED": "'.$cancelled.'"
                }';
        echo $out;
    }
    
    function report(){
        if(isset($_SESSION['error'])){
            $mess = $_SESSION['error'];
            echo "<p id='error' class='message'>$mess</p>";
            unset($_SESSION['error']);
        }else if (isset($_SESSION['success'])){
            $mess = $_SESSION['success'];
            echo "<p id='success' class='message'>$mess</p>";
            unset($_SESSION['success']);
        }
    }
    
    function setIsLoggedIn(){
        if(isset($_SESSION['id']))
            echo "true";
        else{
            $this->report();
        }
    }
    
    function getHours(){
        if(!$this->isLoggedIn()){
            return;
        }else{
            $id = $_SESSION['id'];
            $res = $this->query("Select id,start,end from db.hours where userId = ?",[$id]);
            while($row = $res->fetch()){
                $from = $this->formatTime($row['start']);
                $to = $this->formatTime($row['end']);
                $id = $row['id'];
                $str = "<label>
                            <input type='radio' name='hours' value='$id' class='with-gap'> <span>$from - $to</span>
                        </label><br>";
                echo $str;
            }
        }
    }
    
    function getLunchHours(){
        if(!$this->isLoggedIn()){
            return;
        }else{
            $id = $_SESSION['id'];
            $res = $this->query("Select id,start,end from db.lunchhours where userId = ?",[$id]);
            while($row = $res->fetch()){
                $from = $this->formatTime($row['start']);
                $to = $this->formatTime($row['end']);
                $id = $row['id'];
                $str = "<label>
                            <input type='radio' name='lunchhours' value='$id' class='with-gap'> <span>$from - $to</span>
                        </label><br>";
                echo $str;
            }
        }
    }
    
    function getStoreOrderCount($type){
        if(!$this->isLoggedIn()){
            echo '{ "DELIVERY": 0,
                    "PICKUP": 0,
                    "COMPLETE": 0,
                    "CANCELLED": 0,
                    "total": 0, 
                    "incomplete": 0
                    }';   
            return;
        }
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(c.id) as ct, c.status from db.carts c left join db.product p on c.itemId = p.id left join section s on p.web_id = s.id left join db.user u on u.id = c.userId where s.user_id = ? group by c.status ", [$id]);
                       
        $total = 0;
        $incomplete = 0;
        $pickup = 0;
        $delivery = 0;
        $complete = 0;
        $cancelled = 0;
        while($row = $res->fetch()){
            $total+=$row['ct'];
            if($row['status'] == "DELIVERY" || $row['status'] == "PICK UP"){
                $incomplete+=$row['ct'];
                if($row['status'] == "DELIVERY"){
                    $delivery = $row['ct'];
                }else if($row['status'] == "PICK UP"){
                    $pickup = $row['ct'];
                }
            }else if($row['status'] == "COMPLETE"){
                    $complete = $row['ct'];
            }else if($row['status'] == "CANCELLED"){
                $cancelled = $row['ct'];
            }
        }
        $output ='{ "DELIVERY": '.$delivery.',
            "PICKUP": '.$pickup.',
            "COMPLETE": '.$complete.',
            "CANCELLED": '.$cancelled.',
            "total":'.$total.', 
            "incomplete": '.$incomplete.'
            }';

        if($type == "text"){
            echo $incomplete;   
        }else{
            echo $output;
        }
        
    }
    
    function getStoreAptCount($type){
        if(!$this->isLoggedIn()){
            echo '{ "UPCOMING": 0,
                    "PAST": 0,
                    "CANCELLED": 0,
                    "total": 0 
                    }';   
            return;
        }
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(a.id) as ct, a.status from db.appointments a left join db.product p on a.itemId = p.id left join db.section s on p.web_id = s.id left join db.user u on u.id = a.userId left join (select ext,product_id from product_images group by product_id) im on im.product_id = p.id left join db.locations l on a.locationId = l.id where s.user_id = ? group by a.status", [$id]);
                        
        $total = 0;
        $upcoming = 0;
        $past = 0;
        $cancelled = 0;
        while($row = $res->fetch()){
            $total+=$row['ct'];
            
            if($row['status'] == "PENDING"){
                $upcoming = $row['ct'];
            }else if($row['status'] == "CANCELLED"){
                $cancelled = $row['ct'];
            }else{
                $past = $row['ct'];
            }
        }
        $output ='{ "UPCOMING": '.$upcoming.',
            "PAST": '.$past.',
            "CANCELLED": '.$cancelled.',
            "total": '.$total.'
            }';

        if($type == "text"){
            echo $upcoming;   
        }else{
            echo $output;
        }
        
    }
    
    function getStoreCount(){
        if(!$this->isLoggedIn()){
            echo "0";   
            return;
        }
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(*) as ct from db.section where user_id = ?",[$id]);
        
        $row = $res->fetch();
        
        echo $row['ct'];
    }
    
    function getStoreInfo(){
        $id = $_GET['store_id'];
        
        $res = $this->query("select s.user_id as owner, p.id as pid, p.ext as pext, p.title as ptitle, listing, s.name, s.description, s.stars, s.sales, s.ext, s.email, s.phone, h.start as hfrom, h.end as hto, l.start as lfrom, l.end as lto, s.weekends, s.holidays, s.website from db.section s left join db.product_listing p on s.id = p.web_id left join hours h on h.id = s.hours left join lunchhours l on l.id = s.lunchbreak where s.id = ?",[$id]);
        $set = false;
        $listings = "<div>
                    <h4>What we do</h4>
                        ";
        $str = "";
        $contacts = "";
        $availability = "";
        $offset = true;
        $owner = "";
        while($row = $res->fetch()){
            if(!$set){
                $name = $this->encode($row['name']);
                $desc = $this->encode($row['description']);
                $ext = $this->encode($row['ext']);
                $email = $this->encode($row['email']);
                $phone = $this->encode($row['phone']);
                $hfrom = $this->encode($row['hfrom']);
                $hto = $this->encode($row['hto']);
                $lfrom = $this->encode($row['lfrom']);
                $lto = $this->encode($row['lto']);
                $weekends = $this->encode($row['weekends']);
                $holidays = $this->encode($row['holidays']);
                $website = $this->encode($row['website']);
                $owner = $row['owner'];
                $img = $id.".".$ext;
                
                $rating = $this->getStoreRating($id);
                
                $str = "<h3 class = 'center-align'>$name</h3>
                        <div class='row store-about'>
                           <img src='images/sections/$img' class='float-left store-about-image'> 
                           <div class='float-left store-about-text'>
                                <div id='store-rating'>$rating</div>
                                <p>$desc</p>
                            </div>
                        </div>";
                $hours;
                echo $hfrom." ".$lfrom;
                if($hfrom == 0 && $lfrom == 0
                  ){
                    $hours = "Open 24hrs";
                }else if($lfrom == 0 && $lto == 0){
                    $hours = "Open between ".$this->formatTime($hfrom)." - ".$this->formatTime($hto)."";    
                }else if($lfrom > $hfrom && $hto > $lto){
                    $hours = "Open between ".$this->formatTime($hfrom)." - ".$this->formatTime($lfrom)." and ".$this->formatTime($lto)." - ".$this->formatTime($hto)."";   
                }
                
                if($weekends == "sartuday"){
                    $weekends = "Closed on Sundays";
                } else if($weekends == "sunday"){
                    $weekends = "Closed on Sartudays";
                } else if($weekends == "both"){
                    $weekends = "Open 7 days a week";
                } else if($weekends == "none"){
                    $weekends = "Closed on weekends";
                }
                
                if($holidays == "national"){
                    $holidays = "Closed on Religious holidays";
                } else if($holidays == "religious"){
                    $holidays = "Closed on National holidays";
                } else if($holidays == "all"){
                    $holidays = "Available on holidays";
                } else if($holidays == "none"){
                    $holidays = "Closed on holidays";
                }
                
                $availability = "<div class='row store-slide-in'>
                            <ul>
                                <li>$hours</li>
                                <li>$weekends</li>
                                <li>$holidays</li>
                            </ul>
                        </div>";
                if($website != ""){
                    $website = "<p><i class='fas fa-external-link-alt blue-text'></i> <a href='$website'>$website</a></p>";
                }
                $contacts = "<div class='row store-slide-in'>
                            <h4>Contacts</h4>
                            <p><i class='far fa-envelope red-text'></i> $email</p>
                            <p><i class='fas fa-phone green-text'></i> $phone</p>
                            $website
                        </div>";
                $set = true;
            }
            $title = $this->encode($row['ptitle']);
            $l_id = $this->encode($row['pid']);
            $ext = $this->encode($row['pext']);
            $img = $l_id.".".$ext;
            $listing = $this->encode($row['listing']);
            
            if($offset){
                $m = "m7";
                $imgString = "<img src='images/features/$img' style='height: 200px;' class='col s12 m4'>";
                
                if(!file_exists("images/features/$img")){
                    $imgString = "";
                    $m = "";
                }
                
                $listings.="<div class='row store-slide-in'>
                                $imgString
                                <div class='col s12 $m'>
                                    <h5>$title</h5>
                                    <span>$listing</span>
                                </div>
                            </div>";
                $offset = false;
            }else{
                $m = "m7 pull-m4";
                $imgString = "<img src='images/features/$img' style='height: 200px;' class='col s12 m4 push-m7'>";
                
                if(!file_exists("images/features/$img")){
                    $imgString = "";
                    $m = "";
                }
                $offset = true;
                $listings.="<div class='row store-slide-in'>
                                $imgString
                                <div class='col s12 $m'>
                                    <h5>$title</h5>
                                    <span>$listing</span>
                                </div>
                            </div>";
            }
            
        }
        $listings.= "</div>";
        
        echo $str.$listings.$availability.$contacts;
        
        if($this->isLoggedIn() && $owner != $_SESSION['id']){
            echo "<a href=\"#rate-modal\" class=\"modal-trigger green-text float-right\" onclick =\"rate('$id')\"><i class=\"material-icons\">comment</i></a>";   
        }
        
        $comments = $this->getStoreComments($id);
        
        echo "<div style='margin-top: 40px;' id='store-comments' class='store-comments-slide-in''>".$comments."</div>";
        
    }
    
    function getStoresSelect(){
        if(!$this->isLoggedIn()){
            echo "<center style='padding:20px;'><a href='login.php'>Session expired... Log In</a></center>";   
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select name,id, status,type from db.section where user_id = ?",[$id]);
        
        while($row = $res->fetch()){
            $store_id = $this->encode($row['id']);
            $name = $this->encode($row['name']);
            $status = $row['status'];
            $type = $row['type'];
            if($type == "bronze"){
                continue;
            }
            $str = "<option value='$store_id'>$name</option>";
            
            echo $str;
        }
    }
    
    function getFollowing($uid, $sid, $type){
        $str = "";
        $json = "";
        $innerHTML = "";
        
        $res = $this->query("select count(*) as ct from db.followers where userId = ? and storeId = ?",[$uid, $sid]);
        
        $row = $res->fetch();
        
        $ct = $row['ct'];
        
        if($ct > 0){
            $str ="<span><i class='fa fa-user blue-text' onclick='unfollow(\"$uid\", \"$sid\", this)'></i></span>";
            $json ='<span><i class=\"fa fa-user blue-text\" onclick=\"unfollow(\''.$uid.'\', \''.$sid.'\', this)\"></i></span>';
            $innerHTML = "<i class='fa fa-user blue-text' onclick='unfollow(\"$uid\", \"$sid\", this)'></i>";
        }else{
            $str ="<span><i class='fa fa-user-plus black-text' onclick='follow(\"$uid\", \"$sid\", this)'></i></span>";
            $json ='<span><i class=\"fa fa-user-plus black-text\" onclick=\"follow(\''.$uid.'\', \''.$sid.'\', this)\"></i></span>';
            $innerHTML = "<i class='fa fa-user-plus black-text' onclick='follow(\"$uid\", \"$sid\", this)'></i>";
        }
        
        if($type == "text"){
            return $str;
        }else if($type == "innerhtml"){
            echo $innerHTML;
        }
        
    }
    
    function getEnabled(){
        if(!$this->isLoggedIn()){
            echo '{ "ORDERS": false,
                    "APTS": false,
                    "REPORTS": false
                    }';   
            return;
        }
        $id = $_SESSION['id'];
        
        $res = $this->query("select count(type) as ct, type from section where user_id = ? group by type ", [$id]);
                       
        $orders = "false";
        $apts = "false";
        $reports = "false";
        
        while($row = $res->fetch()){
            $type = $row['type'];
            $ct = $row['ct'];
            
            if($type == "gold" && $ct > 0){
                $orders = "true";
                $reports = "true";
            }else if($type == "diamond" && $ct > 0){
                $apts = "true";
                $reports = "true";
            }else if($type == "platinum" && $ct > 0){
                $apts = "true";
                $orders = "true";
                $reports = "true";
            }
        }
        
        $output ='{ "ORDERS": '.$orders.',
                    "APTS": '.$apts.',
                    "REPORTS": '.$reports.'
                    }';

        
        echo $output;
        
        
    }
    
    function getStoreComments($sid){
        $comments = $this->query("select comment, stars, firstname from db.comments c left join db.user u on u.id = c.user_id where store_id = ?",[$sid]);
        
        $commentsDiv = "<div>";
        $set = false;
        if($comments->rowCount() > 0){

            while($row = $comments->fetch()){
                if(!$set){
                    $commentsDiv .= "<label class='col s12'>User Reviews</label>";
                    $set = true;
                }
                $text = $this->encode($row['comment']);
                $stars = $this->encode($row['stars']);
                $fname = $this->encode($row['firstname']);
                $sString = $this->rating($stars, 1, "part");
                
                $commentsDiv .="<div class='col s12 m6 row grey lighten-4 border-radius-1'>
                                    <span class='col s12'>$fname</span>
                                    <span class='col s12'>$sString</span>
                                    <span class='col s12'>$text</span>
                                </div>";
            }
        }
        
        $commentsDiv .= "</div>";
        
        return $commentsDiv;
    }
    
    function getStoreRating($id){
        $getRating = $this->query("select count(*) as reviewers, sum(stars) as totalStars from db.comments where store_id = ?",[$id]);
        $row = $getRating->fetch();
        $stars = $row['totalStars'];
        $reviewers = $row['reviewers'];
        
        return $this->rating($stars, $reviewers, "full");
    }
    
    function getFollowerCount($sid){
        
        $res = $this->query("select count(*) as ct from db.followers where storeId = ?",[$sid]);
        
        $row = $res->fetch();
        
        $ct = $row['ct'];
        
        return $ct;
    }
    
    function getStoreInvoiceCount($type){
        if(!$this->isLoggedIn()){
            if($type == "text"){
                echo "0";
            }else{
                echo '{"count": 0}';
            }
            return;
        }
        $id = $_SESSION['id'];
        $res = $this->query("select count(*) as ct from db.invoices i left join db.section s on s.id = i.store_id where s.user_id = ? and i.status = ? ",[$id, "NOT PAID"]);
        $row = $res->fetch();
        $ct = $row['ct'];
        
        if($type == "text"){
            echo $ct;
        }else{
            echo '{"count": '.$ct.'}';
        }
        
    }
    
    function getStoreMessageCount(){
        
    }
    
    function getStoreStatusMessage($sid){
        
        $res = $this->query("select status, paid, reason from db.section where id = ?",[$sid]);
        $row = $res->fetch();
        $paid = $row['paid'];
        $reason = $row['reason'];
        $status = $row['status'];
        $message = "";
        
        if($status == "PENDING"){
            $message = "<div style='width:90%; margin:auto; border-radius: 5px; padding: 5px; margin: 10px;' class='indigo lighten-4 indigo-text text-darken-4 center-align'>This store has not been verified yet</div>";
        }else if($status == "REJECTED"){
            $message = "<div style='width:90%; margin:auto; border-radius: 5px; padding: 5px; margin: 10px;' class='red lighten-4 red-text text-darken-4 center-align'>This store has been rejected<br>Reason: $reason</div>";
        }else if($status == "SUSPENDED"){
            $message = "<div style='width:90%; margin:auto; border-radius: 5px; padding: 5px; margin: 10px;' class='yellow lighten-4 yellow-text text-darken-4 center-align'>This store has been suspended<br>Reason: $reason</div>";
        }
        if($paid == "NOT PAID"){
            $message .= "<div style='width:90%; margin:auto; border-radius: 5px; padding: 5px; margin: 10px;' class='amber lighten-4 amber-text text-darken-4 center-align'>This store has not paid this month's charges</div>";
        }
        echo $message;
    }
}

$handler = new Handler();

function fowarder(){
    $handler = new Handler();
    if(isset($_GET['profile'])){
        $handler->getProfile();
    }else if(isset($_GET['store'])){
        $handler->getStore();
    }else if(isset($_GET['location'])){
        $id = $_GET['id'];
        $handler->getLocation($id);
    }else if(isset($_GET['locations'])){
        $handler->getLocations();
    }else if(isset($_GET['stores'])){
        $handler->getStores();
    }else if(isset($_GET['product'])){
        $handler->getProduct();
    }else if(isset($_GET['prod_images'])){
        $handler->getProduct();
    }else if(isset($_GET['productServiceListing'])){
        $handler->getProductListing();
    }else if(isset($_GET['getCartNum'])){
        $handler->getCartNum("json");
    }else if(isset($_GET['getAptNum'])){
        $handler->getAptNum("json");
    }else if(isset($_GET['checkAvailability'])){
        $handler->checkAvailability();
    }else if(isset($_GET['getCart'])){
        $handler->getCart();
    }else if(isset($_GET['getAppointments'])){
        $handler->getAppointments();
    }else if(isset($_GET['getStoreOrders'])){
        $handler->getStoreOrders();
    }else if(isset($_GET['getStoreAppointments'])){
        $handler->getStoreAppointments();
    }else if(isset($_GET['setIsLoggedIn'])){
        $handler->setIsLoggedIn();
    }else if(isset($_GET['getHours'])){
        $handler->getHours();
    }else if(isset($_GET['getLunchHours'])){
        $handler->getLunchHours();
    }else if(isset($_GET['getAvailability'])){
        $handler->getAvailability();
    }else if(isset($_GET['getStoreOrderCount'])){
        $handler->getStoreOrderCount("json");
    }else if(isset($_GET['getStoreAptCount'])){
        $handler->getStoreAptCount("json");
    }else if(isset($_GET['getDetailedStoreOrders'])){
        $handler->getDetailedStoreOrders();
    }else if(isset($_GET['getDetailedStoreApts'])){
        $handler->getDetailedStoreApts();
    }else if(isset($_GET['getFollowing'])){
        $handler->getFollowing($_GET['uid'], $_GET['sid'], "innerhtml");
    }else if(isset($_GET['getspecs'])){
        echo $handler->getSpecs($_GET['pid'], $_GET['category'], true, false);
    }else if(isset($_GET['getEnabled'])){
        $handler->getEnabled();
    }else if(isset($_GET['getStoreComments'])){
        echo $handler->getStoreComments($_GET['id']);
    }else if(isset($_GET['getStoreRating'])){
        echo $handler->getStoreRating($_GET["id"]);
    }else if(isset($_GET['getItemComments'])){
        echo $handler->getItemComments($_GET['id']);
    }else if(isset($_GET['getItemRating'])){
        echo $handler->getItemRating($_GET["id"]);
    }else if(isset($_GET['getInvoices'])){
        echo $handler->getInvoices();
    }else if(isset($_GET['getStoreInvoiceCount'])){
        echo $handler->getStoreInvoiceCount("json");
    }else if(isset($_GET['printInvoice'])){
        $handler->generateInvoice();
    }
        
}

fowarder();


?>