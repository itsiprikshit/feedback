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

function encode($text){
    //Encoding
    global $key;
    $key = pack('H*', "bceffbaa");
    global $iv_size; 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$text, MCRYPT_MODE_CBC, $iv);
    $ciphertext = $iv . $ciphertext;
    $ciphertext_base64 = base64_encode($ciphertext);
    $encoded = rtrim(strtr(base64_encode($ciphertext_base64), '+/', '-_'), '=');
    return $encoded;
}
function decode($text){
    //Decoding
    global $iv_size, $key;
    $decoded = base64_decode(str_pad(strtr($text, '-_', '+/'), strlen($text) % 4, '=', STR_PAD_RIGHT));
    $ciphertext_dec = base64_decode($decoded);
    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
    $ciphertext_dec = substr($ciphertext_dec, $iv_size);
    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
    return $plaintext_dec;
}
?>