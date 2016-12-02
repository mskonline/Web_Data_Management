<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with CodeIgniter
  Due date: Dec 5 2016
-->
<?php
class Page3 extends CI_Controller {

    public function __construct() {

        parent::__construct();
        try {
            $this->load->model('Dbmanager');
        } catch (Exception $exp) {
            log_message('error', $exp->getMessage());
        }
    }

    public function index() {

        $validUser = false;
        $showSearchTable = false;
        $searchResults = null;
        $searchText = '';

        session_start();

        if(!isset($_SESSION['username'])){
            $this->load->view('no_user_session');
        } else {
            $username = $_SESSION['username'];
            
            if(isset($_POST['basketAction'])){
                $this->Dbmanager->buyBasketItems($username);
            }

            $basketItems = $this->Dbmanager->getBasketItems($username);

            $data['basketItems'] = $basketItems;
            $data['username'] = $username;

            $this->load->view('page3', $data);
        }
    }
}
