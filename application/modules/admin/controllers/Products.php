<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        verify_session('admin');

        $this->load->model(array(
            'product_model' => 'product',
            'order_model' => 'order'
        ));
        $this->load->library('form_validation');
    }

    public function index()
    {
        $params['title'] = 'Kelola Produk '. get_store_name();

        $config['base_url'] = site_url('admin/products/index');
        $config['total_rows'] = $this->product->count_all_products();
        $config['per_page'] = 16;
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
 
        $products['products'] = $this->product->get_all_products($config['per_page'], $page);
        $products['pagination'] = $this->pagination->create_links();

        $this->load->view('header', $params);
        $this->load->view('products/products', $products);
        $this->load->view('footer');
    }

    public function search()
    {
        $query = $this->input->get('search_query');
        $query = html_escape($query);

        $params['title'] = 'Cari "'. $query .'"';
        $params['query'] = $query;

        $config['base_url'] = site_url('admin/products/search');
        $config['total_rows'] = $this->product->count_all_products();
        $config['per_page'] = 16;
        $config['uri_segment'] = 4;
        $choice = $config['total_rows'] / $config['per_page'];
        $config['num_links'] = floor($choice);
 
        $config['first_link']       = '«';
        $config['last_link']        = '»';
        $config['next_link']        = '›';
        $config['prev_link']        = '‹';
        $config['reuse_query_string'] = TRUE;
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
 
        $products['products'] = $this->product->search_products($query, $config['per_page'], $page);
        $products['pagination'] = $this->pagination->create_links();
        $products['count'] = $this->product->count_search($query);

        $this->load->view('header', $params);
        $this->load->view('products/search', $products);
        $this->load->view('footer');
    }

    public function add_new_product()
    {
        $params['title'] = 'Tambah Produk Baru';

        $product['flash'] = $this->session->flashdata('add_new_product_flash');
        $product['categories'] = $this->product->get_all_categories();

        $this->load->view('header', $params);
        $this->load->view('products/add_new_product', $product);
        $this->load->view('footer');
    }

    public function add_product()
    {
        $this->form_validation->set_error_delimiters('<div class="form-error text-danger font-weight-bold">', '</div>');

        $this->form_validation->set_rules('name', 'Nama produk', 'trim|required|min_length[4]|max_length[255]');
        $this->form_validation->set_rules('price', 'Harga produk', 'trim|required');
        $this->form_validation->set_rules('stock', 'Stok barang', 'required|numeric');
        $this->form_validation->set_rules('unit', 'Satuan barang', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi produk', 'max_length[512]');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->add_new_product();
        }
        else
        {
            $name = $this->input->post('name');
            $category_id = $this->input->post('category_id');
            $price = $this->input->post('price');
            $stock = $this->input->post('stock');
            $unit = $this->input->post('unit');
            $desc = $this->input->post('desc');
            $date = date('Y-m-d H:i:s');

            $config['upload_path'] = './assets/uploads/products/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ( isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0')
            {
                if ( ! $this->upload->do_upload('picture'))
                {
                    $error = array('error' => $this->upload->display_errors());

                    show_error($error);
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $file_name = $upload_data['file_name'];
                }
            }

            $category_data = $this->product->category_data($category_id);
            $category_name = $category_data->name;

            $sku = create_product_sku($name, $category_name, $price, $stock);

            $product['category_id'] = $category_id;
            $product['sku'] = $sku;
            $product['name'] = $name;
            $product['description'] = $desc;
            $product['price'] = $price;
            $product['stock'] = $stock;
            $product['product_unit'] = $unit;
            $product['picture_name'] = $file_name;
            $product['add_date'] = $date;

            $this->product->add_new_product($product);
            $this->session->set_flashdata('add_new_product_flash', 'Produk baru berhasil ditambahkan!');

            redirect('admin/products/add_new_product');
        }
    }

    public function edit($id = 0)
    {
        if ( $this->product->is_product_exist($id))
        {
            $data = $this->product->product_data($id);

            $params['title'] = 'Edit '. $data->name;

            $product['flash'] = $this->session->flashdata('edit_product_flash');
            $product['product'] = $data;
            $product['categories'] = $this->product->get_all_categories();

            $this->load->view('header', $params);
            $this->load->view('products/edit_product', $product);
            $this->load->view('footer');
        }
        else
        {
            show_404();
        }
    }

    public function edit_product()
    {
        $this->form_validation->set_error_delimiters('<div class="form-error text-danger font-weight-bold">', '</div>');

        $this->form_validation->set_rules('name', 'Nama produk', 'trim|required|min_length[4]|max_length[255]');
        $this->form_validation->set_rules('price', 'Harga produk', 'trim|required');
        $this->form_validation->set_rules('stock', 'Stok barang', 'required|numeric');
        $this->form_validation->set_rules('unit', 'Satuan barang', 'required');
        $this->form_validation->set_rules('description', 'Deskripsi produk', 'max_length[512]');
        
        if ($this->form_validation->run() == FALSE)
        {
            $id = $this->input->post('id');
            $this->edit($id);
        }
        else
        {
            $id = $this->input->post('id');
            $data = $this->product->product_data($id);
            $current_picture = $data->picture_name;

            $name = $this->input->post('name');
            $category_id = $this->input->post('category_id');
            $price = $this->input->post('price');
            $discount = $this->input->post('price_discount');
            $stock = $this->input->post('stock');
            $unit = $this->input->post('unit');
            $desc = $this->input->post('desc');
            $available = $this->input->post('is_available');
            $date = date('Y-m-d H:i:s');

            $config['upload_path'] = './assets/uploads/products/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ( isset($_FILES['picture']) && @$_FILES['picture']['error'] == '0')
            {
                if ( $this->upload->do_upload('picture'))
                {
                    $upload_data = $this->upload->data();
                    $new_file_name = $upload_data['file_name'];

                    if ( $this->product->is_product_have_image($id))
                    {
                        $file = './assets/uploads/products/'. $current_picture;

                        $file_name = $new_file_name;
                        unlink($file);
                    }
                    else
                    {
                        $file_name = $new_file_name;
                    }
                }
                else
                {
                    show_error($this->upload->display_errors());
                }
            }
            else
            {
                $file_name = ($this->product->is_product_have_image($id)) ? $current_picture : NULL;
            }

            $product['category_id'] = $category_id;
            $product['name'] = $name;
            $product['description'] = $desc;
            $product['price'] = $price;
            $product['current_discount'] = $discount;
            $product['stock'] = $stock;
            $product['product_unit'] = $unit;
            $product['picture_name'] = $file_name;
            $product['is_available'] = $available;

            $this->product->edit_product($id, $product);
            $this->session->set_flashdata('edit_product_flash', 'Produk berhasil diperbarui!');

            redirect('admin/products/view/'. $id);
        }
    }

    public function product_api()
    {
        $action = $this->input->get('action');

        switch ($action)
        {
            case 'delete_image' :
                $id = $this->input->post('id');
                $data = $this->product->product_data($id);
                $picture_name = $data->picture_name;
                $file = './assets/uploads/products/'. $picture_name;

                if ( file_exists($file) && is_readable($file) && unlink($file))
                {
                    $this->product->delete_product_image($id);
                    $response = array('code' => 204, 'message' => 'Gambar berhasil dihapus');
                }
                else
                {
                    $response = array('code' => 200, 'message' => 'Terjadi kesalahan sata menghapus gambar');
                }
            break;
            case 'delete_product' :
                $id = $this->input->post('id');
                $data = $this->product->product_data($id);
                $picture = $data->picture_name;
                $file = './assets/uploads/products/'. $picture;

                $this->product->delete_product($id);

                if ( file_exists($file) && is_readable($file))
                {
                    unlink($file);
                }

                $response = array('code' => 204);
            break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
            ->set_output($response);
    }

    public function view($id = 0)
    {
        if ( $this->product->is_product_exist($id))
        {
            $data = $this->product->product_data($id);

            $params['title'] = $data->name .' | SKU '. $data->sku;

            $product['product'] = $data;
            $product['flash'] = $this->session->flashdata('product_flash');
            $product['orders'] = $this->order->product_ordered($id);

            $this->load->view('header', $params);
            $this->load->view('products/view', $product);
            $this->load->view('footer');
        }
        else
        {
            show_404();
        }
    }

    public function category()
    {
        $params['title'] = 'Kelola Kategori Produk';

        $categories['categories'] = $this->product->get_all_categories();

        $this->load->view('header', $params);
        $this->load->view('products/category', $categories);
        $this->load->view('footer');
    }

    public function category_api()
    {
        $action = $this->input->get('action');

        switch ($action) {
            case 'list' :
                $categories['data'] = $this->product->get_all_categories();
                $response = $categories;
            break;
            case 'view_data' :
                $id = $this->input->get('id');

                $data['data'] = $this->product->category_data($id);
                $response = $data;
            break;
            case 'add_category' :
                $name = $this->input->post('name');

                $this->product->add_category($name);
                $categories['data'] = $this->product->get_all_categories();
                $response = $categories;
            break;
            case 'delete_category' :
                $id = $this->input->post('id');

                $this->product->delete_category($id);
                $response = array('code' => 204, 'message' => 'Kategori berhasil dihapus!');
            break;
            case 'edit_category' :
                $id = $this->input->post('id');
                $name = $this->input->post('name');

                $this->product->edit_category($id, $name);
                $response = array('code' => 201, 'message' => 'Kategori berhasil diperbarui');
            break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
            ->set_output($response);
    }

    public function coupons()
    {
        $params['title'] = 'Kelola Kupon Belanja';

        $this->load->view('header', $params);
        $this->load->view('products/coupons');
        $this->load->view('footer');
    }

    public function _get_coupon_list()
    {
        $coupons = $this->product->get_all_coupons();
        $n = 0;

        foreach ($coupons as $coupon)
        {
            $coupons[$n]->credit = 'Rp '. format_rupiah($coupon->credit);
            $coupons[$n]->start_date = get_formatted_date($coupon->start_date);
            $coupons[$n]->is_active = ($coupon->is_active == 1) ? ((strtotime($coupon->expired_date) < time()) ? 'Sudah kadaluarsa' : 'Masih berlaku') : 'Tidak aktif';
            $coupons[$n]->expired_date = get_formatted_date($coupon->expired_date);

            $n++;
        }

        return $coupons;
    }

    public function coupon_api()
    {
        $action = $this->input->get('action');

        switch ($action) {
            case 'coupon_list' :
                $coupons['data'] = $this->_get_coupon_list();

                $response = $coupons;
            break;
            case 'view_data' :
                $id = $this->input->get('id');

                $data['data'] = $this->product->coupon_data($id);
                $response = $data;
            break;
            case 'add_coupon' :
                $name = $this->input->post('name');
                $code = $this->input->post('code');
                $credit = $this->input->post('credit');
                $start = $this->input->post('start_date');
                $end = $this->input->post('expired_date');

                $coupon = array(
                    'name' => $name,
                    'code' => $code,
                    'credit' => $credit,
                    'start_date' => date('Y-m-d', strtotime($start)),
                    'expired_date' => date('Y-m-d', strtotime($end))
                );

                $this->product->add_coupon($coupon);
                $coupons['data'] = $this->_get_coupon_list();
            
                $response = $coupons;
            break;
            case 'delete_coupon' :
                $id = $this->input->post('id');

                $this->product->delete_coupon($id);
                $response = array('code' => 204, 'message' => 'Kupon berhasil dihapus!');
            break;
            case 'edit_coupon' :
                $id = $this->input->post('id');
                $name = $this->input->post('name');
                $code = $this->input->post('code');
                $credit = $this->input->post('credit');
                $start = $this->input->post('start_date');
                $end = $this->input->post('expired_date');
                $active = $this->input->post('is_active');

                $coupon = array(
                    'name' => $name,
                    'code' => $code,
                    'credit' => $credit,
                    'start_date' => date('Y-m-d', strtotime($start)),
                    'expired_date' => date('Y-m-d', strtotime($end)),
                    'is_active' => $active
                );

                $this->product->edit_coupon($id, $coupon);
                $response = array('code' => 201, 'message' => 'Kupon berhasil diperbarui');
            break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
            ->set_output($response);
    }
}