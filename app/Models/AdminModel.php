<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        helper('date');
    }

    
    function authenticateAdmin($email, $password) {
        $md5_pass = md5((string)$password); // This avoids warning if $password is null
        $sql = "SELECT * FROM `users_tbl` WHERE (users_tbl.user_type = 3 or users_tbl.user_type = 4 or users_tbl.user_type = 5 or users_tbl.user_type = 7) and users_tbl.email = '" . $email . "' and users_tbl.password = '" . $md5_pass . "'";
        $query = $this->db->query($sql);
        if ($query->getNumRows()== 1) {
            $result = $query->getRow();
            return $result;
        } else {
            return null;
        }
	}

}