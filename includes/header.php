<?php
    require_once "backend/Handler.php";
    $loggedIn = false;
    $utype = "customer";
    $class = '';
    if(isset($_SESSION['id'])){
        $loggedIn = true;
        $utype = $_SESSION['type'];
        if($utype == "tenant" || $utype == "admin"){
            $class = 'class="dark"';
        }
    }
?>
<header <?php echo $class; ?> >  
    <nav class='transparent black-text '>
        <h1><?php echo $title; ?></h1>
        <div class='right'>
            <div class='sidenav-trigger hide' data-target='nav-links' id='nav-links-trigger'>
                <i class='fas fa-bars'></i>
            </div>
            <div class='header-nav' id='nav-links'>
                <?php
                @session_start();
                if(!$loggedIn){


                    //Not Logged in
                ?>
                    <div class='profile-area'>
                            <a class='img' href='login.php'><img src='images/website/bg3.jpg'/></a>
                        </div>
                    <a href='index.php'><button>Home</button></a>
                    <a href='login.php'><button>Login</button></a>
                    <a href='register.php'><button>Register</button></a>
                <?php
                }else{
                    ?>
                    <div class='profile-area'>
                            <a class='img' href='profile.php'><img src='<?php echo $_SESSION['profile-image'] ?>' class='profile-img'/></a>
                        </div>
                    <?php
                    //Logged in
                    if($utype == "tenant"){
                        ?>
                        <a href='TenantDashboard.php'><button>Dashboard</button></a>
                        <a href='profile.php'><button>My Account</button></a>
                        <a href='invoice.php'><button>Invoices</button><span class='green note' id='invoice-ct'><?php echo $handler->getStoreInvoiceCount("text")?></span></a>
<!--                        <a href='messages.php'><button>Messages</button><span class='green note'>0</span></a>-->
                        <a href='myStores.php'><button>My Stores</button></a>
                <?php 
                    }else if($utype == "customer"){
                    ?>
                        <a href='index.php'><button>Home</button></a>
                        <a href='profile.php'><button>My Account</button></a>
                        <a href='cart.php'><button>Cart</button><span id='cart_count' class='green'><?php $handler->getCartNum("text") ?></span></a>
                        <a href='appointments.php'><button>Appointments</button><span id='apt_count' class='green'><?php $handler->getAptNum("text") ?></span></a>
                    <?php
                    }else if($utype == "ADMIN"){
                    ?>
                        <a href='AdminDashboard.php'><button>Dashboard</button></a>
                        <a href='AdminStores.php'><button>Stores</button></a>
                        <a href='AdminIncome.php'><button>Income</button></a>
                    <?php
                    }
                ?>
                    <a href='backend/User.php?logout=true'><button>Logout</button></a>
                <a class='img full-profile-area' href='profile.php'><div><img src='<?php echo $_SESSION['profile-image'] ?>' class='profile-img'/></div></a>
                <?php
                }
                ?>
                <div class='row header-hidden'><span class='divider col s12'></span></div>
                <ul class='header-hidden'>
                    <li><a href='#' class='grey-text text-darken-1 '><i class='material-icons '>message</i>FAQs</a></li>
                    <li><a href='#' class='grey-text text-darken-1 '><i class='material-icons '>email</i>Contact Us</a></li>
                    <li><a href='#' class='grey-text text-darken-1 '><i class='material-icons '>report_problem</i>Report Issue</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>