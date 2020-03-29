<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library('encryption');
        $this->load->helper('cookie');
    }

    public function index()
    {
        $check_session_in_cookie = $this->input->cookie('__ACTIVE_SESSION_DATA');
        $check_session_in_session = $this->session->userdata('__ACTIVE_SESSION_DATA');

        if ($check_session_in_cookie)
        {
            delete_cookie('__ACTIVE_SESSION_DATA');

            $this->session->set_flashdata('login_flash', 'Berhasil logout!');
        }
        else if ($check_session_in_session)
        {
            $this->session->unset_userdata('__ACTIVE_SESSION_DATA');

            $this->session->set_flashdata('login_flash', 'Berhasil logout!');
        }
        else
        {
            $this->session->set_flashdata('login_flash', 'Anda belum login!');
        }

        redirect('/auth/login');
    }
}