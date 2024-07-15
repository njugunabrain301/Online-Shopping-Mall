<?php
    require_once "authentication.php";

    authenticateAdmin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Admin <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
        <script src='DataTables/datatables.min.js'></script>
        <script src='js/admin.js'></script>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <content>
            <h3 class='center-align'>Payments</h3>
            <div class='container'>
                    <a class='modal-trigger btn-small green white-text' href="#print-invoice">Print</a>
                    <div id='data-div'>
                        <div class='data'>
                            <table id='income-data-table'>
                                <thead>
                                    <th>Invoice Id</th>
                                    <th>Order Reference</th>
                                    <th>Store</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Date Received</th>
                                    <th>Client Number</th>
                                    <th>Client Name</th>
                                    <th>Status</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="modal change" id='print-invoice'>
                <span class='modal-close btn-small green closer'><i class='fas fa-times button'></i></span>
                <h5>Print Payment Records</h5>
                <form action='backend/adminHandle.php' method="post">
                    <label>Select dates</label><br>
                    <div class='input-field'>
                        <label>From</label>
                        <input type="date" name="from" required>
                    </div>
                    <div class='input-field'>
                        <label>To</label>
                        <input type="date" name="to" required>
                    </div>
                    <input type="submit" name='generatePaymentLog' value='Print' class='btn-small green'>
                </form>
            </div>
        </content>
    </body>
    <script>
        fetchIncomeData();
    </script>
    <?php require_once "includes/footer.php"; ?>
</html>