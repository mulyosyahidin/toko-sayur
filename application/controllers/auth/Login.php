<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library(['form_validation', 'encryption']);
        $this->load->model('auth/Login_model', 'login');
    }

    public function index()
    {
        $params['flash_message'] = $this->session->flashdata('login_flash');
        $params['old_username'] = $this->session->flashdata('old_username');
        
        $params['redirection'] = $this->input->get('redir_to');
        $this->session->set_userdata('redirection', $params['redirection']);

        $this->load->view('auth/login', $params);
    }

    public function do_login()
    {
        $this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');

        $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[16]', [
            'min_length' => 'Username minimal 4 karakter',
            'max_length' => 'Username maksimal 16 karakter',
            'required' => 'Silahkan masukkan Username untuk login'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required', [
            'required' => 'Silahkan masukkan Password akun'
        ]);

        if ($this->form_validation->run() === FALSE)
        {
            $this->index();
        }
        else
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $remember_me = $this->input->post('remember_me');

            $this->login->login($username, $password);

            if ($this->login->is_user_exist())
            {
                $user_password = $this->login->get_password();

                if ( password_verify($password, $user_password))
                {
                    $login_data = [
                        'is_login' => TRUE,
                        'user_id' => $this->login->logged_user_id(),
                        'login_at' => time(),
                        'remember_me' => ($remember_me == 1) ? TRUE : FALSE
                    ];

                    $login_data = json_encode($login_data);
                    $login_session = $this->encryption->encrypt($login_data);

                    $redirection = $this->session->userdata('redirection');
                    if ($redirection)
                    {
                        $redir_to = base64_decode($redirection);

                        $this->session->unset_userdata('redirection');
                    }
                    else
                    {
                        $role = $this->login->get_role();

                        $redir_to = ($role == 'admin') ? 'admin' : 'customer';
                    }
                    
                    if ($remember_me == 1)
                    {
                        $this->input->set_cookie('__ACTIVE_SESSION_DATA', $login_session, 172800); //48 jam
                    }
                    else
                    {
                        $this->session->set_userdata('__ACTIVE_SESSION_DATA', $login_session);
                    }

                    redirect($redir_to);
                }
                else
                {
                    $this->session->set_flashdata('login_flash', 'Password salah!');
                    $this->session->set_flashdata('old_username', $username);

                    redirect('/auth/login');
                }
            }
            else
            {
                $this->session->set_flashdata('login_flash', 'User dengan username <b>'. $username .'</b> tidak terdaftar');

                redirect('/auth/login');
            }
        }
    }
}