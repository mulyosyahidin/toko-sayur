<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Header -->
    <div class="header bg-primary pb-6">
      <div class="container-fluid">
        <div class="header-body">
          <div class="row align-items-center py-4">
            <div class="col-lg-6 col-7">
              <h6 class="h2 text-white d-inline-block mb-0">Dasbor</h6>
            </div>
            <div class="col-lg-6 col-5 text-right">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dasbor</li>
                </ol>
              </nav>
            </div>
          </div>
          <!-- Card stats -->
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Produk</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_products; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                        <i class="ni ni-shop"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                    <span class="text-nowrap">Jumlah produk yang tersedia</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pelanggan</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_customers; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
                        <i class="ni ni-circle-08"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                    <span class="text-nowrap">Pelanggan yang terdaftar</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pesanan</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_order; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                        <i class="ni ni-chart-bar-32"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                    <span class="text-nowrap">Jumlah pesanan diterima</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Pendapatan</h5>
                      <span class="h2 font-weight-bold mb-0">Rp <?php echo format_rupiah($total_income); ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                        <i class="ni ni-money-coins"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                    <span class="text-nowrap">Total pendapatan</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <div class="row">
        <div class="col-xl-8">
          <div class="card bg-default">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-light text-uppercase ls-1 mb-1">Ringkasan</h6>
                  <h5 class="h3 text-white mb-0">Penjualan</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h6 class="text-uppercase text-muted ls-1 mb-1">Ringkasan</h6>
                  <h5 class="h3 mb-0">Produk</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chart-bars" class="chart-canvas"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xl-4">
          <!-- Members list group card -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Title -->
              <h5 class="h3 mb-0">Pelanggan baru</h5>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <!-- List group -->
              <ul class="list-group list-group-flush list my--3">
              <?php foreach ($customers as $customer) : ?>
                <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <!-- Avatar -->
                      <a href="#" class="avatar rounded-circle">
                        <img alt="Image placeholder" src="<?php echo base_url('assets/uploads/users/'. $customer->profile_picture); ?>">
                      </a>
                    </div>
                    <div class="col ml--2">
                      <h4 class="mb-0">
                        <a href="#!"><?php echo $customer->name; ?></a>
                      </h4>
                      
                    </div>
                    <div class="col-auto">
                      <a href="<?php echo site_url('admin/customers/view/'. $customer->id); ?>" class="btn btn-sm btn-primary">Profil</a>
                    </div>
                  </div>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <!-- Checklist -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Title -->
              <h5 class="h3 mb-0">Order baru</h5>
            </div>
            <!-- Card body -->
            <div class="card-body p-0">
              <!-- List group -->
              <ul class="list-group list-group-flush" data-toggle="checklist">
                <?php foreach ($orders as $order) : ?>
                <li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                  <div class="checklist-item checklist-item-info">
                    <div class="checklist-info">
                      <h5 class="checklist-title mb-0"><?php echo anchor('admin/orders/view/'. $order->id, 'Order #'. $order->order_number); ?></h5>
                      <small><?php echo $order->total_items; ?></small> | <small>Rp <?php echo format_rupiah($order->total_price); ?></small>
                    </div>
                  </div>
                </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <!-- Progress track -->
          <div class="card">
            <!-- Card header -->
            <div class="card-header">
              <!-- Title -->
              <h5 class="h3 mb-0">Pembayaran menunggu konfirmasi</h5>
            </div>
            <!-- Card body -->
            <div class="card-body">
              <!-- List group -->
              <ul class="list-group list-group-flush list my--3">
              <?php foreach ($payments as $payment) : ?>
                <li class="list-group-item px-0">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <!-- Avatar -->
                      <a href="<?php echo site_url('admin/payments/users/'. $payment->user_id); ?>" class="avatar rounded-circle">
                        <img alt="Image placeholder" src="<?php echo base_url('assets/uploads/users/'. $payment->profile_picture); ?>">
                      </a>
                    </div>
                    <div class="col">
                      <h5>Order #<?php echo $payment->order_number; ?></h5>
                      <div>
                       Rp <?php echo format_rupiah($payment->payment_price); ?>
                      </div>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-xl-8">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Produk baru</h3>
                </div>
                <div class="col text-right">
                  <a href="<?php echo site_url('admin/products'); ?>" class="btn btn-sm btn-primary">Lihat semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product) : ?>
                  <tr>
                    <th scope="col">
                      <?php echo $product->id; ?>
                    </th>
                    <td>
                      <?php echo $product->name; ?>
                    </td>
                    <td>
                      Rp <?php echo format_rupiah($product->price); ?>
                    </td>
                    <td>
                      <?php echo $product->stock; ?> <?php echo $product->product_unit; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-xl-4">
          <div class="card">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Kategori produk</h3>
                </div>
                <div class="col text-right">
                  <a href="<?php echo site_url('admin/products/category'); ?>" class="btn btn-sm btn-primary">Lihat semua</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $category) : ?>
                  <tr>
                    <th scope="col">
                      <?php echo $category->id; ?>
                    </th>
                    <td>
                      <?php echo $category->name; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>