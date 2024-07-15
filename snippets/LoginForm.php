<div class='modal change' id='login-modal'>
    <span class='modal-close btn-small green'><i class='fas fa-times'></i></span>
    <form action='backend/User.php' onsubmit="return validate_login(this,'modal')" method='post'>
        <h5>Log In</h5>
        <div class='input-field'>
            <input type="email" name='email' id='email' required><br>
            <label for='email'>Email</label>
        </div><br>
        <div class='input-field'>
            <input type='password' name='password' id='password' required><br>
             <label for='password'>Password</label><br>
        </div><br>
<!--
        <div id='radios'>
            <label>
            <input type="radio" name='type' value='customer' checked class='with-gap'> <span>Cutomer</span>
            </label>
            <label>
            <input type="radio" name='type' value='tenant' class='with-gap'> <span>Tenant</span>
            </label>
        </div><br>
-->
        <p id='error' class='message'></p>
        <p id='success' class='message'></p>
        <div id='login-message'></div>
        <button type="submit" name='login' class='btn-small green'>Log In</button> 
    </form>

</div>