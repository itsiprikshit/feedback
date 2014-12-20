<link type="text/css" rel="stylesheet" href="css/header.css" />

<?php
    include_once 'connect.php';
    include_once 'core.php';
?>

<!DOCTYPE html>
<html lang="en/us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<div id="nav-bar">
   <ul>
        <li> <a href="index.php"> Home </a> </li>
        
        <?php
            if(!loggedin()){
                echo '<li> <a href="profile.php"> Profile </a> </li>';
                echo '<li> <a href="login.php"> Login </a> </li>';
            }
            else{
                if(isset($_SESSION['student_id'])){
                    echo "<li><a href=\"profile.php?id={$_SESSION['student_id']}\"> Profile </a> </li>";
                              //<ul>
                              //  <li><a href=\"#\">Edit profile</a></li>
                              //  <li><a href=\"#\">Change Password</a></li>
                              //  <li><a href=\"#\">Feedback status</a></li>
                              //</ul>
                    echo '<li> <a href="logout.php"> Logout </a> </li>'; 
                }
                elseif(isset($_SESSION['t_id'])){
                    echo "<li><a href=\"faculty.php\"> Profile </a> </li>";
                    echo '<li> <a href="logout.php"> Logout </a> </li>'; 
                }
                else{
                    echo "<li><a href=\"admin.php\"> Profile </a> </li>";
                    echo '<li> <a href="logout.php"> Logout </a> </li>'; 
                }
            }
        ?>
    </ul>
</div>
