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
            if(isset($_POST['username']) && isset($_POST['password']))
            {
                $admin = $_POST['username'];
                $password = $_POST['password'];
                $password_hash = md5($password);            
    
                if(!empty($admin) && !empty($password))
                {
                    $query = "SELECT * FROM `admin` WHERE `admin`='".mysql_real_escape_string($admin)."' AND `admin_password`='".mysql_real_escape_string($password)."'";
                    if($query_run = mysql_query($query))
                    {
                        $query_num_rows = mysql_num_rows($query_run);
                        if($query_num_rows == 0)
                            echo '<span style="color:red;">*Invalid Username and password.</span><br /><br />';
                        else if($query_num_rows == 1)
                        {
                            $user_row = mysql_fetch_assoc($query_run);
				            $_SESSION['admin'] = $user_row['admin'];
                            //header("Location: profile.php?id={$_SESSION['student_id']}");
                            header("Location: index.php");
                        }
                    }
                }
                else
                    echo '<span style="color:red;">*You must enter an username and password.</span><br /><br />';
            }
        }
        else{
            header("Location: index.php");
        }
        ?>
        <h1 style="font-family: 'junction regular'">Login form:-</h1><br />
        
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            Username :<input type="text" name="username" /><br /><br />
            Password &nbsp;:<input type="password" name="password" /><br /><br />
            <input type="submit" value="Log in"></input>
        </form>
    </div>    
</body>
</html>