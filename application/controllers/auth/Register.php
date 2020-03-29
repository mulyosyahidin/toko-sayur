<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['form_validation', 'encryption']);
        $this->load->model('auth/Register_model', 'register');
    }

    public function index()
    {
        $this->load->view('auth/register');
    }

    public function verify()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger font-weight-bold"><small>', '</small></div>');

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[16]|is_unique[users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
        $this->form_validation->set_rules('name', 'Nama lengkap', 'required');
        $this->form_validation->set_rules('phone_number', 'No. HP', 'required|min_length[9]|max_length[16]|is_unique[customers.phone_number]');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[10]');
        $this->form_validation->set_rules('address', 'Alamat', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $name = $this->input->post('name');
            $phone_number = $this->input->post('phone_number');
            $email = $this->input->post('email');
            $address = $this->input->post('address');

            $password = password_hash($password, PASSWORD_BCRYPT);

            $user_data = array(
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'role_id' => 2,
                'register_date' => date('Y-m-d H:i:s')
            );
            
            $user = $this->register->register_user($user_data);

            $customer_data = array(
                'user_id' => $user,
                'name' => $name,
                'phone_number' => $phone_number,
                'address' => $address
            );

            $this->register->register_customer($customer_data);

            $login_data = [
                'is_login' => TRUE,
                'user_id' => $user,
                'login_at' => time(),
                'remember_me' => FALSE
            ];

            $login_data = json_encode($login_data);
            $login_session = $this->encryption->encrypt($login_data);
            $this->session->set_userdata('__ACTIVE_SESSION_DATA', $login_session);

            $this->session->set_flashdata('store_flash', 'Pendaftaran akun berhasil!');

            redirect('customer');
        }
    }
}