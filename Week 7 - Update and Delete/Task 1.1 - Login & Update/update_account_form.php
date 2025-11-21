<?php
//one single echo statement to include the entire person update form
//this contains a hidden input field so that we know which person to update
echo '
<form action="update_account.php" method="POST">
        <p>Email</p>
        <input type="email" name= "email"value="'.$email.'">

        <p>Password</p>
        <input type="password" name= "password" value="'.$password.'">

        <br />

        <input type="submit" value="Update">
</form>';
?>