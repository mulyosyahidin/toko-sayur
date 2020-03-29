<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0"><?php echo $customer->name; ?></h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><?php echo anchor('admin/customers', 'Pelanggan'); ?></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $customer->name; ?></li>
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
        <div class="col-md-5">
          <div class="card-wrapper">
            <div class="card">
              <div class="card-header">
                <h3 class="mb-0">Data Pelanggan</h3>
                <?php if ($flash) : ?>
                <span class="float-right text-success font-weight-bold" style="margin-top: -30px;"><?php echo $flash; ?></span>
                <?php endif; ?>
              </div>
              <div class="card-body p-0">
                <table class="table align-items-center table-flush table-hover">
                    <tr>
                        <td>Nama</td>
                        <td><b><?php echo $customer->name; ?></b></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><b><?php echo $customer->email; ?></b></td>
                    </tr>
                    <tr>
                        <td>No. HP</td>
                        <td><b><?php echo $customer->phone_number; ?></b></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><div style="white-space: initial;"><b><?php echo $customer->address; ?></b></div></td>
                    </tr>
                    <tr>
                        <td>Terdaftar pada</td>
                        <td><b><?php echo get_formatted_date($customer->register_date); ?></b></td>
                    </tr>
                </table>
              </div>
              <div class="card-footer">
                <a href="#" data-id="<?php echo $customer->id; ?>" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-trash"></i></a>
              </div>
              
            </div>
            
          </div>

        </div>
        <div class="col-md-7">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="mb-0">Riwayat Order</h3>
                </div>
                <div class="card-body <?php echo (count($orders) > 0) ? 'p-0' : ''; ?>">
                    <?php if ( count($orders) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nomor</th>
                                    <th scope="col">Jumlah Harga</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($orders as $order) : ?>
                                <tr>
                                    <th scope="col">
                                        <?php echo $order->id; ?>
                                    </th>
                                    <td>
                                        <?php echo anchor('admin/orders/view/'. $order->id, '#'. $order->order_number); ?>
                                    </td>
                                    <td>
                                        Rp <?php echo format_rupiah($order->total_price); ?>
                                    </td>
                                    <td><?php echo get_order_status($order->order_status, '#'. $order->payment_method); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else : ?>
                    <div class="alert alert-info">Belum ada data pembayarn.</div>
                    <?php endif; ?>
                </div>
            </div>


            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="mb-0">Riwayat Pembayaran</h3>
                </div>
                <div class="card-body <?php echo (count($payments) > 0) ? 'p-0' : ''; ?>">
                    <?php if ( count($payments) > 0) : ?>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Order</th>
                                    <th scope="col">Jumlah</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($payments as $payment) : ?>
                                <tr>
                                    <th scope="col">
                                        <?php echo $payment->id; ?>
                                    </th>
                                    <td>
                                        <?php echo anchor('admin/paymeny/view/'. $payment->id, $payment->order_number); ?>
                                    </td>
                                    <td>
                                        Rp <?php echo format_rupiah($payment->payment_price); ?>
                                    </td>
                                    <td><?php echo get_payment_status($payment->payment_status); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else : ?>
                    <div class="alert alert-info">Belum ada data order.</div>
                    <?php endif; ?>
                </div>
            </div>
              
             
        </div> <!-- col -->
      </div>

      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-modal-dialog-centered modal-" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-default">Hapus Pelanggan?</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <form action="#" id="deleteCustomer" method="POST">
        
            <input type="hidden" name="id" value="" class="deleteID">

          <div class="modal-body">
              <p class="deleteText">Yakin ingin pelanggan ini? Semua data seperti data profil, order dan pembayaran juga akan dihapus.</p>
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
    $(document).ready(function() {
    $(document).on('click', '.btnDelete', function() {
      var id  = $(this).data('id');

      $('.deleteID').val(id);
      $('#deleteModal').modal('show');
    });

    $('#deleteCustomer').submit(function(e) {
      e.preventDefault();

      var id = $('.deleteID').val();
      var btn = $('.btn-delete');

      btn.html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');

      $.ajax({
        method: 'POST',
        url: '<?php echo site_url('admin/customers/api/delete'); ?>',
        data: {
            id: id
        },
        success: function (res) {
          if (res.code == 204) {
            btn.html('<i class="fa fa-check"></i> Terhapus!');

            setTimeout(() => {
                $('.deleteText').html('Data berhasil dihapus');
            }, 1000);
            setTimeout(() => {
                $('.deleteText').html('<i class="fa fa-spin fa-spinner"></i> Mengalihkan...');
            }, 2500);
            setTimeout(() => {
                window.location = '<?php echo site_url('admin/customers'); ?>';
            }, 4000);
          }
        }
      })
    });
});
</script>