<?php

function __($key) {
    $ci =& get_instance();

    return $ci->lang->line($key);
}

function datelocal_to_php($date, $format) {
    $aux = explode('/', $date);
    $order = explode('/', $format);
    return $aux[$order[0]] . '/'. $aux[$order[1]] .'/'. $aux[$order[2]];
}

// expects a yyyy-mm-aa hh:mm:ss
function is_valid_date($date) {
    $date = explode(' ', $date);
    if( count($date) > 1 ) {
        $date = explode('-', $date[0]);
        if( count($date) == 3 ) {
            return checkdate($date[1], $date[2], $date[0]);
        }
    }
    return FALSE;
}

function is_valid_email( $email )
{
    return preg_match( '/[.+a-zA-Z0-9_-]+@[a-zA-Z0-9-]+.[a-zA-Z]+/', $email );
}

?>
