<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with CodeIgniter
  Due date: Dec 5 2016
-->
<?php
class Page4 extends CI_Controller {

    public function __construct() {

        parent::__construct();
        try {
            $this->load->model('Dbmanager');
        } catch (Exception $exp) {
            log_message('error', $exp->getMessage());
        }
    }

    public function index() {
        $userSaved = false;
        $data = array();

        if(isset($_POST['usrname'])){

            $username = $_POST['usrname'];
            $email = $_POST['email'];
            $addr = $_POST['addr'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            $userSaved = $this->Dbmanager->saveUser($username, $email, $addr, $phone, $password);
        }

        $data['userSaved'] = $userSaved;
        $this->load->view('page4', $data);
    }
}
