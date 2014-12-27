<link type="text/css" rel="stylesheet" href="css/home.css" />
    
<?php include('includes/header.php') ?>

    <head>
        <title>
            Subjects
        </title>
    </head>
    <div id="container">
        <?php 
            if(!loggedin()){
                header('Location: index.php');
            }
            elseif(isset($_SESSION['student_id'])){
            
                 $query = "select * FROM `student` WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'"; 
                            $query_run = mysql_query($query);
                            $query_num_rows = mysql_num_rows($query_run);
                            $user_row = mysql_fetch_assoc($query_run);
                            $c1 = $user_row['c1'];
                            $c2 = $user_row['c2'];
                            $c3 = $user_row['c3'];
                            $c4 = $user_row['c4'];
                            $c5 = $user_row['c5'];
                            
                if(isset($_SESSION['no_course'])){
                    if(($c1 + $c2 + $c3 + $c4 + $c5) == $_SESSION['no_course']){
                        $query_fb = "UPDATE `student` SET `fb_done` = 1 WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'"; 
                        $query_run = mysql_query($query_fb);
                    }
                }
                
                $sem_sess = $_SESSION['sem'];
                $dept_sess = $_SESSION['dept'];
                
                $query = "select * FROM `student` WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'"; 
                $query_run = mysql_query($query);
                $query_num_rows = mysql_num_rows($query_run);
                $user_row = mysql_fetch_assoc($query_run);
                $fb_done = $user_row['fb_done'];
                if($fb_done == 0){
                $query = "SELECT * FROM `courses` WHERE `dept`='".mysql_real_escape_string($dept_sess)."' AND `sem`='".mysql_real_escape_string($sem_sess)."'";
                    if($query_run = mysql_query($query))
                    {
                        $query_num_rows = mysql_num_rows($query_run);
                        $c_value = 0;
                        $_SESSION['no_course'] = $query_num_rows;
                        
                        if($query_num_rows > 0 ){
                            while($user_row = mysql_fetch_assoc($query_run))
                                { 
                                    $c_value = $c_value + 1;
                                    
                                    $c_id = $user_row['c_id'];
                                    $c_name = $user_row['c_name'];
                                    
                                    echo '<br /><center>Course id: '.$c_id.'<br />
                                                        Course Name: '.$c_name.'<br />
                                                </center>';
                                    
                                    $query_course = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'";
                                    $query_run_course = mysql_query($query_course);
                                    $user_row_course = mysql_fetch_assoc($query_run_course);
                                    
                                    if($user_row_course["c{$c_value}"] == 0) {
                                        //$c_value_enc = encrypt_decrypt('encrypt', $c_value);
                                        //$c_id_enc = encrypt_decrypt('encrypt', $c_id);
                                        
                                        //echo '<center><form action="evaluate.php" method="GET">
                                        //          <input type="hidden" name="c_id" value="'.$c_id.'" method="GET" />
                                        //          <input type="hidden" name="c_value" value="'.$c_value.'" method="GET" /> 
                                        //          <input type="submit" value="Submit" />
                                        //      </center>';
                                        echo '<center><a href="evaluate.php?c='.$c_value.'&c_id='.$c_id.'">Fill feedback</a></center>';
                                    }
                                    else{
                                        echo '<center><a href=""><span style="color:red;">Feedback Filled</span></a></center>';
                                    }
                                }
                        }
                        else{
                            echo '<center><br /> No subjects for you. </center>';
                        }
                    }
                }
                else{
                    echo '<br /><center><span style="color:red;">Feedback already filled.</center>';
                }
            }
            else{
                header('Location: index.php');
            }
        ?>
    </div>
    
<?php include('includes/footer.php') ?>
