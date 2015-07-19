<?php

/**
 * @author ujjal <ujjalsuttradhar@gmail.com>
 */
class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data["base_url"] = base_url();
        $this->load->model("dashboard_model");
    }

    public function index() {

        if ($this->session->userdata('logged_in'))
            $this->dashboard();
        else
            redirect($this->data["base_url"] . 'users/login');
    }

    public function dashboard() {

        //populating data for dashboard
        $userList = $this->dashboard_model->getListOfAllUsers();
        $this->data["userList"] = $userList;
        
        $currentUser = array(); // $currentUser will contain some basic data about current logged in user
        $currentUser = $this->session->userdata('user');
        $this->data["currentUser"] = $currentUser;
        $this->data["title"] = "Dashboard | Progati Creative Ltd.";

        //set active url
        $this->data["currentMenuParent"] = 'dashboard';
        $this->data["currentMenu"] = 'dashboard';

        $this->load->view('headers/dashboard_header', $this->data);
        $this->load->view('headers/common_header', $this->data);
        $this->load->view("dashboard/left_sidebar", $this->data);
        $this->load->view("dashboard/dashboard", $this->data);
        $this->load->view("footers/dashboard_footer", $this->data);
    }
            
}
?>
