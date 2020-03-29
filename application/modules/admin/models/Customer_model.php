<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    public function __construct()
    {
        parent::__construct();
    }

    public function count_all_customers()
    {
        return $this->db->get('customers')->num_rows();
    }

    public function latest_customers()
    {
        return $this->db->order_by('id', 'DESC')->get('customers')->result();
    }

    public function get_all_customers()
    {
        $customers = $this->db->query("
            SELECT c.user_id as id, c.profile_picture, c.name, u.email, c.phone_number, c.address
            FROM customers c
            JOIN users u
                ON u.id = c.user_id
            ORDER BY u.register_date DESC
        ");
                
        return $customers->result();
    }

    public function delete_customer($id)
    {
        $this->db->query("SET FOREIGN_KEY_CHECKS=0;");
        $this->db->where('user_id', $id)->delete('customers');
        $this->db->where('id', $id)->delete('users');
        $this->db->where('user_id', $id)->delete('orders');
        $this->db->query("
            DELETE order_item
            FROM order_item
            JOIN orders
                ON orders.id = order_item.order_id
            WHERE orders.user_id = '$id'");
        $this->db->query("
            DELETE payments
            FROM payments
            INNER JOIN orders ON orders.id = payments.order_id
            WHERE orders.user_id = '$id'");
        $this->db->query("DELETE orders FROM orders WHERE user_id = '$id'");
    }

    public function is_customer_exist($id)
    {
        return ($this->db->where('user_id', $id)->get('customers')->num_rows() > 0) ? TRUE : FALSE;
    }

    public function customer_data($id)
    {
        $customer = $this->db->query("
            SELECT c.user_id as id, c.profile_picture, c.name, u.email, c.phone_number, c.address, u.register_date
            FROM customers c
            JOIN users u
                ON u.id = c.user_id
            WHERE c.user_id = '$id'
        ");
                
        return $customer->row();
    }
}