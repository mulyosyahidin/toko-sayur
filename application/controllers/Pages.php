<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->library('form_validation');
        $this->load->model(array(
            'contact_model' => 'contact',
            'review_model' => 'review'
        ));
    }

    public function about()
    {
        $params['reviews'] = $this->review->get_all_reviews();

        get_header(get_store_name());
        get_template_part('pages/about', $params);
        get_footer();
    }

    public function contact()
    {
        $profile = user_data();

        $data['user'] = $profile;
        $data['flash'] = $this->session->flashdata('contact_flash');

        get_header(get_store_name());
        get_template_part('pages/contact', $data);
        get_footer();
    }

    public function send_message()
    {
        $this->form_validation->set_error_delimiters('<div class="text-danger font-weight-bold"><small>', '</small></div>');

        $this->form_validation->set_rules('name', 'Nama lengkap', 'required');
        $this->form_validation->set_rules('subject', 'Subjek pesan', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|min_length[10]');
        $this->form_validation->set_rules('message', 'Pesan', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->contact();
        }
        else
        {
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            $data = array(
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message,
                'contact_date' => date('Y-m-d H:i:s')
            );

            $this->contact->register_contact($data);
            $this->session->set_flashdata('contact_flash', 'Pesan berhasil dikirimkan. Kami akan membalas dalam waktu 2x24 jam');

            redirect('pages/contact');
        }
    }
}