<?php

/**
 * Description of user
 *
 * @author remroyal
 */
class User extends CI_Controller {

    public function  __construct() {
        parent::__construct();

        $this->layout->setLayout('layout/layout');
    }

    public function index() {

    }

    public function register() {

        $data = array(
            'email' => '',
            'name' => ''
        );

        if( $this->session->flashdata('form') ) {
            $form = $this->session->flashdata('form');
            $data['email'] = $form['email'];
            $data['name'] = $form['name'];
        }

        $this->layout->view('user/register', $data);
    }

    public function create() {

        $this->load->model('usermodel');

        // Check for errors
        $this->error = FALSE;
        $this->message = '';

        if( !$this->input->post('name') ) {
            $this->message .= '- Debes especificar tu nombre';
            $this->error = TRUE;
        }
        if( !$this->input->post('email') ) {
            $this->message .= '- Debes indicar tu correo electr&oacute;nico';
            $this->error = TRUE;
        }
        else {
            $user = $this->usermodel->getUserByEmail($this->input->post('email'));

            if( $user ) {
                $this->message .= '- Esta direcci&oacute;n de email ya esta usada en el sistema';
                $this->error = TRUE;
            }
        }
        if( !$this->input->post('pass') ) {
            $this->message .= '- Debes especificar una contrase&ntilde;a';
            $this->error = TRUE;
        }

        if( $this->error ) {
            $this->session->set_flashdata('feedback', array(
                'error' => TRUE,
                'message' => 'Se han producido los siguientes errores: ' . $this->message ));

            $this->session->set_flashdata('form', array(
                'email' => $this->input->post('email'),
                'name' => $this->input->post('name')
                    ));

            redirect('/user/register');
        }
        else {

            $salt = encrypt_safeencode($this->input->post('email') . strftime('%Y-%m-%d %T'));
            $pass = hash('sha256', $this->input->post('pass') . $salt);

            $data = array(
                'name' => $this->input->post('name'),
                'pass' => $pass,
                'salt' => $salt,
                'email' => $this->input->post('email')
            );

            $newuser = $this->usermodel->createUser($data);

            $this->session->set_flashdata('feedback', array(
                'message' => 'Bienvenido a 750 palabras',
                'error' => FALSE
            ));

            $this->login();
            //redirect('/');
        }
    }

    public function login() {
        $data = array(
            'email' => $this->input->post('email'),
            'pass' => $this->input->post('pass'),
        );

        $this->load->model('usermodel');
        $user = $this->usermodel->getUserByLogin($data);

        if( $user ) {
            $user['_id'] = $user['_id']->__toString();
            $this->session->set_userdata('uid', encrypt_safeencode(json_encode($user)));
        }
        else {
            $this->session->set_flashdata('feedback', array('error' => TRUE, 'message' => 'Usuario incorrecto'));
        }

        redirect('/');
    }

    public function logout() {
        $this->session->unset_userdata('uid');
        redirect('/');
    }

    public function rememberpass() {
        $data = array(
            'email' => ''
        );

        if( $this->session->flashdata('form') ) {
            $form = $this->session->flashdata('form');
            $data['email'] = $form['email'];
        }

        $this->layout->view('user/rememberpass', $data);
    }

    public function sendrememberpass() {
        $this->load->model('usermodel');

        // If exists, generate token and send email
        $rememberdata = $this->usermodel->generatePassTokenByEmail($this->input->post('email'));

        if( !$rememberdata ) {
            $this->session->set_flashdata('feedback', array(
                'error' => TRUE,
                'message' => 'No existe ningún usuario con ese email.'));

            $this->session->set_flashdata('form', array(
                'email' => $this->input->post('email')
                    ));

            redirect('/user/rememberpass');
        }
        else {
            $body = '';
            $body .= '<img src="'.base_url().'images/logomail.png" />';
            $body .= '<br />';
            $body .= '<p>Has solicitado un recordatorio de tu contrase&ntilde;a olvidadada de <a href="'.base_url().'">750 palabras</a>.</p>';
            $body .= '<p>Para elegir una nueva contrase&ntilde;a, haz clic en el siguiente enlace (si no puedes hacer clic, tambi&eacute;n puedes copiar y pegar en tu navegador):</p>';
            $body .= '<p><a href="'.base_url().'/user/resetpass/'.$rememberdata['token'].'">'.base_url().'user/resetpass/'.$rememberdata['token'].'</a></p>';
            $body .= '<p>Contin&uacute;a escribiendo!</p>';

            $this->load->library('email');
            $this->email->set_newline("\r\n");

            $this->email->clear();

            $this->email->from('alvaro.remesal@gmail.com', '750 palabras');
            $this->email->to( $rememberdata['email'] );

            $this->email->subject('Recuperar password de 750 palabras!');
            $this->email->message( $body );

            if (!$this->email->send()) {
                $this->session->set_flashdata('feedback', array(
                    'message'   => 'Error al enviar el email de recuperaci&oacute;n de contrase&ntilde:<br />'.$this->email->print_debugger(),
                    'error'     => TRUE
                ));
                redirect('/user/rememberpass');
            }
            else {
                redirect('/user/rememberpassok');
            }

            //echo $body;
            //echo "Enviar email a " . $rememberdata['email'] . "con token: " . $rememberdata['token'];
        }
        
    }

    public function resetPass($token = '') {
        // If exists token in database, ask for a new password
        $this->load->model('usermodel');

        // Check if user exists
        $user = $this->usermodel->getUserByToken($token);

        if( !$user ) {
            $this->session->set_flashdata('feedback', array(
                'error' => TRUE,
                'message' => 'El token de recuperación de password es incorrecto.'));

            redirect('/user/rememberpass');
        }
        else {
            $data = array(
                'token' => $token,
                'uid'   => encrypt_safeencode($user['_id'].'')
            );
            $this->layout->view('user/resetpass', $data);
        }
    }

    public function resetnewpass() {
        $this->load->model('usermodel');
        
        $token = $this->input->post('token');

        if( !$this->input->post('pass') ) {
            $this->session->set_flashdata('feedback', array(
                'error' => TRUE,
                'message' => 'Debes escribir una nueva contraseña.'));

            $this->resetPass($token);
        }

        $pass = $this->input->post('pass');
        $uid = encrypt_safedecode($this->input->post('salt'));

        // Check if user exists
        $user = $this->usermodel->getUserByToken($token);

        if( !$user ) {
            $this->session->set_flashdata('feedback', array(
                'error' => TRUE,
                'message' => 'El token de recuperación de password es incorrecto.'));

            redirect('/user/rememberpass');
        }
        else {
            // Update password and clean token
            $user = $this->usermodel->resetUserPass( hash('sha256', $pass), $uid, $token);

            $data = array(
                'status' => $user
            );

            $this->layout->view('user/passresetok', $data);
        }
    }

    public function rememberpassok() {
        $data = array();

        $this->layout->view('user/rememberpassok', $data);
    }

    public function stats() {
        $data = array();

        $this->layout->view('user/stats', $data);
    }
}
?>
