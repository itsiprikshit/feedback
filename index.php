<link type="text/css" rel="stylesheet" href="css/home.css" />

<?php include('includes/header.php') ?>
    
<head>
    <title>Online Feedback</title>
</head>

<body>
    <div id="container">
        <?php 
            if(!loggedin()){
                echo '<br /><center><h2>Welcome to Online Feedback system.</h2>
                      <a href="register.php">Student Register</a><br />
                      <a href="faculty_login.php">Faculty Login</a></center>';
            }
            else{
                if(isset($_SESSION['student_id'])){
                    echo '<br /><center><a href="feedback.php"> Proceed to feedback </a></center>';
                }
                elseif(isset($_SESSION['t_id'])){
                    echo "<br /><center>Welcome <span style=\"color:red;\">{$_SESSION['t_name']}.</span><center>";
                }
                else{
                    echo '<br /><center><h1>ADMIN PANEL</h1></center>';
                    echo "<center>Welcome <span style=\"color:red;\">{$_SESSION['admin']}.</span><center>";
                }
            }
        ?>
    </div>
    
<?php include('includes/footer.php') ?>

