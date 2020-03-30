<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model(array(
            'product_model' => 'product',
            'customer_model' => 'customer',
            'order_model' => 'order',
            'payment_model' => 'payment'
        ));
    }

    public function index()
    {
        $params['title'] = 'Admin '. get_store_name();

        $overview['total_products'] = $this->product->count_all_products();
        $overview['total_customers'] = $this->customer->count_all_customers();
        $overview['total_order'] = $this->order->count_all_orders();
        $overview['total_income'] = $this->payment->sum_success_payment();

        $overview['products'] = $this->product->latest();
        $overview['categories'] = $this->product->latest_categories();
        $overview['payments'] = $this->payment->payment_overview();
        $overview['orders'] = $this->order->latest_orders();
        $overview['customers'] = $this->customer->latest_customers();

        $overview['order_overviews'] = $this->order->order_overview();
        $overview['income_overviews'] = $this->order->income_overview();

        $this->load->view('header', $params);
        $this->load->view('overview', $overview);
        $this->load->view('footer');
    }
}