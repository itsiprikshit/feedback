<link type="text/css" rel="stylesheet" href="css/home.css" />

     
    <?php
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
    ?>
    
<html>
<head>
    <title>
        Confirm E-mail
    </title>
</head>
<body>
   
    <div id="container">
    
        <?php
            if(!loggedin()){
                if($_SERVER['PHP_SELF'] != "/feedback/confirm_mail.php?"){
                    if(isset($_GET['r_no']) && isset($_GET['token'])){
                        $r_no = $_GET['r_no'];
                        $token_confirm = $_GET['token'];
                    
                        $query = "SELECT * FROM `student` WHERE `r_no`='".mysql_real_escape_string($r_no)."'";
                        
                        if($query_run = mysql_query($query))
                        {
                            $query_num_rows = mysql_num_rows($query_run);
                            
                            if($query_num_rows == 1){
                                $user_row = mysql_fetch_assoc($query_run);
                                $token = $user_row['token'];
                                
                                if($token == $token_confirm){
                                    mysql_query("UPDATE student SET `confirm` = 1");
                                    echo '<br /><center>E-mail Confirmed, you may login.</center>';
                                }
                                else{
                                echo '<br /><center>Invalid User.</center>';
                                }
                            }
                            else{
                                echo '<br /><center>Invalid User.</center>';
                            }
                        }
                    }
                    else{    
                        header('Location: index.php');
                    }
                }
            }
            else{
                header('Location: index.php');
            }
        ?>
        
    
    </div>    

</body>
</html>