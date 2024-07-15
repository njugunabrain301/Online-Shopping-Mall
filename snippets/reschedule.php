<div class='reschedule modal change' id='reschedule-modal'>
    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
    <form onsubmit='return reschedule(this)'>
        <h4>Set The Date and Time</h4>
        <br>
        <div class='input-field'>
            <label>Date <i>(mm/dd/yyyy)</i></label>
            <input id='datePicker' type="text" name='date' class='datepicker left-align' value="<?php echo date("Y-m-d") ?>">
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