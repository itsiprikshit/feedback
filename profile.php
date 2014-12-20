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
    if(isset($_SESSION['student_id'])){
        $query = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'";
        $query_run = mysql_query($query);
        $user_row = mysql_fetch_assoc($query_run);
        $s_name = $user_row['s_name'];
        echo "<br /><center>Welcome {$s_name} !!! </center><br />";
        echo "<center>
                     <ul>
                        <li><a href=\"user_profile.php\">View profile</a></li>
                        <li><a href=\"edit_profile.php\">Edit profile</a></li>
                        <li><a href=\"change_password.php\">Change Password</a></li>
                     </ul> 
              </center>";
    }    
    elseif(!(isset($_SESSION['t_id'])) && !(isset($_SESSION['student_id'])) && !(isset($_SESSION['admin']))){
        $query_num_rows = 0;
        if(isset($_POST['r_no']))
            {
                $r_no = $_POST['r_no'];
    
                if(!empty($r_no))
                {
                    $query = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($r_no)."'";
                    if($query_run = mysql_query($query))
                    {
                        $query_num_rows = mysql_num_rows($query_run);
                        $user_row = mysql_fetch_assoc($query_run);
                        
                        if($query_num_rows == 0 || $user_row['confirm'] == 0)
                            echo '<br /><center><span style="color:red;">*Invalid roll no.</span></center>';
                        else if($query_num_rows == 1)
                        {
                            
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
                                                
                                        </center>';
                        }
                    }
                }
                else
                    echo '<br /><center><span style="color:red;">*You must enter a roll number.</span></center>';
            }
            
        if($query_num_rows == 0 || $user_row['confirm'] == 0){
            echo '<br /><center><form action="'.htmlspecialchars($current_file) .'" method="post">
                                    Roll no<span style="margin-left:17px">:<input type="text" name="r_no" />
                                    <input type="submit" value="View Profile"></input>
                                </form>
                        </center>';
        }
    }
    else{
        header('Location: index.php');
    }
    ?>
</div>

<?php include_once 'includes/footer.php' ?>