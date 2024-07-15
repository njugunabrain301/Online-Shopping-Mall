<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Invoices <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
        <script src='DataTables/datatables.min.js'></script>
        <script src='js/invoice.js'></script>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <h3 class='center-align'>Invoices</h3>
            <div class='container'>
                    <div id='data-div'>
                        <div class='data'>
                            <table id='inv-data-table'>
                                <thead>
                                    <th>Invoice No.</th>
                                    <th>Puprose</th>
                                    <th>Amount</th>
                                    <th>Store</th>
                                    <th>Date Issued</th>
                                    <th>Date Paid</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </thead>
                                <tbody id='inv-data'>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </content>
        <?php require_once "snippets/payment.php"; ?>
        <?php require_once "includes/footer.php"; ?>
        <script>
            fetchInvoiceData();
        </script>
        <script src='js/initializations.js'></script>
    </body>
</html>

    
    
