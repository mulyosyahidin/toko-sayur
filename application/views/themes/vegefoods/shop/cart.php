<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="hero-wrap hero-bread" style="background-image: url('<?php echo get_theme_uri('images/bg_1.jpg'); ?>');">
    <div class="container">
      <div class="row no-gutters slider-text align-items-center justify-content-center">
        <div class="col-md-9 ftco-animate text-center">
            <p class="breadcrumbs"><span class="mr-2"><?php echo anchor(base_url(), 'Home'); ?></span> <span>Keranjang Belanja</span></p>
          <h1 class="mb-0 bread">Keranjang Belanja Saya</h1>
        </div>
      </div>
    </div>
  </div>

  <section class="ftco-section ftco-Keranjang Belanja">
          <div class="container">
          <?php if ( count($carts) > 0) : ?>
            <form action="<?php echo site_url('shop/checkout'); ?>" method="POST">
              <div class="row">
              <div class="col-md-12 ftco-animate">
                  <div class="cart-list">
                      <table class="table">
                          <thead class="thead-primary">
                            <tr class="text-center">
                              <th>&nbsp;</th>
                              <th>&nbsp;</th>
                              <th>Produk</th>
                              <th>Harga</th>
                              <th>Kuantitas</th>
                              <th>Sub Total</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php foreach ($carts as $item) : ?>
                            <tr class="text-center cart-<?php echo $item['rowid']; ?>">
                              <td class="product-remove"><a href="#" class="remove-item" data-rowid="<?php echo $item['rowid']; ?>"><span class="ion-ios-close"></span></a></td>
                              
                              <td class="image-prod"><div class="img img-fluid rounded" style="background-image:url(<?php echo get_product_image($item['id']); ?>);"></div></td>
                              
                              <td class="product-name">
                                  <h3><?php echo $item['name']; ?></h3>
                              </td>
                              
                              <td class="price">Rp <?php echo format_rupiah($item['price']); ?></td>
                              
                              <td class="quantity">
                                  <div class="input-group mb-3">
                                   <input type="text" name="quantity[<?php echo $item['rowid']; ?>]" class="quantity form-control input-number" value="<?php echo $item['qty']; ?>" min="1" max="100">
                                </div>
                            </td>
                              
                              <td class="total">Rp <?php echo format_rupiah($item['subtotal']); ?></td>
                            </tr><!-- END TR-->
                              <?php endforeach; ?>
                          </tbody>
                        </table>
                    </div>
              </div>
          </div>
          <div class="row justify-content-end">
              <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
                  <div class="cart-total mb-3">
                      <h3>Kode Kupon</h3>
                      <p>Punya kode kupon? Gunakan kupon kamu untuk mendapatkan potongan harga menarik</p>
                        
                <div class="form-group">
                    <label for="code">Kode:</label>
                  <input id="code" name="coupon_code" type="text" class="form-control text-left px-3" placeholder="">
                </div>
              
                  </div>
                  
              </div>
              
              <div class="col-lg-4 mt-5 cart-wrap ftco-animate">
                  <div class="cart-total mb-3">
                      <h3>Rincian Keranjang</h3>
                      <p class="d-flex">
                          <span>Subtotal</span>
                          <span class="n-subtotal font-weight-bold">Rp <?php echo format_rupiah($total_cart); ?></span>
                      </p>
                      <p class="d-flex">
                          <span>Biaya pengiriman</span>
                          <?php if ( $total_cart >= get_settings('min_shop_to_free_shipping_cost')) : ?>
                          <span class="n-ongkir font-weight-bold">Gratis</span>
                          <?php else : ?>
                            <span class="n-ongkir font-weight-bold">Rp <?php echo format_rupiah(get_settings('shipping_cost')); ?></span>
                          <?php endif; ?>
                      </p>
                      <hr>
                      <p class="d-flex total-price">
                          <span>Total</span>
                          <span class="n-total font-weight-bold">Rp <?php echo format_rupiah($total_price); ?></span>
                      </p>
                  </div>
                  <p><button type="submit" class="btn btn-primary py-3 px-4">Checkout</button></p>
              </div>
          </div>
          </form>
          <?php else : ?>
            <div class="row">
              <div class="col-md-12 ftco-animate">
                <div class="alert alert-info">Tidak ada barang dalam keranjang.<br><?php echo anchor('browse', 'Jelajahi produk kami'); ?> dan mulailah berbelanja!</div>
              </div>
            </div>
          <?php endif; ?>
          </div>
      </section>

<script>
  $('.remove-item').click(function(e) {
    e.preventDefault();

    var rowid = $(this).data('rowid');
    var tr = $('.cart-'+ rowid);

    $('.product-name', tr).html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');

    $.ajax({
      method: 'POST',
      url: '<?php echo site_url('shop/cart_api?action=remove_item'); ?>',
      data: { rowid: rowid },
      success: function (res) {
        if (res.code == 204) {
          tr.addClass('alert alert-danger');

          setTimeout(function(e) {
            tr.hide('fade');

            $('.n-subtotal').text(res.total.subtotal);
            $('.n-ongkir').text(res.total.ongkir);
            $('.n-total').text(res.total.total);
          }, 2000);
        }
      }
    })
  })
</script>