<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Konfirmasi Pembayaran</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><?php echo anchor('customer', 'Home'); ?></li>
                        <li class="breadcrumb-item active"><?php echo anchor('customer/payments', 'Pembayaran'); ?></li>
                        <li class="breadcrumb-item active">Konfirmasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="card-heading">Data Pembayaran</h5>
                    </div>
                    <?php echo form_open_multipart('customer/payments/do_confirm'); ?>
                    <div class="card-body">
                        <?php if ($flash) : ?>
                        <div class="alert alert-info"><?php echo $flash; ?></div>
                        <?php endif; ?>

                        <div class="form-group">
                            <label class="form-control-label" for="orders">Order:</label>
                            <?php if ( count($orders) > 0) : ?>
                            <select name="order_id" class="form-control" id="orders">
                                <?php foreach ($orders as $order) : ?>
                                    <option value="<?php echo $order->id; ?>" <?php echo set_select('order_id', $order->id, ($order_id == $order->id) ? TRUE : FALSE); ?>>#<?php echo $order->order_number; ?> (Rp <?php echo format_rupiah($order->total_price); ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                                <div class="text-danger font-weight-bold">Belum ada data order.</div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="bank_name" class="form-control-label">Nama bank:</label>
                                    <input type="text" name="bank_name" value="<?php echo set_value('bank_name'); ?>" class="form-control" id="bank_name" required>
                                    <?php echo form_error('bank_name'); ?>
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="form-group">
                                    <label for="bank_number" class="form-control-label">No. Rekening:</label>
                                    <input type="text" name="bank_number" value="<?php echo set_value('bank_number'); ?>" class="form-control" id="bank_number" required>
                                    <?php echo form_error('bank_number'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="price" class="form-control-label">Jumlah Transfer:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="text" name="transfer" value="<?php echo set_value('transfer'); ?>" class="form-control" id="price" required>
                                        <?php echo form_error('transfer'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="an" class="form-control-label">Atas nama:</label>
                                    <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control" id="an" required>
                                    <?php echo form_error('name'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-control-label" for="to">Transfer ke</label>
                            <?php if ( count($banks) > 0) : ?>
                            <select name="bank" class="form-control" id="orders">
                                <?php foreach ($banks as $bank => $data) : ?>
                                    <option value="<?php echo $bank; ?>"<?php echo set_select('bank', $bank); ?>><?php echo $data->bank; ?> a.n <?php echo $data->name; ?> (<?php echo $data->number; ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                                <div class="text-danger font-weight-bold">Belum ada data bank.</div>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="pic" class="form-control-label">Bukti pembayaran:</label>
                            <input type="file" name="picture" class="form-control" required>
                            <?php echo form_error('picture'); ?>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <input type="submit" value="Konfirmasi" class="btn btn-primary">
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-info">
                    <div class="card card-header">
                        <h5 class="card-heading">Pembayaran saya</h5>
                    </div>
                    <div class="card-body p-0">
                      <?php if ( count($payments) > 0) : ?>
                        <table class="table table-condensed table-striped">
                          <?php foreach ($payments as $payment) : ?>
                            <tr>
                                <td>#</td>
                                <td>
                                    <?php echo anchor('customer/payments/view/'. $payment->id, 'Order #'. $payment->order_number); ?>
                                </td>
                                <td>
                                  <?php if ($payment->payment_status == 1) : ?>
                                    <span class="badge badge-warning text-white">Menunggu konfirmasi</span>
                                  <?php elseif ($payment->payment_status == 2) : ?>
                                    <span class="badge badge-success text-white">Dikonfirmasi</span>
                                  <?php elseif ($payment->payment_status == 3) : ?>
                                    <span class="badge badge-danger text-white">Gagal mengonfirmasi</span>
                                  <?php endif; ?>
                                </td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      <?php else : ?>
                        <div class="m-3 alert alert-info">Belum ada data pembayaran.</div>
                      <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>