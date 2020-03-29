<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0"><?php echo $product->name; ?></h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin/products'); ?>">Produk</a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $product->name; ?></li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-md-4">
          <div class="card-wrapper">
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0">Data Produk</h3>
                <?php if ($flash) : ?>
                <span class="float-right text-success font-weight-bold" style="margin-top: -30px">
                  <?php echo $flash; ?>
                </span>
                <?php endif; ?>
              </div>
              <div class="card-body p-0">
              <div>
                  <img alt="<?php echo $product->name; ?>" class="img img-fluid rounded" src="<?php echo base_url('assets/uploads/products/'. $product->picture_name); ?>">
              </div>

                <table class="table table-hover table-striped">
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td><b><?php echo $product->name; ?></b></td>
                    </tr>
                    <tr>
                        <td>SKU</td>
                        <td>:</td>
                        <td><b><?php echo $product->sku; ?></b></td>
                    </tr>
                    <tr>
                        <td>Harga</td>
                        <td>:</td>
                        <td><b>Rp <?php echo format_rupiah($product->price); ?></b></td>
                    </tr>
                    <tr>
                        <td>Diskon</td>
                        <td>:</td>
                        <td><b>Rp <?php echo format_rupiah($product->current_discount); ?> (<?php echo count_percent_discount($product->current_discount, $product->price, 2); ?> %)</b></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>:</td>
                        <td><b><?php echo anchor('admin/products?category_id='. $product->category_id, $product->category_name); ?></b></td>
                    </tr>
                    <tr>
                        <td>Stok / Satuan</td>
                        <td>:</td>
                        <td><b>
                            <?php echo ($product->stock > 0) ? $product->stock .' '. $product->product_unit : 'Stok habis'; ?>
                        </b></td>
                    </tr>
                    <tr>
                        <td>Deskripsi</td>
                        <td>:</td>
                        <td><b><?php echo $product->description; ?></b></td>
                    </tr>
                    <tr>
                        <td>Tersedia</td>
                        <td>:</td>
                        <td>
                          <?php echo ($product->is_available == 1) ? '<b class="text-success">Tersedia</b>' : '<b class="text-danger">Tidak</b>'; ?>
                        </td>
                    </tr>
                </table>
              </div>
              <div class="card-footer text-right">
                  <a href="<?php echo site_url('admin/products/edit/'. $product->id); ?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                  <a href="#" data-toggle="modal" data-target="#deleteModal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
              </div>
              
            </div>
            
          </div>

        </div>
        <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                  <h3 class="mb-0">Order</h3>
              </div>
              <div class="card-body p-0">
              <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Order</th>
                    <th scope="col">Customer</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($orders as $order) : ?>
                  <tr>
                    <th scope="col">
                      <?php echo $order->id; ?>
                    </th>
                    <td><?php echo anchor('admin/orders/view/'. $order->order_id, '#'. $order->order_number); ?></td>
                    <td>
                      <?php echo $order->name; ?>
                    </td>
                    <td><?php echo $order->order_qty; ?> <?php echo $order->unit; ?></td>
                    <td>Rp <?php echo format_rupiah($order->order_price); ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
              </div>
            </div>
        </div>
      </div>

      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-modal-dialog-centered modal-" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-default">Hapus Produk</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <form action="#" id="deleteProductForm" method="POST">
        
            <input type="hidden" name="id" value="<?php echo $product->id; ?>">

          <div class="modal-body">
              <p class="deleteText">Yakin ingin menghapus produk ini? Semua data yang terkait seperti data order juga akan dihapus. Tindakan ini tidak dapat dibatalkan.</p>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
              <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Batal</button>
          </div>
          </form>
      </div>
  </div>
</div>

<script>
    $('#deleteProductForm').submit(function(e) {
        e.preventDefault();

        var btn = $('.btn-delete');
        var data = $(this).serialize();

        btn.html('<i class="fa fa-spin fa-spinner"></i> Menghapus...').attr('disabled', true);

        $.ajax({
            method: 'POST',
            url: '<?php echo site_url('admin/products/product_api?action=delete_product'); ?>',
            data: data,
            success: function (res) {
                if (res.code == 204) {
                    setTimeout(function() {
                        btn.html('<i class="fa fa-check"></i> Terhapus!');
                        $('.deleteText').fadeOut(function() {
                            $(this).text('Produk berhasil dihapus')
                        }).fadeIn();
                    }, 2000);

                    setTimeout(function() {
                        $('.deleteText').fadeOut(function() {
                            $(this).text('Mengalihkan...')
                        }).fadeIn();
                    }, 4000);

                    setTimeout(function() {
                        window.location = '<?php echo site_url('admin/products'); ?>';
                    }, 6000);
                }
                else {
                    console.log('Terjadi kesalahan sata menghapus produk');
                }
            }
        })
    })
</script>