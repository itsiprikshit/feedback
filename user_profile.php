<link type="text/css" rel="stylesheet" href="css/home.css" />

<?php 
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
?>

    <head>
        <title>
            User Profile
        </title>
    </head>
    
<div id="container">

<?php
if(loggedin() && isset($_SESSION['student_id'])){
    $query = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'";
        if($query_run = mysql_query($query))
        {
            $user_row = mysql_fetch_assoc($query_run);
            $r_no = $user_row['r_no'];
            $s_name = $user_row['s_name'];
            $dept = $user_row['dept'];
            $sem = $user_row['sem'];
            $email = $user_row['email'];
                            
            echo '<br /><center>Roll no: '.$r_no.'<br />
                                Name: '.$s_name.'<br />
                                Department: '.$dept.'<br />
                                Semester: '.$sem.'<br />
                                Email: '.$email.'<br />
                                <a href="profile.php?id='.$_SESSION['student_id'].'">Go back</a>
                        </center>';
        }
}
else{
        header('Location: index.php');
}
?>