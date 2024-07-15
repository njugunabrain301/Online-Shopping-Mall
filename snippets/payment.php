<div class='pay modal change' id='payment-modal'>
    <button class='modal-close btn-small green'><i class='fas fa-times'></i></button>
    <h4>Payment Details</h4>
    <p id='payment-purpose'></p>
    <form action="backend/Payment.php" method='post' onsubmit='return transact(this)'>
        <input type='hidden' name='id' value='' id='payment-id'>
        <div class='input-field'>
            <label>Email</label>
            <input type='text' name='amt' placeholder='email' value='' id='payment-email' editable=false>
        </div>
        <div class='input-field'>
            <label>Phone Number</label>
            <input type='text' name='amt' value='' placeholder="07XXXXXXXX" id='payment-phone'>
        </div>
        <div class='input-field'>
            <label>Amount (Ksh)</label>
            <input type='text' name='amt' value='' placeholder='0' id='payment-amt' editable=false>
        </div>
        <button type='submit' class='btn-small green' name='pay'>Continue</button>
    </form>
</div>