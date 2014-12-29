<link type="text/css" rel="stylesheet" href="css/home.css" />

     
    <?php
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
    ?>
    
<html>
<head>
    <title>
        Forgot Password
    </title>
</head>
<body>
   
    <div id="container">
    
        <?php
            if(!loggedin()){
                    if(isset($_POST['email'])){
                        $email = $_POST['email'];
                        
                        if(!empty($email)){
                            $query = "SELECT * FROM `student` WHERE `email`='".mysql_real_escape_string($email)."'";
                        
                            if($query_run = mysql_query($query))
                            {
                                $query_num_rows = mysql_num_rows($query_run);
                                
                                
                                if($query_num_rows == 1){
                                    $user_row = mysql_fetch_assoc($query_run);
                                    $s_name = $user_row['s_name'];
                                    
                                    $random = rand(11111, 99999);
                                    $new_password = $random;
                                    mysql_query("UPDATE student SET `password`='".mysql_real_escape_string($new_password)."' WHERE `email`='".$email."'");
                                    
                                    $link = "Your new password is ".$new_password;
                                     try {
                                                        $message = array(
                                                            'html' => '',
                                                            'text' => $link,
                                                            'subject' => 'Forgot Password',
                                                            'from_email' => 'DoNotReply@feedback.com',
                                                            'from_name' => 'NITH-Feedback',
                                                            'to' => array(
                                                                array(
                                                                    'email' => $email,
                                                                    'name' => $s_name,
                                                                    'type' => 'to'
                                                                )
                                                            ),
                                                            'headers' => array('Reply-To' => 'donotreply'),
                                                            'important' => false,
                                                            'track_opens' => null,
                                                            'track_clicks' => null,
                                                            'auto_text' => null,
                                                            'auto_html' => null,
                                                            'inline_css' => null,
                                                            'url_strip_qs' => null,
                                                            'preserve_recipients' => null,
                                                            'view_content_link' => null,
                                                            'tracking_domain' => null,
                                                            'signing_domain' => null,
                                                            'return_path_domain' => null,
                                                            'merge' => true
                                                        );
                                                        $async = false;
                                                        $ip_pool = 'Main Pool';
                                                        $send_at = 'example send_at';
                                                        $result = $mandrill->messages->send($message, $async, $ip_pool);
                                                        print_r($result);
                                                        echo '<br /><center>Your new password has been emailed to you.<center>';
                                                        die();
                                                       
                                                    } catch(Mandrill_Error $e) {
                                                        // Mandrill errors are thrown as exceptions
                                                        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
                                                        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
                                                        throw $e;
                                                        echo '<br /><center>Email not sent.</center>';
                                                    }
                                }
                                else{
                                    echo '<br /><center>E-mail does not exist.</center>';
                                }
                            }
                        }
                        else    
                            echo '<br /><center><span style="color:red;">*You must enter an E-mail.</span><center>';
                    }
            }
            else{
                header('Location: index.php');
            }
        ?>
        
        <br /><center>
            <form action="<?php echo htmlspecialchars($current_file); ?>" method="post">
                E-mail :<input type="email" name="email" />
                <input type="submit" value="Submit"></input>
            </form>
        </center>
    </div>    

</body>
</html>