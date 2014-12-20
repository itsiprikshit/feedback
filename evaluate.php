<link type="text/css" rel="stylesheet" href="css/home.css" />
    
<?php include('includes/header.php') ?>
    <head>
        <title>
            Evaluate
        </title>
    </head>
    
    <div id="container">
        <?php 
            if(!loggedin()){
                //echo '<br /><center><a href="login.php"> Login first!!! </a></center>';
                header('Location: index.php');
            }
            elseif(isset($_SESSION['student_id'])){
                
           
                            
                if(isset($_POST['op1']) && isset($_POST['op2']) && isset($_POST['op3']) && isset($_POST['op4']) && isset($_POST['op5']) && isset($_GET['c_id']) && isset($_GET['c'])){
                
                    //Feedback response of new entry
                    $op1 = $_POST['op1'];
                    $op2 = $_POST['op2'];
                    $op3 = $_POST['op3'];
                    $op4 = $_POST['op4'];
                    $op5 = $_POST['op5'];
                    $c_id = $_GET['c_id'];
                    $c_value = $_GET['c'];
                    
                    //$c_value = encrypt_decrypt('decrypt', $c_value);
                    //$c_id = encrypt_decrypt('decrypt', $c_id);
                    
                    $user_row = mysql_fetch_assoc(mysql_query("SELECT `t_id` FROM teacher WHERE (`c_id1`='".$c_id."' OR `c_id2`='".$c_id."' OR `c_id2`='".$c_id."')"));
                    $t_id = $user_row['t_id'];
                    //$c_value = encrypt_decrypt('decrypt', $c_value_enc);
                    
                    $query = "SELECT * FROM `report` WHERE `c_id`='".$c_id."'";
                    if($query_run = mysql_query($query)){
                        
                        $query_num_rows = mysql_num_rows($query_run);
                        if($query_num_rows == 0){
                            $query = "INSERT INTO `report` VALUES('{$c_id}',{$t_id},{$op1},{$op2},{$op3},{$op4},{$op5},1)";  
                            
                            $query_run = mysql_query($query);
                            
                            //Updating current course status
                            
                            $c_value = $_GET['c'];
                            $query = "UPDATE `student` SET `c{$c_value}` = 1 WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'"; 
                            $query_run = mysql_query($query);
                        }
                        else{
                            $query = "SELECT * FROM `report` WHERE `c_id`='".$c_id."'";
                            $query_run = mysql_query($query);
                            
                            $query_num_rows = mysql_num_rows($query_run);
                            $user_row = mysql_fetch_assoc($query_run);
                            
                            //Stored Feedback of each question
                            
                            $q1_stored = $user_row['q1'];
                            $q2_stored = $user_row['q2'];
                            $q3_stored = $user_row['q3'];
                            $q4_stored = $user_row['q4'];
                            $q5_stored = $user_row['q5'];
                            $count = $user_row['count'];
                            
                            //New Feedback
                            
                            $q1_new = (($q1_stored * $count)+$op1)/($count + 1);
                            $q2_new = (($q2_stored * $count)+$op2)/($count + 1);
                            $q3_new = (($q3_stored * $count)+$op3)/($count + 1);
                            $q4_new = (($q4_stored * $count)+$op4)/($count + 1);
                            $q5_new = (($q5_stored * $count)+$op5)/($count + 1);
                            
                            $count = $count + 1;
                            $query = "UPDATE `report` SET
                                      `q1` = {$q1_new},
                                      `q2` = {$q2_new},
                                      `q3` = {$q3_new},
                                      `q4` = {$q4_new},
                                      `q5` = {$q5_new},
                                      `count` = {$count} WHERE `c_id`='".$c_id."'"; 
                            
                            $query_run = mysql_query($query);
                            
                            //Updating current course status
                            
                            $query = "UPDATE `student` SET `c{$c_value}` = 1 WHERE `r_no`='".mysql_real_escape_string($_SESSION['student_id'])."'"; 
                            $query_run = mysql_query($query);

                            
                        }
                    }
                    echo '<br /><center>Feedback completed.<br />
                                <a href="feedback.php">Go back</a>
                          </center>';
                }
                else{
                
                //Displaying Form
                        
                $query = "SELECT * FROM `questions`";
                    if($query_run = mysql_query($query))
                    {
                        $query_num_rows = mysql_num_rows($query_run);
                        
                        if($query_num_rows == 1 ){
                            $user_row = mysql_fetch_assoc($query_run);
                            $que1 = $user_row['que1'];
                            $que2 = $user_row['que2'];
                            $que3 = $user_row['que3'];
                            $que4 = $user_row['que4'];
                            $que5 = $user_row['que5'];
                            
                                    echo '<br /><form style="margin-left:33%" "action="'.htmlspecialchars($current_file) .'" method="post"">'
                                                        .'<p style="color:#ff3700">1.'.$que1.'</p><br />
	                                                            <input type="radio" name="op1" value="2.00" > Poor </input>
	                                                            <input type="radio" name="op1" value="4.00" > Satisfactory </input>
	                                                            <input type="radio" name="op1" value="6.00" > Good </input>
	                                                            <input type="radio" name="op1" value="8.00" > Very Good </input>
	                                                            <input type="radio" name="op1" value="10.00" > Excellent </input>
	                                                            <input type="hidden" name="hidden" value="op1" method="POST" />
                                                            <br /><br />'
                                                       .'<p style="color:#ff3700">2.'.$que2.'</p><br />
	                                                            <input type="radio" name="op2" value="2" > Poor </input>
	                                                            <input type="radio" name="op2" value="4" > Satisfactory </input>
	                                                            <input type="radio" name="op2" value="6" > Good </input>
	                                                            <input type="radio" name="op2" value="8" > Very Good </input>
	                                                            <input type="radio" name="op2" value="10" > Excellent </input>
	                                                            <input type="hidden" name="hidden" value="op2" method="POST" />
                                                            <br /><br />'
                                                       .'<p style="color:#ff3700">3.'.$que3.'</p><br />
	                                                            <input type="radio" name="op3" value="2" > Poor </input>
	                                                            <input type="radio" name="op3" value="4" > Satisfactory </input>
	                                                            <input type="radio" name="op3" value="6" > Good </input>
	                                                            <input type="radio" name="op3" value="8" > Very Good </input>
	                                                            <input type="radio" name="op3" value="10" > Excellent </input>
	                                                            <input type="hidden" name="hidden" value="op3" method="POST" />
                                                            <br /><br />'
                                                       .'<p style="color:#ff3700">4.'.$que4.'</p><br />
	                                                            <input type="radio" name="op4" value="2" > Poor </input>
	                                                            <input type="radio" name="op4" value="4" > Satisfactory </input>
	                                                            <input type="radio" name="op4" value="6" > Good </input>
	                                                            <input type="radio" name="op4" value="8" > Very Good </input>
	                                                            <input type="radio" name="op4" value="10" > Excellent </input>
	                                                            <input type="hidden" name="hidden" value="op4" method="POST" />
                                                            <br /><br />'
                                                       .'<p style="color:#ff3700">5.'.$que5.'</p><br />
	                                                            <input type="radio" name="op5" value="2" > Poor </input>
	                                                            <input type="radio" name="op5" value="4" > Satisfactory </input>
	                                                            <input type="radio" name="op5" value="6" > Good </input>
	                                                            <input type="radio" name="op5" value="8" > Very Good </input>
	                                                            <input type="radio" name="op5" value="10" > Excellent </input>
	                                                            <input type="hidden" name="hidden" value="op5" method="POST" />
                                                            <br /><br />
                                                        <input type="submit" value="Submit" />
                                                   </form>';
                        }
                    }
                }    
            }
            else{
                header('Location: index.php');
            }
        ?>
    </div>
    
<?php include('includes/footer.php') ?>
