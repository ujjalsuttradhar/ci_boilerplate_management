<?php

/**
 * @author ujjal <ujjalsuttradhar@gmail.com>
 */

require_once APPPATH.'/models/base_model.php';

class User_model extends Base_Model {

    protected $users_table;
    protected $roles_table;
    protected $zones_table;
    protected $areas_table;
    protected $brands_table;
    protected $profiles_table;
    protected $credit_limit_table;

    public function __construct() {
        parent::__construct();
        $this->users_table = "users";
        $this->roles_table = "roles";
        $this->zones_table = "zones";
        $this->areas_table = "areas";
        $this->brands_table = "brands";
        $this->profiles_table = "profiles";
        $this->credit_limit_table = "credit_limit";
    }

    public function checkForValidLogin($username, $password) {
        $this->db->select('*');
        $this->db->where(array('username' => $username, 'password' => $password));
        $result = $this->db->get($this->users_table);

        if ($result->num_rows() > 0) {
            //valid login inforations
            $this->db->select('u.*, p.photo, p.name');
            $this->db->from($this->users_table . " As u");
            $this->db->join($this->profiles_table . " As p", 'u.id = p.user_id', 'left');
            $this->db->where('u.username', $username);
            $result = $this->db->get();
            return $result->row();
        }
        else
            return FALSE;
    }

    public function getListOfAllUsers($currentUserId, $role_id = -1) {
        $this->db->select('*, u.id as id');
        $this->db->from($this->users_table . ' As u');
        $this->db->join($this->roles_table . ' As r', 'u.role_id = r.id', 'left');
        $this->db->where("u.id !=", $currentUserId);
        if ($role_id != -1)
            $this->db->where("u.role_id", $role_id);
        $this->db->order_by('u.created_at', 'DESC');

        $result = $this->db->get();

        $results = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
                $results[] = $row;

            return $results;
        } else {
            return FALSE;
        }
    }

    public function getListOfRoles() {
        $this->db->select('*');
        $result = $this->db->get($this->roles_table);

        $results = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
                $results[] = $row;

            return $results;
        } else {
            return FALSE;
        }
    }

    public function getListOfUsersByRoleId($role_id) {
        $this->db->select('*, u.id as id');
        $this->db->from($this->users_table . ' As u');
        $this->db->join($this->profiles_table . ' As p', 'u.id = p.user_id', 'left');
        $this->db->where("u.role_id", $role_id);


        $result = $this->db->get();

        $results = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
                $results[] = $row;

            return $results;
        } else {
            return FALSE;
        }
    }

    public function checkIfUsernameExists($username) {
        $this->db->select('*');
        $this->db->where('username', $username);
        $result = $this->db->get($this->users_table);

        if ($result->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function registerNewUser($data) {
        $this->db->insert('users', $data);

        if ($this->db->affected_rows() === 1) {
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function getUserDetailsByUserID($userID) {
        $this->db->select('*');
        $this->db->where('id', $userID);
        $result = $this->db->get($this->users_table);

        if ($result->num_rows() > 0)
            return $result->row();
        else
            return FALSE;
    }

    public function updateUserInfo($data, $userid, $username) {
        $this->db->where(array('id' => $userid, 'username' => $username));
        $this->db->update($this->users_table, $data);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateProfileData($userid, $data) {
        $this->db->select('*');
        $this->db->where("user_id", $userid);
        $res = $this->db->get($this->profiles_table);

        if ($res->num_rows > 0) {
            $this->db->where('user_id', $userid);
            $this->db->update($this->profiles_table, $data);

            if ($this->db->affected_rows() === 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $data["user_id"] = $userid;
            $this->db->insert($this->profiles_table, $data);

            if ($this->db->affected_rows() === 1) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function updateProfilePhoto($photoTitle, $userid) {

        $data["photo"] = $photoTitle;
        $data["updated_at"] = date("Y-m-d");

        $this->db->where('user_id', $userid);
        $this->db->update($this->profiles_table, $data);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteUserByID($userid) {
        $this->db->where('id', $userid);
        $this->db->delete($this->users_table);

        if ($this->db->affected_rows() === 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findUsersLikeKeyword($keyword = "") {
        $this->db->select("user_id, name, address");
        $this->db->like('name', $keyword);
        $users = $this->db->get($this->profiles_table);

        $results = array();
        if ($users->num_rows() > 0) {
            foreach ($users->result() as $row)
                $results[] = $row;

            return $results;
        }
    }

}

?>
