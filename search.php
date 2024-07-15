<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Search <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
            <div class='sidenav-trigger hide' data-target='menu-links' id='menu-links-trigger'>
                <i class='material-icons'>filter_list</i>
            Categories</div>
            <div id='menu-links' class='menu-nav'>
                <?php require_once "includes/menu.php";?>
            </div>
        <content>
            
            <div id='search-content' class='row container'>
                <div id='promotions' class='hide-on-med-and-down col l2'></div>
                <div id='products-div' class='col m12 l9 container section'>
                    <div id='search-box'>
                        <button class='top-btn'><i id='filter_btn' class='fas fa-filter'></i></button>
                        <form action='search.php' method='get'>
                            <div class='filter filter-hidden' id='filter-div'>
                                <span class='btn-small green filter-close' onclick="filterToggle()"><i class='fas fa-times'></i></span>
                                <p>
                                    <label>
                                        <input type='checkbox' name='f_stores' id='f_stores'>
                                        <span>Stores</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input type='checkbox' name='f_product' id='f_product'>
                                        <span>Products</span>
                                    </label>
                                </p>
                                <p>
                                    <label>
                                        <input type='checkbox' name='f_service' id='f_service'> 
                                        <span>Services</span>
                                    </label>
                                </p>
                                <div class='input-field'>
                                    <select type = "text" name="f_category" id='f_category'>
                                        <option>All Categories</option>
                                        <option>Phones & Accessories</option>
                                        <option>Televisions</option>
                                        <option>Sound System</option>
                                        <option>Electronics & Appliances</option>
                                        <option>Computers & Accessories</option>
                                        <option>Clothes & Accessories</option>
                                        <option>Shoes</option>
                                        <option>Furniture</option>
                                        <option>Learning Materials</option>
                                        <option>Food & Beverages</option>
                                    </select>
                                </div>
                                <div class='input-field'>
                                    <span style="width:45px; text-align:right; display:inline-block;" class='prefix'>From&nbsp;:&nbsp;</span><input type='number' name='f_from' value="0" id='f_from'><br>
                                </div>
                                <div class='input-field'>
                                    <span style="width:45px; text-align:right; display:inline-block;" class='prefix'>To&nbsp;:&nbsp;</span>
                                    <input type='number' name='f_to' value="1000000" id='f_to'><br>
                                </div>
                                <button type="submit" name='filter' value='apply' class='btn-small green'>Apply</button>
                                <button type="submit" name='filter_reset' value='reset' class='btn-small green float-right'>Reset</button>
                            </div>
                        </form>
                        <form action="search.php" method='get'>
                            <div class='search'>
                                <input type='text' name='search' placeholder="Search" id='search_field' required>
                                <button type='submit' class='top-btn'><i class='fas fa-search'></i></button>
                            </div>
                        </form>
                    </div>
                        <?php

                            require_once "backend/Handler.php";
                            $handler->getList("search.php","search");

                        ?>
                </div> 
            </div>
        </content>
        <?php require_once "includes/footer.php"; ?>
        <script src="js/filter.js"></script>
    </body>
</html>