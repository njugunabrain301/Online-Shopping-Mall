<div class='reason modal change' id='reason-modal'>
    <button class='btn-small green modal-close'><i class='fas fa-times'></i></button>
    <h5 id='reason-title'></h5><br>
    <form method='post' onsubmit='return cancel_with_reason(this)'>
        <input type='hidden' name='id' value='' id='reason-id'>
        <div class='input-field'>
            <label>Why do you want to cancel? </label>
            <textarea name='reason' class='materialize-textarea' required minlength="10" maxlength="40"></textarea>
        </div>
        <button type='submit' class='btn-small green'>Cancel</button>
    </form>
</div>