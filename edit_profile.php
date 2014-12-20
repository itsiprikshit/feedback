<link type="text/css" rel="stylesheet" href="css/home.css" />

<?php 
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
?>

    <head>
        <title>
            Edit Profile
        </title>
    </head>
    
<div id="container">

    <?php
        if(loggedin() && isset($_SESSION['student_id'])){
            if(isset($_POST['name']) || isset($_POST['email'])){
                $name = $_POST['s_name'];
                $email = $_POST['email'];
        
                if(empty($name) && empty($email)){
                    echo '<br /><span style="color:red;">Fill in the deatils or </span><a href="profile.php?id='.$_SESSION['student_id'].'">Go back.</a><br />';
                }
                
                if(!empty($name)){
                    $name = test_input($name);
                    if (!preg_match("/^[a-zA-Z ]*$/",$name))
                        $s_name_err ='Only alphabets and white spaces allowed.';
                    else{
                        $query = "UPDATE student SET `s_name`='".mysql_real_escape_string($name)."' WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'";
                        if($query_run = mysql_query($query)){
                            echo '<br /><center><span style="color:red;">Name changed successfully.</span><br />
                                                <a href="profile.php?id='.$_SESSION['student_id'].'">Go back.</a>
                                        </center>';
                            die();
                            //header("Location: profile.php?id={$_SESSION['student_id']}");
                        }
                    }
                }
                
                if(!empty($email)){
                    $email = test_input($email);
                    if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
                        $email_err = 'Invalid e-mail format.';
                    else{
                        $query = "UPDATE student SET `email`='".mysql_real_escape_string($email)."' WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'";
                        if($query_run = mysql_query($query)){
                            echo '<br /><center><span style="color:red;">Email changed successfully.</span><br />
                                                <a href="profile.php?id='.$_SESSION['student_id'].'">Go back.</a>
                                        </center>';
                            die();
                            //header("Location: profile.php?id={$_SESSION['student_id']}");
                        }
                    }
                }
            }
        }
        else{
            header('Location: index.php');
        }
    ?>
    <br />
        <h1 style="font-family: 'junction regular'">Edit Profile:-</h1><br />
    
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            Name<span style="margin-left:35px">:<input type="text" name="s_name" maxlength="100" value="<?php if(isset($s_name))echo $s_name; ?>" /> <span style="color:red;"> <?php if(isset($s_name_err))echo $s_name_err; ?></span> <br /><br />
            E-mail<span style="margin-left:30px">:<input type="email" name="email" maxlength="50" value="<?php if(isset($email))echo $email; ?>" /> <span style="color:red;"> <?php if(isset($email_err))echo $email_err; ?></span> <br /><br />
            <input type="submit" value="Submit"></input>
        </form>
</div>

   <?php 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>