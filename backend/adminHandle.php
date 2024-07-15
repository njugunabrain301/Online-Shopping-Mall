<?php
require_once "Database.php";

class AdminHandle extends Database{
    
    function approveStore(){
        if(!$this->isAdmin()) return;
        $id = $_POST['id'];
        $this->query("update db.section set status = ?, admin_verified = ? where id = ?",["APPROVED", 1,$id]);
    }
    
    function declineStore(){
        if(!$this->isAdmin()) return;
        $id = $_POST['id'];
        $this->query("update db.section set status = ? where id = ?",["DECLINED",$id]);
    }
    
    function deleteStore(){
        if(!$this->isAdmin()) return;
        $id = $_POST['id'];
        $ext = $_POST['ext'];
        unlink("../images/sections/".$id.".".$ext);
        $res = $this->query("select im.product_id as pid, im.num as pnum, im.ext as pext from db.product_images im left join db.product p on im.product_id = p.id left join db.section s on s.id = p.web_id  where s.id = ?",[$id]);
        
        while($row = $res->fetch()){
            $imgName = $row['pid']."_".$row['pnum'].".".$row['pext'];
            unlink("../images/products/".$imgName);
        }
        
        $this->query("delete from db.section set status = ? where id = ?",["APPROVED",$id]);
    }
    
    function suspendStore(){
        if(!$this->isAdmin()) return;
        $id = $_POST['id'];
        $this->query("update db.section set status = ? where id = ?",["SUSPENDED",$id]);
    }
    
    function storePaid(){
        if(!$this->isAdmin()) return;
        $id = $_POST['id'];
        $this->query("update db.section set status = ? where id = ?",["APPROVED",$id]);
    }
    
    function generatePaymentLog(){
        require_once "fpdf/fpdf.php";
        
        $from = date($_POST['from']);
        $to = date($_POST['to']);
        
        $res = $this->query("select p.msisdn_id, p.msisdn_idnum, p.message, p.mc, p.p1, p.dateReceived, i.id as invId, s.id as sid, s.name as sname, i.purpose from db.ipay_payments p left join db.invoices i on i.txncd = p.txncd left join db.section s on s.id = i.store_id where DATE(p.dateReceived) <= DATE(?) && DATE(p.dateReceived) >= DATE(?)",[$to, $from]);
        
        $fpdf = new FPDF('p','mm','A4');
        
        $fpdf->AddPage();
        
        $fpdf->SetFont('Arial','B',18);
        
        $fpdf->cell(0, 13, "Shop Online", 0, 1, 'C');
        $fpdf->SetFont('Arial','B',16);
        $title = "Invoice records from ".date('M j, Y', strtotime($_POST['from']))." to ".date('M j, Y', strtotime($_POST['to']));
        $fpdf->cell(0, 13, $title, 0, 1, 'C');
        $fpdf->SetFont('Arial','B',10);
        $fpdf->cell(15, 10, "Inv. ID", 1, 0, '');
        $fpdf->cell(45, 10, "Store", 1, 0, '');
        $fpdf->cell(12, 10, "Amt", 1, 0, '');
        $fpdf->cell(45, 10, "Purpose", 1, 0, '');
        $fpdf->cell(23, 10, "Date Paid", 1, 0, '');
        $fpdf->cell(45, 10, "Client", 1, 0, '');
        $fpdf->cell(13, 10, "Status", 1, 1, '');
        
        
        $fpdf->SetFont('Arial','',12);
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
            
            $str = '[
                    "'.$invId.'",
                    "'.$sname.'",
                    "'.$amt.'",
                    "'.$purpose.'",
                    "'.$dateReceived.'",
                    "'.$idnum.'",
                    "'.$idname.'",
                    "'.$message.'"
                   ]';
            
            $fpdf->cell(15, 10, $invId, 1, 0, '');
            $fpdf->cell(45, 10, $sname, 1, 0, '');
            $fpdf->cell(20, 10, $amt, 1, 0, '');
            $fpdf->cell(45, 10, $purpose, 1, 0, '');
            $fpdf->cell(23, 10, $dateReceived, 1, 0, '');
            $fpdf->cell(45, 10, $idnum." - ".$idname, 1, 0, '');
            $fpdf->cell(13, 10, $message, 1, 1, '');
        }
        
        $fpdf->Output();
    }
}

$handle = new AdminHandle();

if(isset($_POST['approveStore'])){
    $handle->approveStore();
}else if(isset($_POST['declineStore'])){
    $handle->declineStore();
}else if(isset($_POST['deleteStore'])){
    $handle->deleteStore();
}else if(isset($_POST['suspendStore'])){
    $handle->suspendStore();
}else if(isset($_POST['storePaid'])){
    $handle->storePaid();
}else if(isset($_POST['generatePaymentLog'])){
    $handle->generatePaymentLog();
}

?>