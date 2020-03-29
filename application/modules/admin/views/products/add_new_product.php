<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    <!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Tambah Produk</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin'); ?>"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item"><a href="<?php echo site_url('admin/products'); ?>">Produk</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Page content -->
    <div class="container-fluid mt--6">
      <?php echo form_open_multipart('admin/products/add_product'); ?>

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
                            <option value="<?php echo $category->id; ?>"<?php echo set_select('category_id', $category->id); ?>>› <?php echo $category->name; ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                      <?php echo form_error('category_id'); ?>
                  </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="name">Nama produk:</label>
                  <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control" id="name">
                  <?php echo form_error('name'); ?>
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="price">Harga:</label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Rp</span>
                    </div>
                    <input type="text" name="price" value="<?php echo set_value('price'); ?>" class="form-control" id="price">
                  </div>
                    <?php echo form_error('price'); ?>
                </div>

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="form-control-label" for="stock">Stok:</label>
                      <input type="text" name="stock" value="<?php echo set_value('stock'); ?>" class="form-control" id="stock">
                      <?php echo form_error('stock'); ?>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label class="form-control-label" for="unit">Satuan:</label>
                      <input type="text" name="unit" value="<?php echo set_value('unit'); ?>" class="form-control" id="unit">
                      <?php echo form_error('unit'); ?>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="form-control-label" for="desc">Deskripsi:</label>
                  <textarea name="description" class="form-control" id="desc"><?php echo set_value('description'); ?></textarea>
                  <?php echo form_error('description'); ?>
                </div>
              
              </div>
              
            </div>
            
          </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Foto</h3>
                </div>
                <div class="card-body">
                   <div class="form-group">
                     <label class="form-control-label" for="pic">Foto:</label>
                     <input type="file" name="picture" class="form-control" id="pic">
                     <small class="text-muted">Pilih foto PNG atau JPG dengan ukuran maksimal 2MB</small>
                   </div>
                </div>
                <div class="card-footer text-right">
                    <input type="submit" value="Tambah Produk Baru" class="btn btn-primary">
                </div>
            </div>
        </div>
      </div>

    </form>