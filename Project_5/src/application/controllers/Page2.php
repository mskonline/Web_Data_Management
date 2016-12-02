<!--
  Student Name:  Manakan, Sai Kumar
  ID: 1001236131
  Email: saikumar.manakan@mavs.uta.edu
  Project Name: PHP Scripting with Relational Database with CodeIgniter
  Due date: Dec 5 2016
-->
<?php
class Page2 extends CI_Controller {

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
            $validUser = true;
            $username = $_SESSION['username'];
            $data = array();
            $searchText = '';

            // Search
            if(isset($_POST['searchBy']) && $_POST['searchBy'] != '') {
                $searchText = $_POST['searchText'];
                $searchResults = $this->Dbmanager->execBookSearch($searchText, $_POST['searchBy']);

                if($searchResults != null && $searchResults->num_rows() > 0)
                    $showSearchTable = true;
            } else if(isset($_POST['addToBasket']) && $_POST['addToBasket'] != ''){
                // Add to Basket
                $isbn = $_POST['addToBasket'];

                $this->Dbmanager->addBookToBasket($username, $isbn);
            }

            $basketCount = $this->Dbmanager->getBasketItemsCount($username);

            $data['searchResults'] = $searchResults;
            $data['showSearchTable'] = $showSearchTable;
            $data['searchText'] = $searchText;
            $data['validUser'] = $validUser;
            $data['username'] = $username;
            $data['basketCount'] = $basketCount;

            $this->load->view('page2', $data);
        }
    }
}
