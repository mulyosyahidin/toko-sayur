<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('init'))
{
    function init()
    {
        $CI =& get_instance();
        return $CI;
    }
}

if ( ! function_exists('user_data')) {
    function user_data() {
        $CI = init();
        $user_id = get_current_user_id();

        $user_data = $CI->db->where('id', $user_id)->get('users')->row();
        return $user_data;
    }
}

if( ! function_exists('session_data'))
{
    function session_data()
    {
        $CI = init();

        $CI->load->library('encryption');
        $CI->load->helper('cookie');

        $read_session_in_cookie = get_cookie('__ACTIVE_SESSION_DATA');
        $read_session_in_session = $CI->session->userdata('__ACTIVE_SESSION_DATA');

        if ($read_session_in_cookie)
        {
            $read_data = $CI->encryption->decrypt($read_session_in_cookie);
            $read_data = json_decode($read_data);

            return $read_data;
        }
        else if ($read_session_in_session)
        {
            $read_data = $CI->encryption->decrypt($read_session_in_session);
            $read_data = json_decode($read_data);

            return $read_data;
        }
        else {
            $default_session = new stdClass();

            $default_session->is_login = FALSE;
            $default_session->user_id = 0;
            $default_session->login_at = 0;
            $default_session->remember_me = FALSE;

            return $default_session;
        }
    }
}

if ( ! function_exists('is_login'))
{
    function is_login()
    {
        $login_data = session_data();

        return ($login_data->is_login === TRUE);
    }
}

if ( ! function_exists('get_current_user_id'))
{
    function get_current_user_id()
    {
        $login_data = session_data();

        return $login_data->user_id;
    }
}

if ( ! function_exists('verify_session'))
{
    function verify_session($what_to_verify)
    {
        $current_url = current_url();
        $current_url = base64_encode($current_url);

        if ( ! is_login())
        {
            redirect('auth/login?redir_to='. $current_url);
        }
        else if ($what_to_verify == 'admin') {
            if ( ! is_admin()) {
                redirect('auth/login?redir_to='. $current_url);
            }
        }
        else if ($what_to_verify == 'customer') {
            if ( ! is_customer()) {
                redirect('auth/login?redir_to='. $current_url);
            }
        }
    }
}

if ( ! function_exists('is_admin')) {
    function is_admin() {
        $user_data = user_data();
        $role = $user_data->role_id;

        return ($role == 1);
    }
}

if ( ! function_exists('is_customer')) {
    function is_customer() {
        $user_data = user_data();
        $role = $user_data->role_id;

        return ($role == 2);
    }
}