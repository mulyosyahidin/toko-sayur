<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_contacts()
    {
        return $this->db->order_by('contact_date', 'DESC')->get('contacts')->result();
    }

    public function is_contact_exist($id)
    {
        return ($this->db->where('id', $id)->get('contacts')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function contact_data($id)
    {
        return $this->db->where('id', $id)->get('contacts')->row();
    }

    public function set_status($id, $status)
    {
        return $this->db->where('id', $id)->update('contacts', array('status' => $status));
    }
}