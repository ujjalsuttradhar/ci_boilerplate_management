<?php

/**
 * base model
 * @author Ujjal Suttra Dhar <sssujjal@gmail.com>
 * 11th January, 2015
 */
class Base_Model extends CI_Model {

    protected $users_table;
    protected $profiles_table;
    
    public function __construct() {
        parent::__construct();
        $this->users_table = "users";
        $this->profiles_table = "profiles";
    }
    
    public function resetDB(){
        
    }

    public function getProfilesDetailsByUserID($userID) {

        $query = "SELECT query1.id, query1.username, query1.email,  
query1.address, query1.cell_no,
query1.photo, query1.name,
query5.role, query1.created_at, query1.updated_at From (
SELECT u.id, u.username, u.email, u.role_id,  p.cell_no, p.photo, p.name, p.address, u.created_at,p.updated_at

from users as u left join profiles as p On u.id = p.user_id Where u.id = ?     
) query1 
Left Join
(
select * from roles
) query5 On query1.role_id = query5.id
";

        $result = $this->db->query($query, $userID);

        if ($result->num_rows() > 0)
            return $result->row();
        else
            return FALSE;
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
}
?>
