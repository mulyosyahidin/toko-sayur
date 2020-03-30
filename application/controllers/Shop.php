<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->library('cart');
        $this->load->model(array(
            'product_model' => 'product',
            'customer_model' => 'customer'
        ));
    }

    public function product($id = 0, $sku = '')
    {
        if ($id == 0 || empty($sku))
        {
            show_error('Akses tidak sah!');
        }
        else
        {
            if ($this->product->is_product_exist($id, $sku))
            {
                $data = $this->product->product_data($id);

                $product['product'] = $data;
                $product['related_products'] = $this->product->related_products($data->id, $data->category_id);

                get_header($data->name .' | '. get_settings('store_tagline'));
                get_template_part('shop/view_single_product', $product);
                get_footer();
            }
            else
            {
                show_404();
            }
        }
    }

    public function cart()
    {
        $cart['carts'] = $this->cart->contents();
        $cart['total_cart'] = $this->cart->total();

        $ongkir = ($cart['total_cart'] >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');
        $cart['total_price'] = $cart['total_cart'] + $ongkir;

        get_header('Keranjang Belanja');
        get_template_part('shop/cart', $cart);
        get_footer();
    }
    
    public function checkout($action = '')
    {
        if ( ! is_login()) {
            $coupon = $this->input->post('coupon_code');
            $quantity = $this->input->post('quantity');

            $this->session->set_userdata('_temp_coupon', $coupon);
            $this->session->set_userdata('_temp_quantity', $quantity);

            verify_session('customer');
        }
        switch ($action)
        {
            default :
                $coupon = $this->input->post('coupon_code') ? $this->input->post('coupon_code') : $this->session->userdata('_temp_coupon');
                $quantity = $this->input->post('quantity') ? $this->input->post('quantity') : $this->session->userdata('_temp_quantity');

                if ($this->session->userdata('_temp_quantity') || $this->session->userdata('_temp_coupon'))
                {
                    $this->session->unset_userdata('_temp_coupon');
                    $this->session->unset_userdata('_temp_quantity');
                }

                $items = [];

                foreach ($quantity as $rowid => $qty)
                {
                    $items['rowid'] = $rowid;
                    $items['qty'] = $qty;
                }

                $this->cart->update($items);

                if ( empty($coupon)) 
                {
                    $discount = 0;
                    $disc = 'Tidak menggunkan kupon';
                }
                else
                {
                    if ($this->customer->is_coupon_exist($coupon))
                    {
                        if ($this->customer->is_coupon_active($coupon))
                        {
                            if ( $this->customer->is_coupon_expired($coupon))
                            {
                                $discount = 0;
                                $disc = 'Kupon kadaluarsa';
                            }
                            else
                            {
                                $coupon_id = $this->customer->get_coupon_id($coupon);
                                $this->session->set_userdata('coupon_id', $coupon_id);

                                $credit = $this->customer->get_coupon_credit($coupon);
                                $discount = $credit;
                                $disc = '<span class="badge badge-success">'. $coupon .'</span> Rp '. format_rupiah($credit);
                            }
                        }
                        else
                        {
                            $discount = 0;
                            $disc = 'Kupon sudah tidak aktif';
                        }
                    }
                    else
                    {
                        $discount = 0;
                        $disc = 'Kupon tidak terdaftar';
                    }
                }

                $items = [];

                foreach ($this->cart->contents() as $item)
                {
                    $items[$item['id']]['qty'] = $item['qty'];
                    $items[$item['id']]['price'] = $item['price'];
                }
                 
                $subtotal = $this->cart->total();
                $ongkir = (int) ($subtotal >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');

                $params['customer'] = $this->customer->data();
                $params['subtotal'] = $subtotal;
                $params['ongkir'] = ($ongkir > 0) ? 'Rp'. format_rupiah($ongkir) : 'Gratis';
                $params['total'] = $subtotal + $ongkir - $discount;
                $params['discount'] = $disc;

                $this->session->set_userdata('order_quantity', $items);
                $this->session->set_userdata('total_price', $params['total']);

                get_header('Checkout');
                get_template_part('shop/checkout', $params);
                get_footer();
            break;
            case 'order' :
                $quantity = $this->session->userdata('order_quantity');

                $user_id = get_current_user_id();
                $coupon_id = $this->session->userdata('coupon_id');
                $order_number = $this->_create_order_number($quantity, $user_id, $coupon_id);
                $order_date = date('Y-m-d H:i:s');
                $total_price = $this->session->userdata('total_price');
                $total_items = count($quantity);
                $payment = $this->input->post('payment');

                $name = $this->input->post('name');
                $phone_number = $this->input->post('phone_number');
                $address = $this->input->post('address');
                $note = $this->input->post('note');

                $delivery_data = array(
                    'customer' => array(
                        'name' => $name,
                        'phone_number' => $phone_number,
                        'address' => $address
                    ),
                    'note' => $note
                );

                $delivery_data = json_encode($delivery_data);

                $order = array(
                    'user_id' => $user_id,
                    'coupon_id' => $coupon_id,
                    'order_number' => $order_number,
                    'order_status' => 1,
                    'order_date' => $order_date,
                    'total_price' => $total_price,
                    'total_items' => $total_items,
                    'payment_method' => $payment,
                    'delivery_data' => $delivery_data
                );

                $order = $this->product->create_order($order);

                $n = 0;
                foreach ($quantity as $id => $data)
                {
                    $items[$n]['order_id'] = $order;
                    $items[$n]['product_id'] = $id;
                    $items[$n]['order_qty'] = $data['qty'];
                    $items[$n]['order_price'] = $data['price'];

                    $n++;
                }

                $this->product->create_order_items($items);

                $this->cart->destroy();
                $this->session->unset_userdata('order_quantity');
                $this->session->unset_userdata('total_price');
                $this->session->unset_userdata('coupon_id');

                $this->session->set_flashdata('order_flash', 'Order berhasil ditambahkan');

                redirect('customer/orders/view/'. $order);
            break;
        }

    }

    public function cart_api()
    {
        $action = $this->input->get('action');

        switch ($action)
        {
            case 'add_item' :
                $id = $this->input->post('id');
                $qty = $this->input->post('qty');
                $sku = $this->input->post('sku');
                $name = $this->input->post('name');
                $price = $this->input->post('price');
                
                $item = array(
                    'id' => $id,
                    'qty' => $qty,
                    'price' => $price,
                    'name' => $name
                );
                $this->cart->insert($item);
                $total_item = count($this->cart->contents());

                $response = array('code' => 200, 'message' => 'Item dimasukkan dalam keranjang', 'total_item' => $total_item);
            break;
            case 'display_cart' :
                $carts = [];

                foreach ($this->cart->contents() as $items)
                {
                    $carts[$items['rowid']]['id'] = $items['id'];
                    $carts[$items['rowid']]['name'] = $items['name'];
                    $carts[$items['rowid']]['qty'] = $items['qty'];
                    $carts[$items['rowid']]['price'] = $items['price'];
                    $carts[$items['rowid']]['subtotal'] = $items['subtotal'];
                }

                $response = array('code' => 200, 'carts' => $carts);
            break;
            case 'cart_info' :
                $total_price = $this->cart->total();
                $total_item = count($this->cart->contents());

                $data['total_price']= $total_price;
                $data['total_item'] = $total_item;

                $response['data'] = $data;
            break;
            case 'remove_item' :
                $rowid = $this->input->post('rowid');

                $this->cart->remove($rowid);
                
                $total_price = $this->cart->total();
                $ongkir = (int) ($total_price >= get_settings('min_shop_to_free_shipping_cost')) ? 0 : get_settings('shipping_cost');
                $data['code'] = 204;
                $data['message'] = 'Item dihapus dari keranjang';
                $data['total']['subtotal'] = 'Rp '. format_rupiah($total_price);
                $data['total']['ongkir'] = ($ongkir > 0) ? 'Rp '. format_rupiah($ongkir) : 'Gratis';
                $data['total']['total'] = 'Rp '. format_rupiah($total_price + $ongkir);

                $response = $data;
            break;
        }

        $response = json_encode($response);
        $this->output->set_content_type('application/json')
            ->set_output($response);
    }

    public function _create_order_number($quantity, $user_id, $coupon_id)
    {
        $this->load->helper('string');

        $alpha = strtoupper(random_string('alpha', 3));
        $num = random_string('numeric', 3);
        $count_qty = count($quantity);


        $number = $alpha . date('j') . date('n') . date('y') . $count_qty . $user_id . $coupon_id . $num;
        //Random 3 letter . Date . Month . Year . Quantity . User ID . Coupon Used . Numeric

        return $number;
    }
}