<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function register_contact($data)
    {
        $this->db->insert('contacts', $data);

        return $this->db->insert_id();
    }
}