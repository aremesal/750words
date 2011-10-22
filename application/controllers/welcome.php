<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function  __construct() {
        parent::__construct();

        $this->layout->setLayout('layout/layout');
    }
	
    public function index()
    {
        if( $this->session->userdata('uid') ) {
            redirect('/write');
            return;
        }

        $this->load->model('prueba');

        $items = $this->prueba->getUsers();

        $data = array(
            'users' => $items
        );

        $this->layout->view('welcome_message', $data);
    }

    public function about() {
        $data = array();

        $this->layout->view('about', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */