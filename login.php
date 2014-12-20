<link type="text/css" rel="stylesheet" href="css/home.css" />

     
    <?php
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
    ?>
    
<html>
<head>
    <title>
        Login
    </title>
</head>
<body>
   
    <div id="container">
    
        <?php
        if(!loggedin()){
            if(isset($_POST['r_no']) && isset($_POST['password']))
            {
                $r_no = $_POST['r_no'];
                $password = $_POST['password'];
                $password_hash = md5($password);            
               // echo 'Your Password is $password';
                if(!empty($r_no) && !empty($password))
                {
                    $query = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($r_no)."' AND `password`='".mysql_real_escape_string($password)."'";
                    if($query_run = mysql_query($query))
                    {
                        $query_num_rows = mysql_num_rows($query_run);
            
                        if($query_num_rows == 0)
                            echo '<span style="color:red;">*Invalid roll no and password.</span><br /><br />';
                        else if($query_num_rows == 1)
                        {
                            $user_row = mysql_fetch_assoc($query_run);
                           
                            if($user_row['confirm'] == 1){
				                $_SESSION['student_id'] = $user_row['r_no'];
				                $_SESSION['dept'] = $user_row['dept'];
				                $_SESSION['sem'] = $user_row['sem'];
                            
                                //header("Location: profile.php?id={$_SESSION['student_id']}");
                                header("Location: index.php");
                            }
                            else{
                                echo '<br /><center>Confirm your E-mail.<center>';
                                die();
                            }
                        }
                    }
                }
                else
                    echo '<span style="color:red;">*You must enter a roll number and password.</span><br /><br />';
            }
        }
        else{
            header("Location: index.php");
        }
        ?>
        <h1 style="font-family: 'junction regular'">Login form:-</h1><br />
        
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            Roll no<span style="margin-left:17px">:<input type="text" name="r_no" /><br /><br />
            Password :<input type="password" name="password" /><br /><br />
            <input type="submit" value="Log in"></input>&nbsp;<a href="forgot_password.php">Forgot Password?</a>
        </form>
    </div>    
</body>
</html>