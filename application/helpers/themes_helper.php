<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_theme_name'))
{
    function get_theme_name() {
        $current_theme = get_settings('current_theme_name');

        return ($current_theme) ? $current_theme : false;
    }
}

if ( ! function_exists('get_template_part'))
{
    function get_template_part($file_name = null, $params = array()) {
        if ($file_name !== '') {
            $current_theme = get_theme_name();

            if ( file_exists($file_location = VIEWPATH .'themes/'. $current_theme .'/'. $file_name .'.php')) {
                $CI =& get_instance();
                $CI->load->view('themes/'. $current_theme .'/'. $file_name, $params);
            }
            else {
                echo '<div>Kesalahan: berkas tema <b>'. $file_name .'.php</b> tidak ditemukan.<br>Lokasi berkas: <b>'. $file_location .'</b></div>';
            }
        }
    }
}

if ( ! function_exists('get_header'))
{
    function get_header($params = null, $section = '', $current_section = '') {
        $load_params = array();
       
        if ( is_null($params)) {
            $load_params['title'] = get_settings('site_name');
        }
        else if ( is_string($params)) {
            $load_params['title'] = $params;
        }
        else if ( is_array($params)) {
            $load_params = $params;
        }
        else {
            $load_params['title'] = get_settings('site_name');
        }

        $load_params['sidebar_section'] = $section;
        $load_params['current_section'] = $current_section;

        get_template_part('header', $load_params);
    }
}

if ( ! function_exists('get_footer'))
{
    function get_footer($params = array()) {
        get_template_part('footer', $params);
    }
}

if ( ! function_exists('get_theme_uri'))
{
    function get_theme_uri($file_name = null, $theme_name = NULL)
    {
        $theme_name = ($theme_name == NULL) ? get_theme_name() : $theme_name;
        
        return is_null($file_name) ? base_url('assets/themes/'. $theme_name .'/') : base_url('assets/themes/'. $theme_name .'/'. $file_name) ;
    }
}