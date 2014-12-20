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
            if(isset($_POST['t_id']) && isset($_POST['password']))
            {
                $t_id = $_POST['t_id'];
                $password = $_POST['password'];
                $password_hash = md5($password);            
                
                if(!empty($t_id) && !empty($password))
                {
                    $query = "SELECT * FROM `teacher` WHERE `t_id`='".mysql_real_escape_string($t_id)."' AND `t_password`='".mysql_real_escape_string($password)."'";
                    if($query_run = mysql_query($query)){
                        $query_num_rows = mysql_num_rows($query_run);
            
                        if($query_num_rows == 0)
                            echo '<span style="color:red;">*Invalid id and password.</span><br /><br />';
                        else if($query_num_rows == 1)
                        {
                                $user_row = mysql_fetch_assoc($query_run);
				                $_SESSION['t_id'] = $user_row['t_id'];
				                $_SESSION['t_name'] = $user_row['t_name'];
                                //header("Location: profile.php?id={$_SESSION['student_id']}");
                                header("Location: index.php");
                        }
                    }
                }
                else
                    echo '<span style="color:red;">*You must enter an id number and a password.</span><br /><br />';
            }
        }
        else{
            header("Location: faculty.php");
        }
        ?>
        <h1 style="font-family: 'junction regular'">Login form:-</h1><br />
        
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            ID<span style="margin-left:47px">:<input type="text" name="t_id" /><br /><br />
            Password :<input type="password" name="password" /><br /><br />
            <input type="submit" value="Log in"></input>
        </form>
    </div>    
</body>
</html>