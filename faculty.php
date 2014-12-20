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
if(loggedin() && isset($_SESSION['t_id'])){
    $query = "SELECT * FROM `teacher` WHERE `t_id`='".mysql_real_escape_string($_SESSION['t_id'])."'";
        if($query_run = mysql_query($query))
        {
            $user_row = mysql_fetch_assoc($query_run);
            $t_id = $user_row['t_id'];
            $t_name = $user_row['t_name'];
            $branch = $user_row['t_branch'];
            $c_id1 = $user_row['c_id1'];
            $c_id2 = $user_row['c_id2'];
            $c_id3 = $user_row['c_id3'];
            
            echo '<br /><center>Teacher id: '.$t_id.'<br />
                                Name: '.$t_name.'<br />
                                Department: '.$branch.'<br />
                        </center>';
            $query = "SELECT * FROM report WHERE `t_id`='".$t_id."' AND (`c_id`='".$c_id1."' OR `c_id`='".$c_id2."' OR `c_id`='".$c_id3."')";
            $query_run = mysql_query($query);
            while($user_row = mysql_fetch_assoc($query_run)){
                $q1 = $user_row['q1'];        
                $q2 = $user_row['q2'];        
                $q3 = $user_row['q3'];        
                $q4 = $user_row['q4'];        
                $q5 = $user_row['q5'];
                $c_id = $user_row['c_id'];
                $count = $user_row['count'];
                
                $c_av = ($q1 + $q2 + $q3 + $q4 + $q5) / 5;
                
                echo '<center>'.$c_id.' = '.$c_av.' points &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No of students filled :'.$count.'</center>';
            }    
        }
}
else{
        header('Location: index.php');
}
?>