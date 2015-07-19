<?php

/*
 * @author Ujjal Suttra Dhar
 */

function isLoggedin() {
    $CI = & get_instance();

    if ($CI->session->userdata('logged_in'))
        return TRUE;
    else
        return FALSE;
}

/**
 *
 * @return int role of the user (positive integer), -1 if not loggedin
 */
function roleOfLoggedinUser() {
    $CI = & get_instance();

    if (isLoggedin()) {
        return $CI->session->userdata('user')->role_id;
    }

    return false;
}

function getLoggedinUser() {
    $CI = & get_instance();

    if (isLoggedin()) {
        return $CI->session->userdata('user');
    }

    return FALSE;
}

function isAdmin(){
    return 1 || 2;
}

// Use : views/profile.php
function getFieldLabel($columnname) {

    switch ($columnname) {
        case 'id' : return "ID";
        case 'username' : return "Username";
        case 'name' : return "Full Name";
        case 'address' : return "Address";
        case 'cell_no' : return "Phone";
        case 'email' : return "Email ID";
        case 'initial_balance' : return "Initial Balance";
        case 'photo' : return "Photo";
        case 'created_at' : return "Since";
        case 'role' : return "Role";
        default : return false;
    }
}

// Use : views/profile.php
function getFieldIcon($columnname) {

    switch ($columnname) {
        case 'id' : return "fa fa-search";
        case 'username' : return "fa fa-user";
        case 'name' : return "fa fa-user";
        case 'address' : return "fa fa-home";
        case 'cell_no' : return "fa fa-phone";
        case 'email' : return "fa fa-user";
        case 'initial_balance' : return "fa fa-money";
        case 'photo' : return "fa fa-user";
        case 'created_at' : return "fa fa-calendar";
        case 'role' : return "fa fa-cog";
        default : return false;
    }
}

// Use : views/profile.php
function validateProfileData($value) {
    return ($value == NULL || $value == "") ? "N/A" : $value;
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function changeDateTimeFormat($datetime, $format = "d M Y") {
    if ($datetime == null || $datetime == "" || $datetime == "N/A")
        return "N/A";
    return date($format, strtotime($datetime));
}

function getNameOfUsersByUserID($userID) {
    $CI = & get_instance();
    $CI->load->database();

    $query = "SELECT p.name from users as u left join profiles as p On u.id = p.user_id Where u.id = ?";

    $result = $CI->db->query($query, $userID);

    if ($result->num_rows() > 0)
        return $result->row()->name;
    else
        return FALSE;
}

/**
 * @param type $number Decimal Number
 * @param type $round Precision
 * @return type $number in $decimal point precision
 */
function roundDecimalNumber($number, $round = 2) {
    return round($number, $round);
}

function setToZeroIfNULL($number) {
    if ($number > 0)
        return $number;
    else
        return 0;
}

function validateDate($dateString = "") {
    if ($dateString == "0000-00-00")
        return "";
    else
        return $dateString;
}

function ifHasActiveUrl($currentMenuParent, $currentUrl) {
    return ($currentMenuParent == $currentUrl) ? ' active' : '';
}

function ifActiveUrl($currentMenu, $currentUrl) {
    return ($currentMenu == $currentUrl) ? 'class="active"' : '';
}

function getAmountinWords($number) {
    if (($number < 0) || ($number > 999999999)) {
        throw new Exception("Number is out of range");
    }

    $Gn = floor($number / 100000);  /* Millions (giga) */
    $number -= $Gn * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */

    $res = "";

    if ($Gn) {
        $res .= getAmountinWords($Gn) . " Lacs";
    }

    if ($kn) {
        $res .= (empty($res) ? "" : " ") .
                getAmountinWords($kn) . " Thousand";
    }

    if ($Hn) {
        $res .= (empty($res) ? "" : " ") .
                getAmountinWords($Hn) . " Hundred";
    }

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety");

    if ($Dn || $n) {
        if (!empty($res)) {
            $res .= " and ";
        }

        if ($Dn < 2) {
            $res .= $ones[$Dn * 10 + $n];
        } else {
            $res .= $tens[$Dn];

            if ($n) {
                $res .= "-" . $ones[$n];
            }
        }
    }

    if (empty($res)) {
        $res = "zero";
    }

    return $res;
}

//Auto Generation function to create User
// Use : views/profile.php
function generateUserID($id) {
    return "manageVC_" . $id;
}

function getItemNumberToShowPerPagePagination(){
    return 5;
}
?>
