<?php

require_once APPPATH . '/models/base_model.php';

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getListOfAllUsers() {
        $this->db->select('*');
        $result = $this->db->get('users');

        $results = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
                $results[] = $row;

            return $results;
        } else {
            return FALSE;
        }
    }

    public function getTotalSaleOfProgatiByType($date = false, $sale_type = 1) {
        if (!$date)
            $date = date('Y-m-d');
        
// If sale_type is credit, then for prod_cement_order consider sale_type 3 too 
        $temp="";
        if($sale_type == 2)
            $temp = " OR sale_type = 3";

        $query = "SELECT SUM(total_price) as amount FROM ( SELECT total_price FROM `prod_bitumin_order` WHERE selling_date = ? and sale_type = ?
UNION 
SELECT total_price FROM `prod_cement_order` WHERE selling_date = ? and (sale_type = ?".$temp.")
UNION
SELECT total_price FROM `prod_rod_order` WHERE selling_date = ? and sale_type = ?
) as query1";

        $result = $this->db->query($query, array($date, $sale_type, $date, $sale_type, $date, $sale_type));
        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function getTotalBankBalanceOfProgati() {

        $query = "SELECT SUM(current_balance) as current_balance FROM bank_accounts";

        $result = $this->db->query($query);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return FALSE;
        }
    }

    public function getLastMonthsSaleData($today = false) {
        if (!$today)
            $today = date('Y-m-d');
        $startDate = $today - 30;

        $query = "SELECT selling_date, SUM(cash) as total_cash, SUM(credit) as total_credit FROM (
SELECT selling_date, (CASE WHEN sale_type = 1 Then total_price Else 0 END) as cash, (CASE WHEN sale_type = 2 Then total_price Else 0 END) as credit FROM `prod_bitumin_order` WHERE selling_date between ? and ?
UNION 
SELECT selling_date, (CASE WHEN sale_type = 1 Then total_price Else 0 END) as cash, (CASE WHEN (sale_type = 2 or sale_type = 3) Then total_price Else 0 END) as credit FROM `prod_cement_order` WHERE selling_date between ? and ?
UNION
SELECT selling_date, (CASE WHEN sale_type = 1 Then total_price Else 0 END) as cash, (CASE WHEN sale_type = 2 Then total_price Else 0 END) as credit FROM `prod_rod_order` WHERE selling_date between ? and ?
) as query1 group by selling_date";

        $result = $this->db->query($query, array($startDate, $today, $startDate, $today, $startDate, $today));
        $results = array();

        if ($result->num_rows() > 0) {
            foreach ($result->result() as $row)
                $results[] = $row;
            return $results;
        } else {
            return FALSE;
        }
    }

    public function cleanTestDB() {
        $tables = array('bank_accounts', 'prod_cement', 'prod_cement_retail', 'prod_rod', 'prod_bitumen', 'expenditure', 'prod_cement_retail', 'prod_bitumin_order', 'prod_rod_order', 'prod_cement_order', 'physical_cost', 'loans', 'employee_absence_history','credit_limit');
        $responseString = "";
        foreach ($tables as $table) {
            $response = $this->db->empty_table($table);
            if ($response)
                $responseString .= "Cleaned " . $table . '</br>';
        }
        
      $this->db->where('role_id <>', '4');
      $this->db->delete('users'); 
      $responseString .= "Cleaned users</br>Cleaned profiles</br>";
                
        return $responseString;
    }

}

?>
