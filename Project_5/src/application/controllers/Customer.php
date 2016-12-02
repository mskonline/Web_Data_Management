<?php
class Customer extends CI_Controller {

    public function __construct() {

        parent::__construct();
        try {
            $this->load->model('Dbmanager');
        } catch (Exception $exp) {
            log_message('error', $exp->getMessage());
        }
    }

    public function index() {
        $this->load->helper('url'); 
        redirect(site_url('/page1'));
    }
}
