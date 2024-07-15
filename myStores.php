<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> My Stores <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='container'>
            <h4 class='center-align'>My Stores</h4>
            <a href='requeststall.php'><button class='btn-small green left-align'>Request Stall</button></a>
            <div id='ajax_stores' class='center-align section'>
                <?php
                    require_once "backend/Handler.php";
                    $handler->getStores();
                ?>
            </div>
            <a href='#request-message' class='modal-trigger hide' id='requestSectionModal'></a>
            <div id='request_message' class='modal change'>
                <button class='btn-small modal-close green'><i class='fas fa-times'></i></button>
                <br><br>
                <?php
                    $exists = 'false';
                    if(isset($_GET['requestWebSection'])){
                        $exists = 'true'; 
                        if($_GET['requestWebSection'] == "success"){
                            echo "<h4>Response</h4><p>Request has been sent to the Administrator. You need to pay a One Time Inspection Fee of Ksh 100 before we visit your premises to verify your business and location. <a href='#why-modal' class='modal-trigger'>Why ?</a></p> <a class='btn-small green white-text' href='invoice.php'>Pay Now</a>";
                        }else{
                            echo "<h4>Response</h4><p>Failed to send request. Please check try again after a few minutes. Thank you.</p>";
                        }
                    }
                ?>
                <br><br>
            </div>
        </div>
        <div class='modal change' id='why-modal'>
            <button class='btn-small modal-close green'><i class='fas fa-times'></i></button>
            <h4>One Time Inspection Fee</h4>
            <p>We perform a routine initial check on all new stores. We do this in order to verify that the store is real and that the premises is in the stated location. The information you provided in your store profile is cross-checked and validated. Depending on the outcome of this check you are either approved or advised on the changes you need to make.</p>
        </div>
        <?php require_once "includes/footer.php"; ?>
        <script src='js/initializations.js'></script>
        <script>
                $(document).ready(function(){
                   var exists = <?php echo $exists; ?>;
                    if(exists == true){
                        $("#request_message").modal();
                        $("#request_message").modal('open');

                    } 
                });
            </script>
    </body>
</html>