<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Edit Produk</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin/products'); ?>">Produk</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin/products/view/'. $product->id); ?>"><?php echo $product->name; ?></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
      <?php echo form_open_multipart('admin/products/edit_product'); ?>
      <input type="hidden" name="id" value="<?php echo $product->id; ?>">

      <div class="row">
        <div class="col-md-8">
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
        
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="form-control-label" for="pakcage">Kategori:</label>
                      <select name="category_id" class="form-control" id="package">
                        <option>Pilih kategori</option>
                        <?php if ( count($categories) > 0) : ?>
                          <?php foreach ($categories as $category) : ?>
                            <option value="<?php echo $category->id; ?>"<?php echo set_select('category_id', $category->id, ($product->category_id == $category->id) ? TRUE : FALSE); ?>>› <?php echo $category->name; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <?php echo form_error('category_id'); ?>
                  </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="name">Nama produk:</label>
                  <input type="text" name="name" value="<?php echo set_value('name', $product->name); ?>" class="form-control" id="name">
                  <?php echo form_error('name'); ?>
                </div>

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="form-control-label" for="price">Harga:</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp</span>
                        </div>
                        <input type="text" name="price" value="<?php echo set_value('price', $product->price); ?>" class="form-control" id="price">
                      </div>
                        <?php echo form_error('price'); ?>
                    </div>
                  </div>
                  <div class="col-6">
                  <div class="form-group">
                  <label class="form-control-label" for="price_d">Diskon:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="price_discount" value="<?php echo set_value('price_discount', $product->current_discount); ?>" class="form-control" id="price_d">
                  </div>
                    <?php echo form_error('price_iscount'); ?>
                </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="form-control-label" for="stock">Stok:</label>
                      <input type="text" name="stock" value="<?php echo set_value('stock', $product->stock); ?>" class="form-control" id="stock">
                      <?php echo form_error('stock'); ?>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label class="form-control-label" for="unit">Satuan:</label>
                      <input type="text" name="unit" value="<?php echo set_value('unit', $product->product_unit); ?>" class="form-control" id="unit">
                      <?php echo form_error('unit'); ?>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="desc">Deskripsi:</label>
                  <textarea name="description" class="form-control" id="desc"><?php echo set_value('description', $product->description); ?></textarea>
                  <?php echo form_error('description'); ?>
                </div>

                <div class="form-group">
                  <label for="av" class="form-control-label">
                    <input type="checkbox" id="av" name="is_available" value="1" <?php echo set_checkbox('is_available', $product->is_available, ($product->is_available == 1) ? TRUE : FALSE); ?>> Apakah produk ini tersedia?
                  </label>
                </div>
              
              </div>
              
            </div>
            
          </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                            <h3 class="mb-0">Foto</h3>
                        </div>
                        <?php if ($product->picture_name) : ?>
                        <div class="col-8">
                            <ul class="nav nav-pills mb-3 float-right" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link p-1 active" id="pills-current-tab" data-toggle="pill" href="#pills-current" role="tab" aria-controls="pills-home" aria-selected="true">Current</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-1" id="pills-edit-tab" data-toggle="pill" href="#pills-edit" role="tab" aria-controls="pills-profile" aria-selected="false">Ganti</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link p-1" id="pills-delete-tab" data-toggle="pill" href="#pills-delete" role="tab" aria-controls="pills-contact" aria-selected="false">Hapus</a>
                                </li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body">
                    <?php if ($product->picture_name != NULL) : ?>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-current" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="text-center">
                                <img alt="<?php echo $product->name; ?>" src="<?php echo base_url('assets/uploads/products/'. $product->picture_name); ?>" class="img img-fluid rounded">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-edit" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="form-group">
                                <label class="form-control-label" for="pic">Foto:</label>
                                <input type="file" name="picture" class="form-control" id="pic">
                                <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
                                <small class="newUploadText">Unggah file baru untuk mengganti foto saat ini.</small>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-delete" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <p class="deleteText">Klik link dibawah untuk menghapus foto. Tindakan ini tidak dapat dibatalkan.</p>
                            <div class="text-right">
                                <a href="#" class="deletePictureBtn btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                    <?php else : ?>
                    <div class="form-group">
                        <label class="form-control-label" for="pic">Foto:</label>
                        <input type="file" name="picture" class="form-control" id="pic">
                        <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-right">
                    <input type="submit" value="Simpan" class="btn btn-primary">
                </div>
            </div>
        </div>
      </div>

    </form>
    
    <script>
        $('.deletePictureBtn').click(function(e) {
            e.preventDefault();

            $(this).html('<i class="fa fa-spin fa-spinner"></i> Menghapus...');

            $.ajax({
                method: 'POST',
                url: '<?php echo site_url('admin/products/product_api?action=delete_image'); ?>',
                data: {
                    id: <?php echo $product->id; ?>
                },
                context: this,
                success: function(res) {
                    if (res.code == 204) {
                        $('.deleteText').text('Gambar berhasil dihapus. Produk ini akan menggunakan gambar default jika tidak ada gambar baru yang diunggah');
                        $(this).html('<i class="fa fa-check"></i> Terhapus!');

                        setTimeout(function() {
                            $('.newUploadText').text('Pilih gambar baru untuk mengganti gambar yang dihapus');
                            $('#pills-delete, #pills-delete-tab, #pills-current, #pills-current-tab').hide('fade');
                            $('#pills-edit').tab('show');
                            $('#pills-edit-tab').addClass('active').text('Upload baru');
                        }, 3000);
                    }
                    else {
                        console.log('Terdapat kesalahan');
                    }
                }
            })
        });
    </script>