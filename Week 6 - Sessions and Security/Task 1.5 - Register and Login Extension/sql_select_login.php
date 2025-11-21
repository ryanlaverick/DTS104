
<?php
 // important function to allow session variables
 session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <?php
        
        //database connection variables
        include 'dbconnect.php';
        
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') //has the user submitted the form
            {
                $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password); //building a new connection object
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                
                // save the email the user submitted from $_POST
                $user_email = $_POST['user_email'];
                // save the password the user submitted from $_POST
                $user_password = $_POST['user_password'];
                
                //preparing an sql statement to search email and password for whatever the user has typed
                $sql = $conn->prepare("SELECT * FROM users WHERE email = :email AND password = :pword" );
                $sql->bindParam(':email', $user_email);
                $sql->bindParam(':pword', $user_password);
                $sql -> execute(); //execute the statement
                
                if($sql->rowCount()) 
                    { //check if we have results by counting rows
                    
                        //set session var
                        $_SESSION['login'] = 1;

                        //get the user information from the query
                        $row = $sql->fetch();

                        //Save session var of the ID of the person logged in, incase we need it later
                        $_SESSION['user_id'] = $row['id'];
                        $_SESSION['email'] = $user_email;
                        $_SESSION['user_type'] = $row['user_type'];
					
						if ($row['user_type'] === 'user') {
							header("Location: account_area.php");
						} else {
							header("Location: admin_area.php");
						}
                    }
                else
                    {
                        echo "Wrong email or password";
                    }
                
            }
            else 
            {
                echo "You are here by mistake";
            }
        }
        catch(PDOException $e)
            {
                echo $e->getMessage();  //If we are not successful in connecting or running the query we will see an error
            }
        ?>


</body>
</html>