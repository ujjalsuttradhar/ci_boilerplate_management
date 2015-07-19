<?php

/**
 * @author Ujjal <sssujjal@gmail.com>
 */
class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->data["base_url"] = base_url();
        $this->load->model("user_model");

        //set active url if not ovverride
        $this->data["currentMenuParent"] = 'users';
        $this->data["currentMenu"] = 'user_all';
    }

    public function index() {
        //  echo "Logged in";
    }

    public function login() {

        if (isLoggedin())
            redirect($this->data["base_url"] . 'dashboard');

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<div class="error text-red">', '</div>');

        if ($this->form_validation->run() == FALSE) {

            $this->data["login_error"] = $this->session->flashdata('login_error');
            $this->data["login_error_message"] = $this->session->flashdata('login_error_message');

            $this->load->view('users/login_form', $this->data);
        } else {
            $pUsername = trim($this->input->post('username'));
            $pPassword = sha1(trim($this->input->post('password')));

            $user = $this->user_model->checkForValidLogin($pUsername, $pPassword);

            if ($user) 
            {
                $login_data = array('logged_in' => TRUE, 'user' => $user);
                $this->session->set_userdata($login_data);
                $this->session->set_flashdata('login_error', FALSE);
                redirect($this->data["base_url"] . 'dashboard/');
            } else {
                $this->session->set_flashdata('login_error', TRUE);
                $this->session->set_flashdata('login_error_message', "Your ID or Password was entered incorrectly.");

                redirect($this->data["base_url"] . 'users/login');
            }
        }
    }

    public function logout() {
        $this->session->set_userdata('logged_in', FALSE);
        $this->session->sess_destroy();
        redirect($this->data["base_url"] . "users/login");
    }

    public function list_all($param = false) {

        if (!isAdmin(roleOfLoggedinUser()))
            redirect($this->data["base_url"] . 'dashboard');

        $this->data["title"] = "Users List | Progati Creative Ltd";
        $this->data["filter_by_role"] = -1;

        if ($this->input->post("filter_form_submitted") == 1) {
            $this->data["filter_by_role"] = $this->input->post("role_id");
        } else if ($param) {
            $this->data["filter_by_role"] = $param;
        }

        if ($this->session->flashdata('action_status')) {
            $this->data["action_status"] = $this->session->flashdata('action_status');
            $this->data["success_status"] = $this->session->flashdata('success_status');
            $this->data["error_status"] = $this->session->flashdata('error_status');
        } else {
            $this->data["action_status"] = $this->data["success_status"] = $this->data["error_status"] = FALSE;
        }

        $this->data["currentUser"] = getLoggedinUser();
        $userList = $this->user_model->getListOfAllUsers($this->data["currentUser"]->id, $this->data["filter_by_role"]);
        $this->data["userList"] = $userList;

        $this->data["roles"] = $this->user_model->getListOfRoles();

        //set active url
        $this->data["currentMenuParent"] = 'users';
        $this->data["currentMenu"] = 'user_' . $this->data["filter_by_role"];

        $this->load->view('headers/users_list_header', $this->data);
        $this->load->view('headers/common_header', $this->data);
        $this->load->view("dashboard/left_sidebar", $this->data);
        $this->load->view("users/user_list", $this->data);
        $this->load->view("footers/users_list_footer", $this->data);
    }

    public function create() {

        //Only Admin can create new user. 
        if (!isAdmin(roleOfLoggedinUser()))
            redirect($this->data["base_url"] . 'dashboard');

        $this->data["title"] = "New User | Progati Creative Ltd";
        $this->data["currentUser"] = getLoggedinUser();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|callback_role_selected');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[password2]|trim');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim');
        $this->form_validation->set_error_delimiters('<div class="error text-red">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->data["success_status"] = false;
            $this->data["error_status"] = false;
        } else {
            $data["username"] = trim($this->input->post('username'));
            $data["password"] = sha1(trim($this->input->post('password')));
            $data["email"] = trim($this->input->post('email'));
            $data["role_id"] = trim($this->input->post('role_id'));
            //echo $this->input->post('create_user_edit_profile');
            $response = $this->user_model->registerNewUser($data);

            if ($response) {
                $this->data["action_status"] = "Account for " . $data["username"] . " has been created.";
                $this->data["success_status"] = true;
            } else {
                $this->data["action_status"] = "Something went wrong. Try again.";
                $this->data["error_status"] = true;
            }

            if ($this->input->post('create_user_edit_profile') == 2) {
                //create and go to edit profile button is clicked
                redirect('users/update/' . $response);
            }
        }

        $this->data["roles"] = $this->user_model->getListOfRoles();

        $this->load->view('headers/users_list_header', $this->data);
        $this->load->view('headers/common_header', $this->data);
        $this->load->view("dashboard/left_sidebar", $this->data);
        $this->load->view("users/registration_form", $this->data);
        $this->load->view("footers/users_list_footer", $this->data);
    }

    public function username_check($str) {
        if ($this->user_model->checkIfUsernameExists($str)) {
            $this->form_validation->set_message('username_check', 'This %s already exists. Try another.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function role_selected($str) {
        if ($str == '' || $str == 'NULL') {
            $this->form_validation->set_message('role_selected', 'Select Role of the user.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Accessible only by Admin level user 
     */
    public function edit() {
        //Only Admin can edit user
        if (!isAdmin(roleOfLoggedinUser()))
            redirect($this->data["base_url"] . 'dashboard');

        $userid = $this->uri->segment(3);

        $this->data["roles"] = $this->user_model->getListOfRoles();
        $this->data["currentUser"] = getLoggedinUser();


        $this->load->library('form_validation');
        $this->form_validation->set_rules('role_id', 'Role', 'trim|callback_role_selected');
        //$this->form_validation->set_rules('username', 'Username', 'required|trim|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'matches[password2]|trim');
        $this->form_validation->set_rules('password2', 'Confirm Password', 'trim');
        $this->form_validation->set_error_delimiters('<div class="error text-red">', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->data["success_status"] = false;
            $this->data["error_status"] = false;
        } else {
            $username = trim($this->input->post('username'));
            $data["email"] = trim($this->input->post('email'));
            $data["role_id"] = trim($this->input->post('role_id'));

            if ($this->input->post('password'))
                $data["password"] = sha1(trim($this->input->post('password')));

            $data["updated_at"] = date("Y-m-d H:i:s");
            $response = $this->user_model->updateUserInfo($data, $userid, $username);

            if ($response) {
                $this->data["action_status"] = "Some information of <strong>" . $username . "</strong> has been updated.";
                $this->data["success_status"] = true;
            } else {
                $this->data["action_status"] = "Something went wrong. Try again.";
                $this->data["error_status"] = true;
            }
        }

        $this->data["user"] = $this->user_model->getUserDetailsByUserID($userid);
        $this->data["title"] = $this->data["user"]->username . " | Edit Profile | Progati Creative Ltd";

        $this->load->view('headers/users_list_header', $this->data);
        $this->load->view('headers/common_header', $this->data);
        $this->load->view("dashboard/left_sidebar", $this->data);
        $this->load->view("users/edit_user", $this->data);
        $this->load->view("footers/min_footer", $this->data);
    }

    public function delete($param) {
        $userID = $this->uri->segment(3);
        $response = $this->user_model->deleteUserByID($userID);
        if ($response) {
            $this->session->set_flashdata('action_status', 'The user has been deleted successfully.');
            $this->session->set_flashdata("success_status", true);
        } else {
            $this->session->set_flashdata('action_status', 'Something went wrong. Try again.');
            $this->session->set_flashdata("error_status", true);
        }
        redirect($this->data["base_url"] . "users/list_all");
    }

    public function profile() {
        if (!isLoggedin())
            redirect($this->data["base_url"] . 'users/login');

        $userid = $this->uri->segment(3);

        $this->data["roles"] = $this->user_model->getListOfRoles();
        $this->data["currentUser"] = getLoggedinUser();

        $this->data["user"] = $this->user_model->getUserDetailsByUserID($userid);
        $this->data["profile"] = $this->user_model->getProfilesDetailsByUserID($userid);
        $this->data["action_status"] = $this->data["success_status"] = $this->data["error_status"] = FALSE;
        $this->data["title"] = $this->data["user"]->username . " | ManageVC";

        $this->load->view('headers/users_list_header', $this->data);
        $this->load->view('headers/common_header', $this->data);
        $this->load->view("dashboard/left_sidebar", $this->data);
        $this->load->view("users/profile", $this->data);
        $this->load->view("footers/min_footer", $this->data);
    }

    public function update() {
        if (!isLoggedin())
            redirect($this->data["base_url"] . 'users/login');

        $userid = $this->uri->segment(3);

        $this->data["roles"] = $this->user_model->getListOfRoles();
        $this->data["currentUser"] = getLoggedinUser();

        $this->data["user"] = $this->user_model->getUserDetailsByUserID($userid);
        $this->data["profile"] = $this->user_model->getProfilesDetailsByUserID($userid);
        $this->data["title"] = $this->data["user"]->username . " | Update | ManageVC";

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        
        if($this->data["profile"]->role == "Customer")
        {
          $this->form_validation->set_rules('shop_name', 'Shop Name', 'trim|required');
          $this->form_validation->set_rules('prop_name', 'Prop Name', 'trim|required');
        }    
        $this->form_validation->set_error_delimiters('<div class="error text-red">', '</div>');

        $this->data["action_status"] = $this->data["success_status"] = $this->data["error_status"] = FALSE;

        if ($this->form_validation->run() == FALSE) {


            $this->data["action_status"] = $this->session->flashdata("message");
            $this->data["success_status"] = $this->session->flashdata("success_status");
            $this->data["error_status"] = $this->session->flashdata("error_status");


            $this->load->view('headers/update_profile_header', $this->data);
            $this->load->view('headers/common_header', $this->data);
            $this->load->view("dashboard/left_sidebar", $this->data);
            $this->load->view("users/update_profile", $this->data);
            $this->load->view("footers/update_profile_footer", $this->data);
        } else {


            $updateArray = array();
            foreach ($this->data["profile"] as $key => $value) {
                if ($key == "id" || $key == "role" || $key == "username" || $key == "photo" || $key == "created_at" || $key == "email") {
                    continue;
                }

                if ($key == "security") {
                    $serialized_boxes = serialize($this->input->post("sc"));
                    $updateArray["security"] = $serialized_boxes;
                } else if ($key == "zone") {
                    $updateArray["zone_id"] = $this->input->post("zone_id");
                } else if ($key == "area") {
                    $updateArray["area_id"] = $this->input->post("area_id");
                }
                else
                {
                    $updateArray[$key] = $this->input->post($key);
                }
            }
           
            $updateArray["updated_at"] = date("Y-m-d H:i:s");
            
            $response = $this->user_model->updateProfileData($this->data["user"]->id, $updateArray);
            if ($response) {
                $this->session->set_flashdata("message", "Profile has been updated successfully.");
                $this->session->set_flashdata("success_status", true);
            } else {
                $this->session->set_flashdata("message", "Something went wrong. Try again.");
                $this->session->set_flashdata("error_status", true);
            }

            redirect($this->data["base_url"] . "users/update/" . $userid);
        }
    }

    /**
     * get Called from custom.js
     * onChange of #zoneList
     */
    public function getAreasOfParticularZone() {
        $param = mysql_real_escape_string($_POST["zoneID"]);
        $response = $this->user_model->getListOfAreasOfZone($param);
        echo json_encode($response);
    }

    public function upload_photo() {

        $userid = $this->input->post("userid");
        ########### Configuration ##############
        $thumb_square_size = 200; //Thumbnails will be cropped to 200x200 pixels
        $max_image_size = 500; //Maximum image size (height and width)
        $thumb_prefix = "thumb_"; //Normal thumb Prefix
        $destination_folder = "resources/uploads/profile_pics/"; //upload directory ends with / (slash)
        $jpeg_quality = 90; //jpeg quality
##########################################
//continue only if $_POST is set and it is a Ajax request
        if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            // check $_FILES['ImageFile'] not empty
            if (!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])) {
                die('Image file is Missing!'); // output error when above checks fail.
            }

            //get uploaded file info before we proceed
            $image_name = $_FILES['image_file']['name']; //file name
            $image_size = $_FILES['image_file']['size']; //file size
            $image_temp = $_FILES['image_file']['tmp_name']; //file temp

            $image_size_info = getimagesize($image_temp); //gets image size info from valid image file

            if ($image_size_info) {
                $image_width = $image_size_info[0]; //image width
                $image_height = $image_size_info[1]; //image height
                $image_type = $image_size_info['mime']; //image type
            } else {
                die("Make sure image file is valid!");
            }

            //switch statement below checks allowed image type 
            //as well as creates new image from given file 
            switch ($image_type) {
                case 'image/png':
                    $image_res = imagecreatefrompng($image_temp);
                    break;
                case 'image/gif':
                    $image_res = imagecreatefromgif($image_temp);
                    break;
                case 'image/jpeg': case 'image/pjpeg':
                    $image_res = imagecreatefromjpeg($image_temp);
                    break;
                default:
                    $image_res = false;
            }

            if ($image_res) {
                //Get file extension and name to construct new file name 
                $image_info = pathinfo($image_name);
                $image_extension = strtolower($image_info["extension"]); //image extension
                $image_name_only = strtolower($image_info["filename"]); //file name only, no extension
                //create a random name for new image (Eg: fileName_293749.jpg) ;
                $new_file_name = str_replace(" ", "_", $image_name_only) . '_' . rand(0, 9999999999) . '.' . $image_extension;

                //folder path to save resized images and thumbnails
                $thumb_save_folder = $destination_folder . $thumb_prefix . $new_file_name;
                $image_save_folder = $destination_folder . $new_file_name;

                //call normal_resize_image() function to proportionally resize image
                if ($this->normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality)) {
                    //call crop_image_square() function to create square thumbnails
                    if (!$this->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality)) {
                        die('Error Creating thumbnail');
                    }

                    /* We have succesfully resized and created thumbnail image
                      We can now output image to user's browser or store information in the database */
//                    echo '<div align="center">';
//                    echo '<img src="resources/uploads/profile_pics/' . $thumb_prefix . $new_file_name . '" alt="Thumbnail">';
//                    echo '<br />';
//                    echo '<img src="resources/uploads/profile_pics/' . $new_file_name . '" alt="Resized Image">';
//                    echo '</div>';

                    $updated = $this->user_model->updateProfilePhoto($new_file_name, $userid);
                    echo '<img src="' . base_url() . 'resources/uploads/profile_pics/' . $new_file_name . '" alt="Resized Image">';
//                    
                }

                imagedestroy($image_res); //freeup memory
            }
        }
    }

#####  This function will proportionally resize image ##### 

    private function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality) {

        if ($image_width <= 0 || $image_height <= 0) {
            return false;
        } //return false if nothing to resize
        //do not resize if image is smaller than max size
        if ($image_width <= $max_size && $image_height <= $max_size) {
            if ($this->save_image($source, $destination, $image_type, $quality)) {
                return true;
            }
        }

        //Construct a proportional size of new image
        $image_scale = min($max_size / $image_width, $max_size / $image_height);
        $new_width = ceil($image_scale * $image_width);
        $new_height = ceil($image_scale * $image_height);

        $new_canvas = imagecreatetruecolor($new_width, $new_height); //Create a new true color image
        //Copy and resize part of an image with resampling
        if (imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)) {
            $this->save_image($new_canvas, $destination, $image_type, $quality); //save resized image
        }

        return true;
    }

##### This function corps image to create exact square, no matter what its original size! ######

    public function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality) {
        if ($image_width <= 0 || $image_height <= 0) {
            return false;
        } //return false if nothing to resize

        if ($image_width > $image_height) {
            $y_offset = 0;
            $x_offset = ($image_width - $image_height) / 2;
            $s_size = $image_width - ($x_offset * 2);
        } else {
            $x_offset = 0;
            $y_offset = ($image_height - $image_width) / 2;
            $s_size = $image_height - ($y_offset * 2);
        }
        $new_canvas = imagecreatetruecolor($square_size, $square_size); //Create a new true color image
        //Copy and resize part of an image with resampling
        if (imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)) {
            $this->save_image($new_canvas, $destination, $image_type, $quality);
        }

        return true;
    }

##### Saves image resource to file ##### 

    public function save_image($source, $destination, $image_type, $quality) {
        switch (strtolower($image_type)) {//determine mime type
            case 'image/png':
                imagepng($source, $destination);
                return true; //save png file
                break;
            case 'image/gif':
                imagegif($source, $destination);
                return true; //save gif file
                break;
            case 'image/jpeg': case 'image/pjpeg':
                imagejpeg($source, $destination, $quality);
                return true; //save jpeg file
                break;
            default: return false;
        }
    }

    public function getAutoCompleteSuggestion() {
        $search = trim($this->input->get("query"));
        $found_users = $this->user_model->findUsersLikeKeyword($search);

        echo json_encode($found_users);
    }

    /**
     * Update Credit Limit For Customer
     */
    public function updateCreditLimit() {
        if (!isLoggedin())
            redirect($this->data["base_url"] . 'users/login');

        $userid = $this->uri->segment(3);


        $this->data["creditLimits"] = $this->user_model->getListOfCreditLimitsByCustID($userid);
        $this->data["roles"] = $this->user_model->getListOfRoles();
        $this->data["currentUser"] = getLoggedinUser();

        if (roleOfLoggedinUser() != 4)
            $this->data['disabled'] = "disabled";
        else
            $this->data['disabled'] = '';

        $this->data["user"] = $this->user_model->getUserDetailsByUserID($userid);

        if ($this->data["user"]->role_id != 2)
            redirect($this->data["base_url"] . 'dashboard/');

        $this->data["profile"] = $this->user_model->getProfilesDetailsByUserID($userid);
        $this->data["zones"] = $this->user_model->getListOfZones();
        $this->data["title"] = 'Update Credit Limit | ' . $this->data["user"]->username . " | Progati Creative Ltd";

        $this->data["brands"] = $this->user_model->getListOfUsersByRoleId(1);


        $this->load->library('form_validation');
        $this->form_validation->set_rules('brand_id', 'Brand Id', 'trim|callback_brand_selected');
        $this->form_validation->set_rules('credit_limit', 'Credit Limit', 'trim|required|numeric');
        $this->form_validation->set_rules('initial_balance', 'Initial Balance', 'trim|required|numeric');
        $this->form_validation->set_error_delimiters('<div class="error text-red">', '</div>');

        $this->data["action_status"] = $this->data["success_status"] = $this->data["error_status"] = FALSE;


        $this->data['brand_id'] = $this->input->post('brand_id');
        $this->data['credit_limit'] = $this->input->post('credit_limit');

        if ($this->form_validation->run() == FALSE) {

            $this->data["action_status"] = $this->session->flashdata("action_status");
            $this->data["success_status"] = $this->session->flashdata("success_status");
            $this->data["error_status"] = $this->session->flashdata("error_status");


            $this->load->view('headers/update_profile_header', $this->data);
            $this->load->view('headers/common_header', $this->data);
            $this->load->view("dashboard/left_sidebar", $this->data);
            $this->load->view("users/update_credit_limit", $this->data);
            $this->load->view("footers/update_profile_footer", $this->data);
        } else {

            $data["customer_id"] = $userid;
            $data['company_id'] = $this->input->post('brand_id');
            $data['credit_limit'] = $this->input->post('credit_limit');
            $data['initial_balance'] = $this->input->post('initial_balance');

            $response = $this->user_model->addCreditLimit($data);
            if ($response) {
                $this->session->set_flashdata("action_status", "Credit Limit has been updated successfully.");
                $this->session->set_flashdata("success_status", true);
            } else {
                $this->session->set_flashdata("action_status", "Something went wrong. Try again.");
                $this->session->set_flashdata("error_status", true);
            }

            redirect($this->data["base_url"] . "users/updateCreditLimit/" . $userid);
        }
    }

    public function brand_selected($str) {
        if ($str == '' || $str == 'NULL' || $str == "-1") {
            $this->form_validation->set_message('brand_selected', 'Select Brand ID.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function deleteCreditLimit() {
        if (!isLoggedin())
            redirect($this->data["base_url"] . 'users/login');

        $customerId = $this->uri->segment(3);
        $creditLimitId = $this->uri->segment(4);

        $response = $this->user_model->deleteCreditLimitByID($creditLimitId);
        if ($response) {
            $this->session->set_flashdata('action_status', 'The Credit Limit Entry has been deleted successfully.');
            $this->session->set_flashdata("success_status", true);
        } else {
            $this->session->set_flashdata('action_status', 'Something went wrong. Try again.');
            $this->session->set_flashdata("error_status", true);
        }
        redirect($this->data["base_url"] . "users/updateCreditLimit/" . $customerId);
    }

}

?>
