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
            <h3 class='center-align'>Stores</h3>
            <div class='container'>
                    <div id='data-div'>
                        <div class='data'>
                            <table id='stores-data-table'>
                                <thead>
                                    <th>Store Name</th>
                                    <th>Store Phone</th>
                                    <th>Store Email</th>
                                    <th>Store Type</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
        </content>
    </body>
    <?php require_once "includes/footer.php"; ?>
    <script>
        fetchStoresData();
    </script>
</html>