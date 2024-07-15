<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html id='reports-page'>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Admin <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
        <script src='DataTables/datatables.min.js'></script>
        <link type="text/css" rel="stylesheet" href="Charts/Chart.min.css">
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <h4 class='center-align'>Statistics</h4>
        <div class='container center-align'>
            <div class='flex-wrap-center report-filter row'>
                <div class='input-field col s12 m6'>
                    <select id='store-selected' onchange="getReport()">
                        <option value='All Stores'>All Stores</option>
                        <?php
                            $handler->getStoresSelect();
                        ?>
                    </select>
                </div>
                <div class='input-field col s6 m3'>
                    <label>From</label>
                    <input type='text' id='from-date' class='datepicker' onchange="getReport()">
                </div>
                <div class='input-field col s6 m3'>
                    <label>To</label>
                    <input type='text' id='to-date' class='datepicker' onchange="getReport()">
                </div>
            </div>
            <h5 class='center'><span id='store-name'></span></h5>
            <div id='data-div'>
                <div class='data'>
                    <h6 id='chartTitle'></h6>
                    <canvas id='myChart'></canvas>
                </div>
                <div class='data'>
                    <h6 id='tableTitle'>Detailed</h6>
                    <div id='ajax-report'>

                    </div>
                </div>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
        <script src='Charts/Chart.min.js'></script>
        <script src='js/reports.js'></script>
        <script>
            $(".datepicker").datepicker();
        </script>
    </body>
</html>