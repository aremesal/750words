<?php

function base64_safeencode($str) {
    return strtr(base64_encode($str), '+/=', '-_~');
}

function base64_safedecode($str) {
    return base64_decode(strtr($str, '-_~', '+/='));
}

function encrypt_safeencode($str) {
    $ci = get_instance();
    return base64_safeencode( $ci->encrypt->encode( $str ) );
}

function encrypt_safedecode($str) {
    $ci = get_instance();
    return $ci->encrypt->decode( base64_safedecode( $str ) );
}

?>
