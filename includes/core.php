<?php
ob_start();
session_start();
$current_file = $_SERVER['SCRIPT_NAME'];

function loggedin()
{
    if((isset($_SESSION['student_id']) && !empty($_SESSION['student_id'])) || (isset($_SESSION['t_id']) && !empty($_SESSION['t_id'])) || (isset($_SESSION['admin']) && !empty($_SESSION['admin'])))
        return true;
    else
        return false;
}

//function encrypt( $q ) {
//    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
//    $qEncoded  = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
//    return( $qEncoded );
//}

//function decrypt( $q ) {
//    $cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
//    $qDecoded  = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
//    return( $qDecoded );
//}
    
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

?>