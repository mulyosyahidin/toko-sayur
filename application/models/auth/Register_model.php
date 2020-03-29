<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function register_user($data)
    {
        $this->db->insert('users', $data);

        return $this->db->insert_id();
    }

    public function register_customer($data)
    {
        $this->db->insert('customers', $data);

        return $this->db->insert_id();
    }

}