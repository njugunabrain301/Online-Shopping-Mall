<?php
require_once "Database.php";
@session_start();

class Tenant extends Database{
    
    function uploadProduct(){
        $this->checkLoggedIn();
        $sname = $_POST['store_name'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $store_id = $_POST['store_id'];
        $description = $_POST['description'];
        $folder = "../images/products/";
        $uploadOk = 1;
        $user_id = $_SESSION['id'];
        $index = md5(microtime());
        $search = $name.$type.$category;

        $this->query("insert into db.product (id, name, type, amount, price, web_id, description, category, search, classification) values (?,?,?,?,?,?,?,?,?,?)",[$index, $name, $type, $quantity, $price, $store_id, $description,$category,$search,"PRODUCT"]);
        if($category == "Shoes"){
            $colors = $_POST['colors'];
            $sizes = $_POST['sizes'];
            $brand = $_POST['brand'];
            $this->query("insert into db.shoes (pid, number, colors, brand) values (?,?,?,?)",[$index, $sizes, $colors, $brand]);
        }else if(strpos($category,"Clothes") !== false){
            $colors = $_POST['colors'];
            $sizes = $_POST['sizes'];
            $brand = $_POST['brand'];
            $this->query("insert into db.clothes (pid, size, colors, brand) values (?,?,?,?)",[$index, $sizes, $colors, $brand]);
        }else if($category == "Televisions"){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $display = $_POST['display'];
            $this->query("insert into db.televisions (pid, inches, make, model, display) values (?,?,?,?,?)",[$index, $inches, $make, $model, $display]);
        }else if(strpos($category,"Phones") !== false){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $memory = $_POST['memory'];
            $storage = $_POST['storage'];
            $fcamera = $_POST['fcamera'];
            $bcamera = $_POST['bcamera'];
            $bcapacity = $_POST['bcapacity'];
            $this->query("insert into db.phones (pid, screenSize, make, model, ram, storage, backCamera, frontCamera, batteryCapacity) values (?,?,?,?,?,?,?,?,?)",[$index, $inches, $make, $model, $memory, $storage, $bcamera, $fcamera, $bcapacity]);
        }else if(strpos($category,"Computers") !== false){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $memory = $_POST['memory'];
            $storage = $_POST['storage'];
            $pspeed = $_POST['pspeed'];
            $ptype = $_POST['ptype'];
            $this->query("insert into db.computers (pid, screenSize, make, model, ram, storage, processorSpeed, processorType) values (?,?,?,?,?,?,?,?)",[$index, $inches, $make, $model, $memory, $storage, $pspeed, $ptype]);
        }
        for($i = 0;$i<count($_FILES['image']['name']) ;$i++){
            $type = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
            $target_file = $folder.$index."_".$i.".".$type;
            if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if($uploadOk == 1){
                $this->query("insert into db.product_images (product_id, ext, num) values (?,?,?)",[$index, $type, $i]);
            }
        }
        
        if($uploadOk == 1){
            $this->goToPage("../viewproducts.php?store_id=$store_id&success=Success&name=$sname");
        }else{
            $this->goToPage("../addproduct.php?store_id=$store_id&error=fail&name=$sname");
        }
    }
    
    function modifySpec(){
        
        $category = $_POST['category'];
        $index = $_POST['pid'];
        if($category == "Shoes"){
            $colors = $_POST['colors'];
            $sizes = $_POST['sizes'];
            $brand = $_POST['brand'];
            $this->query("update db.shoes set number = ? , colors = ? , brand = ? where pid = ?",[$sizes, $colors, $brand, $index]);
        }else if(strpos($category,"Clothes") !== false){
            $colors = $_POST['colors'];
            $sizes = $_POST['sizes'];
            $brand = $_POST['brand'];
            $this->query("update db.clothes set size = ?, colors = ?, brand = ? where pid = ?",[$sizes, $colors, $brand, $index]);
        }else if($category == "Televisions"){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $display = $_POST['display'];
            $this->query("update db.televisions set inches = ?, make = ?, model = ?, display = ? where pid = ?",[$inches, $make, $model, $display, $index]);
        }else if(strpos($category,"Phones") !== false){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $memory = $_POST['memory'];
            $storage = $_POST['storage'];
            $fcamera = $_POST['fcamera'];
            $bcamera = $_POST['bcamera'];
            $bcapacity = $_POST['bcapacity'];
            $this->query("update db.phones set screenSize = ?, make = ?, model = ?, ram = ?, storage = ?, backCamera = ?, frontCamera = ?, batteryCapacity = ? where pid = ?",[$inches, $make, $model, $memory, $storage, $bcamera, $fcamera, $bcapacity, $index]);
        }else if(strpos($category,"Computers") !== false){
            $inches = $_POST['inches'];
            $make = $_POST['make'];
            $model = $_POST['model'];
            $memory = $_POST['memory'];
            $storage = $_POST['storage'];
            $pspeed = $_POST['pspeed'];
            $ptype = $_POST['ptype'];
            $this->query("update db.computers set screenSize = ?, make = ?, model = ?, ram = ?, storage = ?, processorSpeed = ?, processorType = ? where pid = ?",[$inches, $make, $model, $memory, $storage, $pspeed, $ptype, $index]);
        }
    }
    
    function addService(){
        $this->checkLoggedIn();
        $name = $_POST['name'];
        $type = $_POST['type'];
        $description = $_POST['description'];
        $quantity = $_POST['duration'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $store_id = $_POST['store_id'];
        $folder = "../images/products/";
        $uploadOk = 1;
        $user_id = $_SESSION['id'];
        $index = md5(microtime());
        $search = $name.$type.$category;
        $this->query("insert into db.product (id, name, type, duration, price, web_id, description, category, search, classification) values (?,?,?,?,?,?,?,?,?,?)",[$index, $name, $type, $quantity, $price, $store_id, $description, $category,$search,"SERVICE"]);
        for($i = 0;$i<count($_FILES['image']['name']) ;$i++){
            $type = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
            $target_file = $folder.$index."_".$i.".".$type;
            if (move_uploaded_file($_FILES["image"]["tmp_name"][$i], $target_file)) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if($uploadOk == 1){
                $this->query("insert into db.product_images (product_id, ext, num) values (?,?,?)",[$index, $type, $i]);
                
            }
        }
        
        if($uploadOk == 1){
            $this->goToPage("../viewproducts.php?store_id=$store_id&success=Success");
        }else{
            $this->goToPage("../addservice.php?store_id=$store_id&error=fail");
        }  
    }
    
    function closeOrder(){
        
    }
    
    function saveChanges(){
        if(!$this->isLoggedIn()){
            return;
        }
        $name = $_POST['name'];
        $type = $_POST['type'];
        $qty = $_POST['qty'];
        $description = $_POST['description'];
        $pkg = $_POST['pkg'];
        $id = $_POST['id'];

        if($pkg == "service"){
            $this->query("update db.product set name = ? , type = ? , duration = ? , description = ? , duration = ? where id = ? ",[$name, $type, $qty, $description, $qty, $id]);    
        }else{
            $this->query("update db.product set name = ? , type = ? , amount = ? , description = ? , amount = ? where id = ? ",[$name, $type, $qty, $description, $qty, $id]);
        }
        
    }
    
    function removeImage(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $img_id = $_POST['img_id'];
        $name = $_POST['name'];
        
        unlink("../".$name);
        $this->query("delete from db.product_images where id = ?",[$img_id]);
        echo '{"okay": true, "message": ""}';
    }
    
    function makePayment($invId, $amt, $txncd){
        
        $res = $this->query("select reference, store_id from db.invoices where id = ? and amount = ?",[$invId, $amt]);
        
        if($res->rowCount() == 1){
            $row = $res->fetch();
            $ref = $row['reference'];
            $sid = $row['store_id'];
            
            $reffArr = explode("_",$ref);
            
            if(count($reffArr) > 1) {
                if($reffArr[1] == "INSPECTION"){
                    $this->query("update db.section set admin_verified = -1 where id = ?",[$sid]);
                }else if($reffArr[1] == "CHANGE"){
                    $package = strtolower($reffArr[2]);
                    $this->query("update db.section set type = ? where id = ?",[$package, $sid]);
                }else if($reffArr[2] == "RENEWAL"){
                    $res = $this->query("select paid_until from db.section where id = ?",[$sid]);
                    $row = $res->fetch();
                    $paid_until = $row['paid_until'];
                    
                    $paidTime = strtotime($paid_until);
                    $now = time();
                    
                    $diff = $paidTime - $now;
                    
                    if($diff < 0){
                        $date = date_create(date('Y-m-d', $now));
                        date_add($date, $date_interval_create_from_date_string("31 days"));
                        $paid_until = date_format($date, 'Y-m-d');
                    }else{
                        $date = date_create($paid_until);
                        date_add($date, $date_interval_create_from_date_string("31 days"));
                        $paid_until = date_format($date, 'Y-m-d');
                    }
                    
                    $this->query("update db.section set paid = ?, paid_until = ? where id = ?",["PAID", $paid_until, $sid]);
                }
            }
            
            $this->query("update db.invoices set status = ? , datePaid = ?, txncd = ? where id = ? and amount = ?",["PAID", date('Y-m-d'), $txncd, $invId, $amt]);   
        }
    }
    
    function recordPayment($query, $arr){
        $this->query($query, $arr);
    }
    
    function generateInvoice($store_id, $uid, $type){
        $res = $this->query("select email from db.user where id = ?",[$uid]);
        $row = $res->fetch();
        $email = $row['email'];
        
        $amt = 499;
        
        if($type == "bronze"){
            $amt = 499;
        }else if($type == "silver"){
            $amt = 1199;
        }else if($type == "gold"){
            $amt = 1999;
        }else if($type == "diamond"){
            $amt = 2399;
        }else if($type == "platinum"){
            $amt = 3999;
        }
        $purpose = "Purchasing the ".strtoupper($type)." package";
        $to = $email;
        $subj = "Invoice";
        $msg = "<center></center>";
        $from = 'response@buynsell.co.ke';
        $name = 'Market Palace';

        
        $this->query("insert into db.invoices (store_id, purpose, amount, reference, dateIssued) values (?,?,?,?,?)",[$store_id, "One time inspection fee", 100, $store_id."_INSPECTION", date('Y-m-d')]);
        
//        $this->sendEmail($to,$from, $name ,$subj, $msg)
        
        $this->query("insert into db.invoices (store_id, purpose, amount, dateIssued) values (?,?,?,?)",[$store_id, $purpose,$amt, date('Y-m-d')]);
        
        $msg = "<center></center>";
        
//        $this->sendEmail($to,$from, $name ,$subj, $msg)
    }
    
    function requestWebSection(){
        $this->checkLoggedIn();
        $package = $_POST['package'];
        $street = $_POST['street'];
        $building = $_POST['building'];
        $stall = $_POST['stall'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $description = $_POST['description'];
        $hours = $_POST['hours'];
        $lunchhours = $_POST['lunchhours'];
        $weekends = $_POST['weekends'];
        $holidays = $_POST['holidays'];
        $capacity = $_POST['capacity'];
        $addressDesc = $_POST['addressDescription'];
        $folder = "../images/sections/";
        $website = $_POST['website'];
        $uploadOk = 1;
        $user_id = $_SESSION['id'];
        $index = md5(microtime());
        $type = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $target_file = $folder.$index.".".$type;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
        
        if($uploadOk == 1){
            $this->query("insert into db.section (id, type, name, description, user_id, ext, phone, email,hours, lunchbreak, weekends, holidays, capacity, website, dateCreated) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[$index, $package, $name, $description, $user_id, $type, $phone, $email,$hours, $lunchhours,$weekends, $holidays, $capacity, $website, date('Y-m-d')]);
            $this->query("insert into db.locations (street, building, stall, web_id, description) values (?,?,?,?,?)",[$street, $building, $stall, $index, $addressDesc]);
            
            $this->generateInvoice($index, $user_id, $package);
            
            $this->goToPage("../myStores.php?requestWebSection=success");
        }else{
            $this->goToPage("../myStores.php?requestWebSection=fail");
        }
        
    }
    
    function deleteSection(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $id = $_POST['id'];
        if($_POST['type'] == "store"){
            
            $res = $this->query("select count(*) as ct from (select itemId from db.carts c left join db.product p on p.id = c.itemId left join db.section s on s.id = p.web_id where s.id = ? AND (c.status = ? OR c.status = ?) union select itemId from db.appointments a left join db.product p on p.id = a.itemId left join db.section s on s.id = p.web_id where s.id = ? AND a.status = ? ) as table1",[$id, "DELIVERY","PICK UP",$id,"PENDING"]);
        
            $row = $res->fetch();
            $ct = $row['ct'];
            if($ct > 0){
                echo '{"okay" : false, "message": "You have pending orders on products from this store"}';
            }else{
                $res = $this->query("select ext from  db.section where id = ?",[$id]);
                $row = $res->fetch();
                $ext = $row['ext'];
                @unlink("../images/sections/$id.$ext");
                $res2 = $this->query("select im.product_id as pid, im.num as pnum, im.ext as pext from db.product_images im left join db.product p on im.product_id = p.id left join db.section s on s.id = p.web_id  where s.id = ?",[$id]);
                
                while($row2 = $res2->fetch()){
                    $imgName = $row2['pid']."_".$row2['pnum'].".".$row2['pext'];
                    unlink("../images/products/".$imgName);
                    $this->query("update db.product set status = ? where id = ?",["DELETED", $row2['pid']]);
                }
                $this->query("delete from db.product where status = ?",["DELETED"]);
                $this->query("delete from db.section where id = ?",[$id]);
//                $this->query("update db.product p left join db.section s on s.id = p.web_id set p.status = ? where s.id = ?",["DELETED",$id]);
                echo '{"okay" : true}';
            }
        }
    }
    
    function manageStore(){
        $this->checkLoggedIn();
        $id = $_POST['id'];
        $new = @$_POST['new'];
        $store_name = @$_POST['store_name'];
        $res = $this->query("select ext, email, id from db.section where id = ?",[$id]);
        $row = $res->fetch();
        $email = $row['email'];
        $ext = $row['ext'];
        $store_id = $row['id'];
        
        $out = '{"type": false}';
        
        if(isset($_POST['changeSname'])){
            $this->query("update db.section set name = ? where id = ?",[$new, $id]);
        }else if(isset($_POST['changeStype'])){
            
            $type = $new;
            $amt = 499;

            if($type == "bronze"){
                $amt = 499;
            }else if($type == "silver"){
                $amt = 1199;
            }else if($type == "gold"){
                $amt = 1999;
            }else if($type == "diamond"){
                $amt = 2399;
            }else if($type == "platinum"){
                $amt = 3999;
            }
            
            $out = '{"type": true}';
            
            $purpose = "Upgrade to ".strtoupper($type)." package";
            $to = $email;
            $subj = "Invoice";
            $msg = "<center></center>";
            $from = 'response@buynsell.co.ke';
            $name = 'Market Palace';

            $this->query("insert into db.invoices (store_id, purpose, amount, dateIssued, reference) values (?,?,?,?,?)",[$store_id, $purpose,$amt, date('Y-m-d'), $store_id."_CHANGE_".$type]);

            $msg = "<center></center>";

    //        $this->sendEmail($to,$from, $name ,$subj, $msg);
            
            
        }else if(isset($_POST['changeSemail'])){
            $this->query("update db.section set email = ? where id = ?",[$new, $id]);
        }else if(isset($_POST['changeSphone'])){
            $this->query("update db.section set phone = ? where id = ?",[$new, $id]);
        }else if(isset($_POST['changeDesc'])){
            $this->query("update db.section set description = ? where id = ?",[$new, $id]);
        }else if(isset($_POST['changeSwebsite'])){
            $this->query("update db.section set website = ? where id = ?",[$new, $id]);
        }else if(isset($_POST['changeImage'])){
            $folder = "../images/sections/";
            $type = strtolower(pathinfo($_FILES['new']['name'], PATHINFO_EXTENSION));
            unlink($folder.$id.".".$ext);
            $target_file = $folder.$id.".".$type;
            if (move_uploaded_file($_FILES["new"]["tmp_name"], $target_file)) {
                $uploadOk = 1;
                $this->query("update db.section set ext = ? where id = ?",[$type, $id]);
            } else {
                $uploadOk = 0;
            }
            $this->goToPage("../editStore.php?type=store&id=$id&name=$store_name");
        }
        echo $out;
    }
    
    function modifyLocation(){
        $this->checkLoggedIn();
        $id = $_POST['id'];
        $street =$_POST['street'];
        $building =$_POST['building'];
        $stall =$_POST['stall'];
        $description = $_POST['description'];
        $this->query("update db.locations set street = ? , building = ? , stall = ?, description = ? where id = ?",[$street, $building, $stall, $description, $id]);
        
    }
    
    function addLocation(){
        $this->checkLoggedIn();
        $id = $_POST['id'];
        $street =$_POST['street'];
        $building =$_POST['building'];
        $stall =$_POST['stall'];
        $description = $_POST['description'];
        $this->query("insert into db.locations (street, building, stall, web_id, description) values(?,?,?,?,?)",[$street, $building, $stall, $id, $description]);
        
    }
    
    function deleteLocation(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $id = $_POST['id'];
        $this->query("delete from db.locations where id = ?",[$id]);
        echo '{"okay": true, "message": ""}';
    }
    
    function addImages(){
        if(!$this->isLoggedIn()){
            return;
        }
        $folder = "../images/products/";
        $uploadOk = 1;
        $user_id = $_SESSION['id'];
        $index = $_POST['prod_id'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $res = $this->query("select max(num) as num from db.product_images where product_id = ?",[$index]);
        $row = $res->fetch();
        $count = $row['num']+1;
        for($i = 0;$i<count($_FILES['files']['name']) ;$i++){
            $c = $count + $i;
            $type = strtolower(pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION));
            $target_file = $folder.$index."_".$c.".".$type;
            if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            if($uploadOk == 1){
                $this->query("insert into db.product_images (product_id, ext, num) values (?,?,?)",[$index, $type, $c]);
                
            }
        }
        
        if($uploadOk == 1){
            $this->goToPage("../viewItem.php?id=$index&item_name=$name&type=$type&success=Success");
        }else{
            $this->goToPage("../viewItem.php?id=$index&item_name=$name&type=$type&error=error");
        }
    }
    
    function addListing(){
        if(!$this->isLoggedIn()){
            return;
        }
        $pid = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $temp = md5(microtime());
        
        $type = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        $this->query("insert into db.product_listing (web_id, listing, title, ext, tempIndex) values (?,?,?,?,?)",[$pid, $content, $title, $type,$temp]);
        
        $res = $this->query("select * from db.product_listing where tempIndex = ?",[$temp]);
        
        if($res->rowCount() == 0){
            return;
        }
        
        $row = $res->fetch();
        $index = $row['id'];

        $target_file = "../images/features/".$index.".".$type;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }

    }
    
    function removeListing(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $id = $_POST['id'];
        
        $this->query("delete from db.product_listing where id = ?",[$id]);
        echo '{"okay": true, "message": ""}';
    }
    
    function cancelApt(){
        if(!$this->isLoggedIn()){
            return;
        }
        $aid = $_POST['aid'];
        $reason = $_POST['reason'];
        
        $this->query("update db.appointments set status = ? , reason = ? where id = ?",["CANCELLED",$reason, $aid]);
        
    }
    
    function cancelCartItem(){
        if(!$this->isLoggedIn()){
            return;
        }
        $cid = $_POST['cid'];
        $reason = $_POST['reason'];
        
        $this->query("update db.carts set status = ? , reason = ? where id = ?",["CANCELLED",$reason, $cid]);
        
    }
    
    function addHours(){
        if(!$this->isLoggedIn()){
            return;
        }
        $from = $_POST['from'];
        $to = $_POST['to'];
        $id = $_SESSION['id'];
        
        $to = str_replace(":","",$to);
        $from = str_replace(":","",$from);
        
        $res = $this->query("insert into db.hours (start, end, userId) values (?,?,?)",[$from, $to, $id]);
    }
    
    function addLunchHours(){
        if(!$this->isLoggedIn()){
            return;
        }
        $from = $_POST['from'];
        $to = $_POST['to'];
        $id = $_SESSION['id'];
        $to = str_replace(":","",$to);
        $from = str_replace(":","",$from);
        echo $from." - ".$to;
        $res = $this->query("insert into db.lunchhours (start, end, userId) values (?,?,?)",[$from, $to, $id]);
    }
    
    function modifyAvailability(){
        if(!$this->isLoggedIn()){
            return;
        }
        $id = $_POST['id'];
        $hours = $_POST['hours'];
        $lunch = $_POST['lunch'];
        $weekends = $_POST['weekends'];
        $holidays = $_POST['holidays'];
        
        $this->query("update db.section set hours = ?, lunchbreak = ?, weekends = ?, holidays = ? where id = ?",[$hours, $lunch, $weekends, $holidays, $id]);
    }
    
    function deleteProduct(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $id = $_POST['id'];
        $res = $this->query("select count(*) as ct from (select itemId from db.carts c where c.itemId = ? AND (c.status = ? OR c.status = ?) union select itemId from db.appointments a where a.itemId = ? AND status = ? ) as table1",[$id, "DELIVERY","PICK UP",$id,"PENDING"]);
        
        $row = $res->fetch();
        $ct = $row['ct'];
        if($ct > 0){
            echo '{"okay" : false}';
        }else{
            $this->deleteProductWithId($id);
            $res2 = $this->query("select im.product_id as pid, im.num as pnum, im.ext as pext from db.product_images im left join db.product p on im.product_id = p.id left join db.section s on s.id = p.web_id  where p.id = ?",[$id]);
                
            while($row2 = $res2->fetch()){
                $imgName = $row2['pid']."_".$row2['pnum'].".".$row2['pext'];
                unlink("../images/products/".$imgName);
                $this->query("update db.product set status = ? where id = ?",["DELETED", $row2['pid']]);
            }
            $this->query("delete from db.product where status = ?",["DELETED"]);
//            $this->query("update db.product set status = ? where id = ?",["DELETED",$id]);
            echo '{"okay" : true}';
        }
    }
    
    private function deleteProductWithId($id){
        
    }
    
    function deleteInvoice(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        
        $id = $_POST['id'];
        
        $this->query("delete from db.invoices where id = ?",[$id]);
        
        echo '{"okay" : true}';
    }
}

function fowarder(){
    $tenant = new Tenant();
    if(isset($_POST['requeststall'])){
        $tenant->requestWebSection();
    }else if(isset($_POST['delete'])){
        $tenant->deleteSection();
    }else if(isset($_POST['manageStore'])){
        $tenant->manageStore();
    }else if(isset($_POST['modifyLocation'])){
        $tenant->modifyLocation();
    }else if(isset($_POST['addLocation'])){
        $tenant->addLocation();
    }else if(isset($_POST['deleteLocation'])){
        $tenant->deleteLocation();
    }else if(isset($_POST['addProduct'])){
        $tenant->uploadProduct();
    }else if(isset($_POST['addService'])){
        $tenant->addService();
    }else if(isset($_POST['saveChanges'])){
        $tenant->saveChanges();
    }else if(isset($_POST['removeImage'])){
        $tenant->removeImage();
    }else if(isset($_POST['addImages'])){
        $tenant->addImages();
    }else if(isset($_POST['addProductServiceListing'])){
        $tenant->addListing();
    }else if(isset($_POST['removeProductServiceListing'])){
        $tenant->removeListing();
    }else if(isset($_POST['cancelApt'])){
        $tenant->cancelApt();
    }else if(isset($_POST['cancelCartItem'])){
        $tenant->cancelCartItem();
    }else if(isset($_POST['addHours'])){
        $tenant->addHours();
    }else if(isset($_POST['addLunchHours'])){
        $tenant->addLunchHours();
    }else if(isset($_POST['modifyAvailability'])){
        $tenant->modifyAvailability();
    }else if(isset($_POST['deleteProduct'])){
        $tenant->deleteProduct();
    }else if(isset($_POST['modifyCategory'])){
        $tenant->modifySpec();
    } 
}
fowarder();

?>