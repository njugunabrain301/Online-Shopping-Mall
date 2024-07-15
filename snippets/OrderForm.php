<div class='book modal change' id='apt-modal'>
    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
    <form onsubmit='return book(this)'>
        <h4>Set The Date and Time</h4>
        <br>
        <input type="hidden" name='id' value='<?php echo $_GET['id']; ?>' id='aptId-first'>
        <div class='input-field'>
            <select name='location'>
                <option selected disabled>Select Pick Up Location</option>
                <?php
                    $handler->getPickUpLocations();
                ?>
            </select>
        </div><br>
        <div class='input-field'>
            <label>Date <i>(mm/dd/yyyy)</i></label>
            <input id='datePicker' type="text" name='date' class='datepicker' value="<?php echo date("Y-m-d") ?>">
        </div><br>
        <div class='input-field'>
            <label>Time</label><br>
            <input type="time" name='time' value="12:00" id='time'><br>
            <label for='time'>&nbsp;</label>
        </div>
        <input type='hidden' name='aptId' value='' id='aptId-second'>
        <input type='hidden' name='iid' value='' id='apt-iid'>
        <p id='apt-error' class='error'>
        </p>
        <button type='submit' class="btn small green">Book</button>
    </form>
    <span id='sub-title'></span>
    <table id='available'>

    </table>
</div>
<div class='book modal change' id='order-modal'>
    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
    <form onsubmit='return order(this)'>
        <h4>Select Pick Up Location</h4>
        <input type="hidden" name='id' value='<?php echo $_GET['id']; ?>'>
        <div class='input-field'>
            <select name='pickup'>
                <option selected disabled>Select Pick Up Location</option>
                <?php
                    $handler->getPickUpLocations();
                ?>
            </select>
        </div>
        <p id='order-error'></p>
        <button type='submit' class='btn-small green'>Add To Cart</button>
    </form>
    <table id='available'>

    </table>
</div>