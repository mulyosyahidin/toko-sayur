<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model(array(
            'order_model' => 'order',
            'review_model' => 'review',
            'review_model' => 'review'
        ));
    }

    public function index()
    {
        $params['title'] = 'Kelola Pembayaran';

        $config['base_url'] = site_url('admin/reviews/index');
        $config['total_rows'] = $this->review->count_all_reviews();
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
 
        $config['first_link']       = '«';
        $config['last_link']        = '»';
        $config['next_link']        = '›';
        $config['prev_link']        = '‹';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';

        $this->load->library('pagination', $config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
 
        $reviews['reviews'] = $this->review->get_all_reviews($config['per_page'], $page);
        $reviews['pagination'] = $this->pagination->create_links();

        $this->load->view('header', $params);
        $this->load->view('reviews/reviews', $reviews);
        $this->load->view('footer');
    }

    public function view($id = 0)
    {
        if ( $this->review->is_review_exist($id))
        {
            $data = $this->review->review_data($id);

            $params['title'] = 'Review Order #'. $data->order_number;

            $reviews['review'] = $data;
            $reviews['flash'] = $this->session->flashdata('review_flash');

            $this->load->view('header', $params);
            $this->load->view('reviews/view', $reviews);
            $this->load->view('footer');
        }
        else
        {
            show_404();
        }
    }

    public function delete($id)
    {
        if ( $this->review->is_review_exist($id))
        {
            $this->review->delete($id);

            $this->session->set_flashdata('review_flash', 'Review berhasil dihapus');
            redirect('admin/reviews');
        }
        else
        {
            show_404();
        }
    }
}