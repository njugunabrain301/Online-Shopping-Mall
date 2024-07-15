<?php
    require_once "authentication.php";

    authenticateLoggedIn();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Appointments <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <script src="js/appointment.js"></script>
        <script src='js/setCounts.js'></script>
        <h4 class='center-align'>Appointments</h4>
        <content>
            <div id='appointments' class='container center-align'>
                <ul id='apt-menu' class='tabs hide-on-small-only'>
                    <li class='tab'>
                        <a href='#upcoming_div' class="apt_nav">Upcoming <span class='up clue'></span></a>
                        
                    </li>
                    <li class='tab'>
                        <a href='#past_div' class="apt_nav">Past <span class='pa clue'></span></a>
                    </li>
                    <li class='tab'>
                        <a href='#cancelled_div' class="apt_nav">Cancelled <span class='ca clue'></span></a>
                    </li>
                </ul>
                <div id='apt_ajax'>
                    <div id="upcoming_div" style="display: none" class="hide-on-small-only up-text"></div>
                    <div id="past_div" style="display: none" class="hide-on-small-only pa-text"></div>
                    <div id="cancelled_div" style="display: none" class="hide-on-small-only ca-text"></div>
                    <ul class="collapsible hide-on-med-and-up">
                         <li>
                            <div class="collapsible-header green white-text">Upcoming Appointments <div class="up clue"></div></div>
                             <div class="collapsible-body up-text"></div>
                        </li>
                        <li>
                        <div class="collapsible-header green white-text">Past Appointments   <div class="pa clue"></div></div>
                            <div class="collapsible-body pa-text"></div>
                        </li>
                        <li>
                            <div class="collapsible-header green white-text">Cancelled Appointments   <div class="ca clue"></div></div>
                            <div class="collapsible-body ca-text"></div>
                        </li>
                    </ul>
                </div>
            </div>    
        </content>
        <?php require_once "snippets/reschedule.php"; ?>
        <?php require_once "snippets/rate.php"; ?>
        <?php require_once "includes/footer.php"; ?>
        <script>
            reloadApts();
        </script>
        <script src='js/initializations.js'></script>
    </body>
</html>