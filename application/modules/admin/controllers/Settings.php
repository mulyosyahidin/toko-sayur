<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->library('form_validation');
    }

    public function index()
    {
        $params['title'] = 'Pengaturan';

        $settings['flash'] = $this->session->flashdata('settings_flash');

        $this->load->view('header', $params);
        $this->load->view('settings/settings', $settings);
        $this->load->view('footer');
    }

    public function update()
    {
        $fields = array(
            'store_name', 'store_phone_number', 'store_email', 'store_tagline', 'store_description',
            'store_address', 'min_shop_to_free_shipping_cost', 'shipping_cost'
        );

        foreach ($fields as $field)
        {
            $data = $this->input->post($field);

            update_settings($field, $data);
        }

        $this->session->set_flashdata('settings_flash', 'Pengaturan berhasil diperbarui');
        redirect('admin/settings');
    }
}