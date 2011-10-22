<?php

/**
 * Description of generic
 *
 * IMPORTANT: THIS WORKS ONLY WITH MYSQL, BECAUSE TRANSACTION COMMANDS
 *
 * @author remroyal
 */
class MY_Controller extends CI_Controller {

    private $error = FALSE;
    private $message = '';

    public function  __construct() {
        parent::__construct();
    }

}
?>