<?php

/**
 * Description of write
 *
 * @author remroyal
 */
class Write extends CI_Controller {

    private $userdata = NULL;

    public function  __construct() {
        parent::__construct();

        if( $this->session->userdata('uid') ) {
            $this->userdata = json_decode( encrypt_safedecode($this->session->userdata('uid')) );
        }
        else {
            redirect('/');
            return;
        }

        $this->layout->setLayout('layout/layout');
    }

    public function index() {

        $this->load->model('textsmodel');
        $text = $this->textsmodel->getTodayTextByUID($this->userdata->_id, strftime('%Y-%m-%d',time()), TRUE);

        $data = array(
            'text'  => $text['text'],
            'saved_at' => $text['saved_at'],
            'uid' => encrypt_safeencode($this->userdata->_id)
        );
        $this->layout->view('write/dashboard', $data);
    }

    /*
     * Recibe por POST el texto y el contenido de UID. Extrae contenido de UID
     * y comprara con el UID actual. Si iguales, actualiza el texto si existe, y
     * si no existe lo crea. El texto se identifica por la fecha (string) y el id de usuario.
     */
    public function savetext() {

        $this->load->model('textsmodel');
        
        if( encrypt_safedecode($this->input->post('uid')) == $this->userdata->_id) {
            $text = $this->textsmodel->saveTodayText($this->userdata->_id, $this->input->post('text'), str_word_count($this->input->post('text'))+1 );
            //$saved = strftime('%H:%M:%S', $text['saved_at']->sec + 7200);
            $saved = strftime('%H:%M:%S', $text['saved_at']->sec);
        }
        else {
            $saved = 'NULL';
        }

        echo trim($saved);
    }
}
?>
