<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_model extends CI_Model {
    public function __construct() {
      parent::__construct();
    }
    public function registerUser($data)
    {
       return $this->db->insert('user',$data);
    }
    public function checkEmail($email)
    {   
        $this->db->where('email',$email);
        $query = $this->db->get('user');
        return $query->row_array();
    }
    
    public function loginUser($email,$password)
    {   
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query = $this->db->get('user');
     //   print_r($this->db->last_query());die;
        return $query->row_array();
    }
}
?>