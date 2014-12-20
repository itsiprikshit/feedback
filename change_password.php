<link type="text/css" rel="stylesheet" href="css/home.css" />

<?php 
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
?>

    <head>
        <title>
            Change Password
        </title>
    </head>
    
<div id="container">

<?php
    if(loggedin()){
        if(isset($_SESSION['student_id'])){
            if(isset($_POST['password1']) && isset($_POST['password2'])){
                $password1 = $_POST['password1'];
                $password2 = $_POST['password2'];
        
                if(!empty($password1) && !empty($password2)){
                    if($password1 == $password2){
                        $query = "UPDATE student SET `password`='".mysql_real_escape_string($password2)."' WHERE `r_no`='".$_SESSION['student_id']."'";
                        if($query_run = mysql_query($query)){
                                echo '<br /><center><span style="color:red;">Password changed successfully.</span><br />
                                                    <a href="profile.php?id='.$_SESSION['student_id'].'">Go back.</a>
                                            </center>';
                                die();
                        }
                    }
                    else{
                        echo '<br /><center><span style="color:red;">*Passwords donot match.</span></center>';
                    }
                }
                else
                    echo '<br /><center><span style="color:red;">*You must enter a new password.</span></center>';
            }
        }
        else{
            header('Location: index.php');
        }
    }
    else{
        header('Location: index.php');
    }
?>
    <br />
    <center>
        <h1 style="font-family: 'junction regular'">Change Password:-</h1><br />
    
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            New Password<span style="margin-left:28px">:<input type="password" name="password1" /><br /><br />
            Confirm Password :<input type="password" name="password2" /><br /><br />
            <input type="submit" value="Submit"></input>
        </form>
    </center>
</div>