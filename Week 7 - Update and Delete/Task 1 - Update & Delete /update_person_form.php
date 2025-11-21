<?php
//one single echo statement to include the entire person update form
//this contains a hidden input field so that we know which person to update
echo '
<form action="update_person.php" method="POST">
<input type="hidden" name="id" value="'.$id.'">
<p>Firstname</p>
        <input type="text" name= "first_name" value="'.$firstname.'">
        <p>Lastname</p>
        <input type="text" name= "last_name" value="'.$lastname.'">
        <p>Email</p>
        <input type="email" name= "email"value="'.$email.'">
        <p>Gender</p>
        <input type="text" name= "gender" value="'.$gender.'">
        <p>Occupation</p>
        <input type="text" name= "occupation" value="'.$occupation.'">
        <p>Skill</p>
        <input type="text" name= "skill" value="'.$skill.'">
        <p>Car</p>
        <input type="text" name= "car" value="'.$car.'">
        <p>Education</p>
        <input type="text" name= "education" value="'.$education.'">
        <br />
<input type="submit" value="Update">
</form>';
?>