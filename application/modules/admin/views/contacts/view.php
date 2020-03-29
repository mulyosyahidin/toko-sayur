<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Kontak #<?php echo $contact->id; ?></h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><?php echo anchor('admin/contacts', 'Kontak'); ?></li>
                  <li class="breadcrumb-item active" aria-current="page">#<?php echo $contact->id; ?> <?php echo $contact->name; ?></li>
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
                <h3 class="mb-0">Data Kontak</h3>
                <?php if ($flash) : ?>
                <span class="float-right text-success font-weight-bold" style="margin-top: -30px;"><?php echo $flash; ?></span>
                <?php endif; ?>
              </div>
              <div class="card-body p-0">
                <table class="table align-items-center table-flush table-hover">
                    <tr>
                        <td>Nama</td>
                        <td><b><?php echo $contact->name; ?></b></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><b><?php echo $contact->email; ?></b></td>
                    </tr>
                    <tr>
                        <td>Subjek</td>
                        <td><b><?php echo $contact->subject; ?></b></td>
                    </tr>
                    <tr>
                        <td>Pesan</td>
                        <td><div style="white-space: initial;"><b><?php echo $contact->message; ?></b></div></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td><b><?php echo get_formatted_date($contact->contact_date); ?></b></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><b><?php echo get_contact_status($contact->status); ?></b></td>
                    </tr>
                </table>
              </div>
              <div class="card-footer">
                <a href="#" data-id="<?php echo $contact->id; ?>" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-trash"></i></a>
              </div>
              
            </div>
            
          </div>

        </div>
        <div class="col-md-7">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="mb-0">Balas Pesan</h3>
                </div>
                <form action="<?php echo site_url('admin/contacts/reply'); ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $contact->id; ?>">

                <div class="card-body">
                   <div class="form-group">
                       <label class="form-control-label" for="email">Email saya:</label>
                       <input type="email" name="email" value="<?php echo set_value('email', get_settings('store_email')); ?>" class="form-control" id="email" required>
                       <?php echo form_error('email'); ?>
                   </div>
                   <div class="form-group">
                       <label class="form-control-label" for="name">Nama pengirim:</label>
                       <input type="text" name="name" value="<?php echo set_value('name', get_store_name()); ?>" class="form-control" id="name" required>
                       <?php echo form_error('name'); ?>
                   </div>
                   <div class="form-group">
                       <label class="form-control-label" for="to">Kirim ke:</label>
                       <input type="email" name="to" value="<?php echo set_value('to', $contact->email); ?>" class="form-control" id="to" required>
                       <?php echo form_error('to'); ?>
                   </div>
                   <div class="form-group">
                       <label class="form-control-label" for="subject">Subject pesan:</label>
                       <input type="text" name="subject" value="<?php echo set_value('subject', '[Re: '. $contact->subject .']'); ?>" class="form-control" id="subject" required>
                       <?php echo form_error('subject'); ?>
                   </div>
                   <div class="form-group">
                       <label class="form-control-label" for="msg">Isi pesan:</label>
                       <textarea name="message" class="form-control" id="mesg" required><?php echo set_value('message'); ?></textarea>
                       <?php echo form_error('message'); ?>
                   </div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="Kirim Balasan" class="btn btn-primary">
                </div>
                </form>
            </div>
             
        </div> <!-- col -->
      </div>

      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
  <div class="modal-dialog modal-modal-dialog-centered modal-" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h6 class="modal-title" id="modal-title-default">Hapus Kontak?</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
          <form action="#" id="deleteContact" method="POST">
        
            <input type="hidden" name="id" value="" class="deleteID">

          <div class="modal-body">
              <p class="deleteText">Yakin ingin menghapus? Tindakan ini tidak dapat dibatalkan.</p>
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

    $('#deleteContact').submit(function(e) {
      e.preventDefault();

      var id = $('.deleteID').val();
      var btn = $('.btn-delete');

      btn.html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');

      $.ajax({
        method: 'POST',
        url: '<?php echo site_url('admin/contacts/api/delete'); ?>',
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
                window.location = '<?php echo site_url('admin/contacts'); ?>';
            }, 4000);
          }
        }
      })
    });
});
</script>