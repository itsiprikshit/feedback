<link type="text/css" rel="stylesheet" href="css/home.css" />
<?php
    include_once 'includes/header.php';
    include_once 'includes/footer.php';
    
?>

<html>
<head>
    <title>Register</title>
</head>

<body>
    <div id="container">
        <?php
        
            require_once 'mandrill-api-php/src/Mandrill.php'; 
            $mandrill = new Mandrill('v5POumc7NJ7pBGRal5MeTw');

            if(!loggedin()) 
            {
                if(isset($_POST['s_name']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['r_no']) && isset($_POST['sem']))
                {
                    $s_name = $_POST['s_name'];
                    $password = $_POST['password'];
                    $r_no = $_POST['r_no'];
                    $email = $_POST['email'];
                    $sem = $_POST['sem'];
                    //$dept = $_POST['dept'];
                    $password_hash = md5($password);

                    if(!empty($s_name) && !empty($password) && !empty($email) && !empty($r_no) && !empty($sem))
                    {
                        $s_name = test_input($s_name);
                        $email = test_input($email);
                        $r_no = test_input($r_no);
            
                        if (!preg_match("/^[a-zA-Z ]*$/",$s_name))
                            $s_name_err ='Only alphabets and white spaces allowed.';
                        else
                        {
                            if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
                                $email_err = 'Invalid e-mail format.';
                            else
                            {
                                if($r_no > 15000)
                                    $r_no_err = 'Invalid Roll no.';
                                else
                                {
                                    if(strlen($s_name) > 50 || strlen($email) > 50)           //because even if maxlength field is changed in html this will prevent it from exceeding 
                                        echo 'You\'ve exceeded maximum length.';          
                                    else
                                    {
                                        $query = "SELECT `r_no`,`email` FROM `student` WHERE `r_no`='$r_no' OR `email`='$email'";
                                        $query_run = mysql_query($query);
                                        $query_num_rows = mysql_num_rows($query_run);
                       
                                        if($query_num_rows == 1)
                                        {
                                            $row_data = mysql_fetch_assoc($query_run);
                                            echo '<span style="color:red;"> '.$s_name.' already exists.</span><br /></br />';
                                            if($row_data['email'] == $email)
                                                echo '<span style="color:red;">The email : '.$email.' is already registered.</span><br /><br />';
                                        }
                                        else
                                        {
                                            $dept_cal = $r_no / 100;
                                            $dept_cal = $dept_cal % 10;
                                            switch($dept_cal){
                                                case 1: $dept = 'CIVIL';break;
                                                case 2: $dept = 'EEE';break;
                                                case 3: $dept = 'ME';break;
                                                case 4: $dept = 'ECE';break;
                                                case 5: $dept = 'CSE';break;
                                                case 6: $dept = 'ARCH';break;
                                                case 7: $dept = 'CHEMICAL';break;
                                            }
                                            
                                            $token = rand();
                                            $query = "INSERT INTO `student`";
                                            $query .= "VALUES('{$r_no}','{$s_name}','{$dept}','{$sem}','{$password}','{$email}',0,'{$token}',0,0,0,0,0,0)";
                                            
                                            echo '<br /><center>Your password : '.$password.'<center>';
                                            //$message = "Confirm Your Email.
                                            //            Click the link below to confirm.
                                            //            http://feedback-silverlyn.rhcloud.com/confirm_mail.php?r_no=$r_no&token=$token
                                            //            ";
                                            if($query_run = mysql_query($query)){
                                            
                                                    try {
                                                        $message = array(
                                                            'html' => '<p>Example HTML content</p>',
                                                            'text' => 'Example text content',
                                                            'subject' => 'example subject',
                                                            'from_email' => 'feedback@gmail.com',
                                                            'from_name' => 'feedback',
                                                            'to' => array(
                                                                array(
                                                                    'email' => 'prikshit911@gmail.com',
                                                                    'name' => 'Prikshit',
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
                                                            'bcc_address' => 'message.bcc_address@example.com',
                                                            'tracking_domain' => null,
                                                            'signing_domain' => null,
                                                            'return_path_domain' => null,
                                                            'merge' => true,
                                                            'merge_language' => 'mailchimp',
                                                            'global_merge_vars' => array(
                                                                array(
                                                                    'name' => 'merge1',
                                                                    'content' => 'merge1 content'
                                                                )
                                                            ),
                                                            'merge_vars' => array(
                                                                array(
                                                                    'rcpt' => 'recipient.email@example.com',
                                                                    'vars' => array(
                                                                        array(
                                                                            'name' => 'merge2',
                                                                            'content' => 'merge2 content'
                                                                        )
                                                                    )
                                                                )
                                                            ),
                                                            'tags' => array('password-resets'),
                                                            'subaccount' => 'customer-123',
                                                            'google_analytics_domains' => array('example.com'),
                                                            'google_analytics_campaign' => 'message.from_email@example.com',
                                                            'metadata' => array('website' => 'www.example.com'),
                                                            'recipient_metadata' => array(
                                                                array(
                                                                    'rcpt' => 'recipient.email@example.com',
                                                                    'values' => array('user_id' => 123456)
                                                                )
                                                            ),
                                                            'attachments' => array(
                                                                array(
                                                                    'type' => 'text/plain',
                                                                    'name' => 'myfile.txt',
                                                                    'content' => 'ZXhhbXBsZSBmaWxl'
                                                                )
                                                            ),
                                                            'images' => array(
                                                                array(
                                                                    'type' => 'image/png',
                                                                    'name' => 'IMAGECID',
                                                                    'content' => 'ZXhhbXBsZSBmaWxl'
                                                                )
                                                            )
                                                        );
                                                        $async = false;
                                                        $ip_pool = 'Main Pool';
                                                        $send_at = 'example send_at';
                                                        $result = $mandrill->messages->send($message);
                                                        print_r($result);
                                                       
                                                    } catch(Mandrill_Error $e) {
                                                        // Mandrill errors are thrown as exceptions
                                                        echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
                                                        // A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
                                                        throw $e;
                                                    }

                                                //if(mail($email,"Confirm Email",$message,"From: DoNotReply@feedback.com")){
                                                //    echo '<br /><center>Registration Complete, Confirm your email.</center>';
                                                //    die();
                                                //}
                                                //else{
                                                //    echo '<br /><center>Email not sent.</center>';
                                                //}
                                            }
                                        }
                                    }
                                }    
                            }
                        }
                        if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email))
                            $email_err = 'Invalid e-mail format.';
                    }
                    else 
                        echo '<span style="color:red;">*All fiedls are reqired.</span><br /><br />';
                }
            }
            else if(loggedin())
            {
                header('Location: index.php');
            }
        ?>
        <h1 style="font-family: 'junction regular'">Register form:-</h1><br />

        <form action="<?php echo htmlspecialchars($current_file); ?>" method="post" style="position:absolute;">
            <span style="color:red;"> * Required fields. </span> <br /> <br />
            Name<span style="margin-left:35px">:<input type="text" name="s_name" maxlength="100" value="<?php if(isset($s_name))echo $s_name; ?>" /> <span style="color:red;"> * <?php if(isset($s_name_err))echo $s_name_err; ?></span> <br /><br />
            Roll no<span style="margin-left:26px">:<input type="text" name="r_no" value="<?php if(isset($r_no))echo $r_no; ?>" /> <span style="color:red;"> * <?php if(isset($r_no_err))echo $r_no_err; ?></span> <br /><br />
            Sem<span style="margin-left:46px" />:<select name="sem" style="width:137px">
                    <option></option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </select> <span style="color:red;"> * <?php if(isset($sem_err))echo $sem_err; ?></span> <br /><br />
            <!-- Department:<select name="dept" style="width:137px">
                            <option></option>
                            <option>CSE</option>
                            <option>ME</option>
                            <option>ECE</option>
                            <option>EEE</option>
                            <option>CIVIL</option>
                            <option>ARCH</option>
                            <option>CHEMICAL</option>
                       </select> <span style="color:red;"> * <?php if(isset($dept_err))echo $dept_err; ?> </span> <br /><br /> -->
            Password<span style="margin-left:16px">:<input type="password" name="password" /> <span style="color:red;"> * </span> <br /><br />
            E-mail<span style="margin-left:34px">:<input type="email" name="email" maxlength="50" value="<?php if(isset($email))echo $email; ?>" /> <span style="color:red;"> * <?php if(isset($email_err))echo $email_err; ?></span> <br /><br />
            <input type="submit" value="Register"></input>
        </form>
    </div>

    <?php 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

</body>
</html>