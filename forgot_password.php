<link type="text/css" rel="stylesheet" href="css/home.css" />

     
    <?php
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
    ?>
    
<html>
<head>
    <title>
        Forgot Password
    </title>
</head>
<body>
   
    <div id="container">
    
        <?php
            if(!loggedin()){
                    if(isset($_POST['email'])){
                        $email = $_POST['email'];
                        
                        if(!empty($email)){
                            $query = "SELECT * FROM `student` WHERE `email`='".mysql_real_escape_string($email)."'";
                        
                            if($query_run = mysql_query($query))
                            {
                                $query_num_rows = mysql_num_rows($query_run);
                            
                                if($query_num_rows == 1){
                                    $random = rand(11111, 99999);
                                    $new_password = $random;
                                    mysql_query("UPDATE student SET `password`='".mysql_real_escape_string($new_password)."' WHERE `email`='".$email."'");
                                    
                                    $message = "Your new password is $new_password";
                                    if(mail($email, "Login Information", $message, "From: DoNotReply@feedback.com")){
                                        echo '<br /><center>Your new password has been emailed to you.<center>';
                                        die();
                                    }
                                    else{
                                        echo '<br /><center>Your new password has been emailed to you.<center>';
                                        //echo '<br /><center>Email not delievered.</center>';
                                        die();
                                    }
                                }
                                else{
                                    echo '<br /><center>E-mail does not exist.</center>';
                                }
                            }
                        }
                        else    
                            echo '<br /><center><span style="color:red;">*You must enter an E-mail.</span><center>';
                    }
            }
            else{
                header('Location: index.php');
            }
        ?>
        
        <br /><center>
            <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
                E-mail :<input type="email" name="email" />
                <input type="submit" value="Submit"></input>
            </form>
        </center>
    </div>    

</body>
</html>