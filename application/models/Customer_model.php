<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function data()
    {
        $id = get_current_user_id();

        $data = $this->db->where('user_id', $id)->get('customers')->row();
        return $data;
    }

    public function is_coupon_exist($code)
    {
        return ($this->db->where('code', $code)->get('coupons')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function is_coupon_active($code)
    {
        return ($this->db->where('code', $code)->get('coupons')->row()->is_active == 1) ? TRUE : FALSE;
    }

    public function is_coupon_expired($code)
    {
        $data = $this->db->where('code', $code)->get('coupons')->row();
        $expired_at = $data->expired_date;

        return (strtotime($expired_at) > time()) ? FALSE : TRUE;
    }

    public function get_coupon_credit($code)
    {
        $data = $this->db->where('code', $code)->get('coupons')->row();
        $credit = $data->credit;

        return $credit;
    }

    public function get_coupon_id($code)
    {
        $data = $this->db->where('code', $code)->get('coupons')->row();
        
        return $data->id;
    }

}