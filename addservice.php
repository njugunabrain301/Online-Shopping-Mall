<?php
    @session_start();
    require_once "authentication.php";

    authenticateTenant();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once "includes/links.php"; ?>
        <title> Add Service <?php echo "| ".$title ?></title>
    </head>
    <body>
        <?php require_once "includes/header.php"; ?>
        <div class='container'>
            <?php
                $num = rand(1,4);
            ?>
            <div class='form addForm form-small'>
                <img src='images/website/add-service-image<?php echo $num?>.jpg'>
                <div class='right'>
                    <img src='images/website/menu-bg.jpg'>
                    <form action="backend/Tenant.php" method="post" enctype="multipart/form-data" onsubmit="return validate_add_service(this)">
                        <h4 class='center-align'>Add Service</h4>
                        <div class='input-field'>
                            <label>Name</label>
                            <input type="text" name="name" maxlength="18" required>
                        </div>
                        <div class='input-field'>
                            <label>Type</label>
                            <input type="text" name="type" maxlength="20" required>
                        </div>
                            <input type='hidden' name='store_id' value='<?php echo $_GET['store_id']?>'>
                        <div class='input-field'>
                            <select type = "text" name="category" id='select' required>
                                <optgroup>
                                    <option disabled selected> Select category</option>
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
                                    <option>Other</option>
                                </optgroup>
                            </select>
                        </div>
                        <div class='input-field'>
                            <label>Description</label>
                            <textarea name="description" class='materialize-textarea' required minlength="40" maxlength="255"></textarea>
                        </div>
                        <div class='input-field'>
                            <label>Duration (in hours)</label>
                            <input type="number" name="duration" required min="0.1" max="2400">
                        </div>
                        <div class='input-field'>
                            <label>Price</label>
                            <input type="number" name="price" required min="1" max="499999">
                        </div>
                        <div class='file-field input-field'>
                            <div class='btn-small grey'>
                                <span>Add image</span>
                                <input type="file" name="image[]" multiple id='images'>
                            </div>
                            <div class='file-path-wrapper'>
                                <input class='file-path' type='text' placeholder='Upload File'>
                            </div>
                        </div>
                        <p id='error' class='message red-text'></p>
                        <p id='success' class='message green-text'></p>
                        <div class='center-align'>
                            <input type="submit" value="Upload" name="addService" class='btn-small green'>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php require_once "includes/footer.php"; ?>
    </body>
</html>