<?php

/**
 * Description of prueba
 *
 * @author remroyal
 */
class Prueba extends CI_Model {

    public function  __construct() {
        parent::__construct();
    }

    public function getUsers() {
        $users = $this->mongo->db->users->find();
        return $users;
    }
}
?>
