<?php
class Page1 extends CI_Controller {

    public function __construct() {

        parent::__construct();
        try {
            $this->load->model('Dbmanager');
        } catch (Exception $exp) {
            log_message('error', $exp->getMessage());
        }
    }

    public function index() {

        $username = $this->input->post('username');
        $validUser = false;
        $data = array('errorMessage'=>'');

        if($username != null){
            $password = $this->input->post('password');
            $validUser = $this->Dbmanager->checkUser($username, $password);

            if($validUser == true){
                session_start();

                $_SESSION['username'] = $username;
                $this->load->helper('url'); 
                redirect(site_url('/page2'));
            } else {
                $data['errorMessage'] = 'Invalid User name or Password';
                $this->load->view('page1', $data);
            }
        } else {
            session_start();
            session_unset();
            session_destroy();

            $this->load->view('page1', $data);
        }
    }
}
