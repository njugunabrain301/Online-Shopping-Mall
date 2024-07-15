<?php
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Appointments <?php echo "| ".$title ?></title>
        <link type="text/css" rel="stylesheet" href='DataTables/datatables.min.css'>
        <script src='DataTables/datatables.min.js'></script>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src="js/appointment.js"></script>
        <script src="js/setCounts.js"></script>
        <content>
            <div id='appointments' class='container section center-align '>
                <div class='section right-align'>
                    <button class='btn-small green complex' onclick="fetchSimpleApt()">Simple</button>
                    <button class='btn-small green simple' onclick="fetchDetailedApt()">Detailed</button>
                </div>
                <div class='simple'>
                    <ul id='apt-menu' class='tabs hide-on-small-only'>
                    <li class='tab'>
                        <a href='#upcoming_div' class="apt_nav" onclick='checkReload()'>Upcoming <span class='up clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#past_div' class="apt_nav" onclick='checkReload()'>Past <span class='pa clue'></span> </a>
                    </li>
                    <li class='tab'>
                        <a href='#cancelled_div' class="apt_nav" onclick='checkReload()'>Cancelled<span class='ca clue'></span></a>
                    </li>
                </ul>
                    <div id='apt_ajax'>
                    <div id='upcoming_div' class='hide-on-small-only up-text'></div>
                    <div id='past_div' style='display: none' class='hide-on-small-only pa-text'></div>
                    <div id='cancelled_div' style='display: none' class='hide-on-small-only ca-text'></div>
                    
                    <ul class='collapsible hide-on-med-and-up'>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Upcoming Appointments <div class='up clue'></div></div>
                            <div class='collapsible-body up-text'></div></li>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Past Appointments <div class='pa clue'></div></div>
                            <div class='collapsible-body pa-text'></div></li>
                        <li>
                            <div class='collapsible-header green white-text' onclick='checkReload()'>Cancelled Appointments <div class='ca clue'></div></div>
                            <div class='collapsible-body ca-text'></div></li>
                    </ul>
                </div>
                </div>
            </div> 
            <div class='complex' style="max-width: 90%; min-width: 700px; margin: auto;">
                    <div id='data-div'>
                        <div class='data'>
                            <table id='apt-data-table'>
                                <thead>
                                    <th>Product Name</th>
                                    <th>Cost</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Client Name</th>
                                    <th>Client Phone</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id='apt-data'>
                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
        </content>
        <?php require_once "snippets/reason.php"?>
        <?php require_once "includes/footer.php"; ?>
        <script>
            tenant = true;
            reloadApts();
            reloadAptCounts();
            fetchSimpleApt();
        </script>
        <script src='js/initializations.js'></script>
    </body>
</html>