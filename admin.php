<link type="text/css" rel="stylesheet" href="css/home.css" />

<?php 
    include_once 'includes/header.php';
?>

    <head>
        <title>
            Profile
        </title>
    </head>
    
<div id="container">
    <?php
    
    if(isset($_SESSION['admin'])){
        echo '<br /><center>Admin :&nbsp;<span style="color:red;">'.$_SESSION['admin'].'</span></center>';
        if(isset($_POST['inc_sem'])){
            $query = "SELECT `sem` FROM `student`";
            $query_run = mysql_query($query);
            while($user_row = mysql_fetch_assoc($query_run)){
                $sem = $user_row['sem'];
                $sem = $sem + 1;
                
                $query_sem = "UPDATE student SET `sem`={$sem}, `fb_done`= 0, `c1`= 0, `c2`= 0, `c3`= 0, `c4`= 0, `c5`= 0";
                mysql_query($query_sem);
            }
        }   
        if(isset($_POST['dec_sem'])){
            $query = "SELECT `sem` FROM `student`";
            $query_run = mysql_query($query);
            while($user_row = mysql_fetch_assoc($query_run)){
                $sem = $user_row['sem'];
                $sem = $sem - 1;
                $query_sem = "UPDATE student SET `sem`={$sem}";
                mysql_query($query_sem);
            }
        }   
    }
    else{
        header('Location: index.php');
    }
    ?>
    
    <center>
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            Click to increment Semester : <input type="submit" value="Increase Sem" name="inc_sem"></input>
        </form>
        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
            Click to decrement Semester : <input type="submit" value="Decrease Sem" name="dec_sem"></input>
        </form>
    </center>
</div>

<?php include_once 'includes/footer.php' ?>