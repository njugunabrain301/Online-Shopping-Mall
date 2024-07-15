<?php

require_once "Database.php";
@session_start();
class Customer extends Database{
    
    function addItemToCart(){
        if($this->isloggedIn()){
            $iid = $_POST['iid']; 
            $qty = $_POST['qty'];
            $uid = $_SESSION['id'];
            $locId = $_POST['pickup'];
            $this->query("insert into db.carts (itemId, userId, quantity, locationId,status) values (?,?,?,?,?)",[$iid, $uid, $qty,$locId,"PENDING"]);
        }
        
    }
    
    function addBookingToCart(){
        if($this->isloggedIn()){
            $iid = $_POST['iid']; 
            $time = $_POST['time'];
            $day = $_POST['date'];
            $uid = $_SESSION['id'];
            $loc = $_POST['loc'];
            
            $res = $this->query("select duration from db.product where id = ?",[$iid]);
            echo $day." ".$time;
            $row = $res->fetch();
            
            $dur = $row['duration'];
            $end = $time+($dur * 100);
            
            $this->query("insert into db.appointments (itemId, userId, start, end, day, locationId) values (?,?,?,?,?,?)",[$iid, $uid, $time, $end, $day, $loc]);
        }
    }
    
    function removeFromCart(){
        $this->checkLoggedIn();
        $cid = $_POST['cid'];
        
        $this->query("delete from db.carts where id = ?",[$cid]);
        
    }
    
    function removeFromApt(){
        $this->checkLoggedIn();
        $aid = $_POST['aid'];
        
        $this->query("delete from db.appointments where id = ?",[$aid]);
    }
    
    function rateCartItem(){
        $stars = $_POST['stars'];
        $cid = $_POST['id'];
        $comment = $_POST['comment'];
        $uid = $_SESSION['id'];
        $this->query("update db.carts c left join db.product p on c.itemId = p.id left join db.section s on p.web_id = s.id set c.stars = ?, s.number_of_stars = s.number_of_stars + ?, s.number_of_reviewers = s.number_of_reviewers + 1, c.status = ? , c.received = ? where c.id = ? ",[$stars, $stars, 'COMPLETE',  date('Y-m-d'), $cid]);
        
        $res = $this->query("select itemId from db.carts where id = ?",[$cid]);
        
        $row = $res->fetch();
        $iid = $row['itemId'];
        
        $this->query("INSERT INTO db.comments (item_id, comment, stars, user_id) values (?,?,?,?)",[$iid, $comment, $stars, $uid]);
        
    }
    
    function rateAptItem(){
        $stars = $_POST['stars'];
        $aid = $_POST['id'];
        
        $this->query("update db.appointments a left join db.product p on a.itemId = p.id left join db.section s on p.web_id = s.id set a.stars = ?, s.stars = s.stars + ?, s.sales = s.sales + 1, a.status = ? where a.id = ? ",[$stars, $stars, 'COMPLETE', $aid]);
    }
    
    function rateStore(){
        $stars = $_POST['stars'];
        $sid = $_POST['id'];
        $comment = $_POST['comment'];
        $uid = $_SESSION['id'];
        echo $comment;
        $this->query("INSERT INTO db.comments (store_id, comment, stars, user_id, source) values (?,?,?,?,?)",[$sid, $comment, $stars, $uid, "FREE"]);
    }
    
    function rateItem(){
        $stars = $_POST['stars'];
        $iid = $_POST['id'];
        $comment = $_POST['comment'];
        $uid = $_SESSION['id'];
                
        $this->query("INSERT INTO db.comments (item_id, comment, stars, user_id, source) values (?,?,?,?,?)",[$iid, $comment, $stars, $uid, "FREE"]);
    }
    
    function confirmCartPayment(){
        $this->checkLoggedIn();
        $cid = $_POST['cid'];
        $uid = $_SESSION['id'];

        if($cid == "all"){
            $this->query("update db.carts c left join db.product p on p.id = c.itemId set c.status = p.procurement , ordered = ? where c.userId = ?",[date('Y-m-d'), $uid]);
        }else{
            $this->query("update db.carts c left join db.product p on p.id = c.itemId set c.status = p.procurement , ordered = ? where c.id = ?",[ date('Y-m-d'), $cid]);
        }
    }
    
    function rescheduleBooking(){
        $aid = $_POST['aptId'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $iid = $_POST['iid'];
        
        $res = $this->query("select duration from db.product where id = ?",[$iid]);

        $row = $res->fetch();

        $dur = $row['duration'];
        $end = $time+($dur * 100);

        $this->query("update db.appointments set start = ?, end = ?, day = ? where id = ? ",[$time, $end, $date, $aid]);
        
        echo "rescheduled to ".$date." from $time to $end for $aid and iid $iid";
    }
    
    function follow(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $uid = $_POST['uid'];
        $sid = $_POST['sid'];
        
        $this->query("insert into db.followers (userId, storeId) values (?,?)",[$uid, $sid]);
        echo '{"okay": true, "message": "Successfull"}';
    }
    
    function unfollow(){
        if(!$this->isLoggedIn()){
            echo '{"okay": false, "message": "You are not logged in"}';
            return;
        }
        $uid = $_POST['uid'];
        $sid = $_POST['sid'];
        
        $this->query("delete from db.followers where userId = ? and  storeId = ?",[$uid, $sid]);
        echo '{"okay": true, "message": "Successfull"}';
    }
}

function foward(){
    $customer = new Customer();
    if(isset($_POST['addItemToCart'])){
        $customer->addItemToCart();
    }else if(isset($_POST['addBookingToCart'])){
        $customer->addBookingToCart();
    }else if(isset($_POST['removeFromCart'])){
        $customer->removeFromCart();
    }else if(isset($_POST['removeFromApt'])){
        $customer->removeFromApt();
    }else if(isset($_POST['confirmCartPayment'])){
        $customer->confirmCartPayment();
    }else if(isset($_POST['rateCartItem'])){
        $customer->rateCartItem();
    }else if(isset($_POST['rateAptItem'])){
        $customer->rateAptItem();
    }else if(isset($_POST['rescheduleBooking'])){
        $customer->rescheduleBooking();
    }else if(isset($_POST['follow'])){
        $customer->follow();
    }else if(isset($_POST['unfollow'])){
        $customer->unfollow();
    }else if(isset($_POST['rateStore'])){
        $customer->rateStore();
    }else if(isset($_POST['rateItem'])){
        $customer->rateItem();
    }
    
}

foward();

?>