<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contacts extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model('contact_model', 'contact');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $params['title'] = 'Kelola Kontak Pengunjung';

        $this->load->view('header', $params);
        $this->load->view('contacts/contacts');
        $this->load->View('footer');
    }

    public function view($id = 0)
    {
        if ( $this->contact->is_contact_exist($id))
        {
            $data = $this->contact->contact_data($id);

            $params['title'] = 'Kontak '. $data->name;

            $contact['contact'] = $data;
            $contact['flash'] = $this->session->flashdata('contact_flash');

            $this->contact->set_status($id, 2);

            $this->load->view('header', $params);
            $this->load->view('contacts/view', $contact);
            $this->load->View('footer');
        }
        else
        {
            show_404();
        }
    }

    public function reply()
    {
        $id = $this->input->post('id');
        $sender = $this->input->post('email');
        $name = $this->input->post('name');
        $send_to = $this->input->post('to');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');

        $this->load->library('email');

        $this->email->from($sender, $name);
        $this->email->to($send_to);

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
        $this->email->print_debugger(array('headers'));
    }

    public function api($action = '')
    {
        switch ($action)
        {
            case 'contacts' :
                $contacts['data'] = $this->contact->get_all_contacts();

                $response = $contacts;
            break;
            case 'delete' :
                $id = $this->input->post('id');

                $this->customer->delete_customer($id);

                $response = array('code' => 204);
            break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
            ->set_output($response);
    }
}