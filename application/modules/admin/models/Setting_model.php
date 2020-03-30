<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends CI_Model {
    public $user_id;

    public function __construct()
    {
        parent::__construct();

        $this->user_id = get_current_user_id();
    }

    public function get_profile()
    {
        $id = $this->user_id;
        $user = $this->db->where('id', $id)->get('users');

        return $user->row();
    }

    public function update_profile($data)
    {
        $id = $this->user_id;

        return $this->db->where('id', $id)->update('users', $data);
    }
}