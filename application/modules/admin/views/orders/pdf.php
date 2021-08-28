<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="utf-8">
	<title>Order #<?php echo $data->order_number; ?></title>

	<style>
		.clearfix:after {
			content: "";
			display: table.items;
			clear: both;
		}

		a {
			color: #5D6975;
			text-decoration: underline;
		}

		body {
			position: relative;
			width: 21cm;
			height: 29.7cm;
			margin: 0 auto;
			color: #001028;
			background: #FFFFFF;
			font-family: Arial, sans-serif;
			font-size: 12px;
			font-family: Arial;
		}

		header {
			padding: 10px 0;
			margin-bottom: 30px;
		}

		#logo {
			text-align: center;
			margin-bottom: 10px;
		}

		#logo img {
			width: 90px;
		}

		h1 {
			border-top: 1px solid #5D6975;
			border-bottom: 1px solid #5D6975;
			color: #5D6975;
			font-size: 2.4em;
			line-height: 1.4em;
			font-weight: normal;
			text-align: center;
			margin: 0 0 20px 0;
			background: url(dimension.png);
		}

		#project {
			float: left;
		}

		#project span {
			color: #5D6975;
			text-align: right;
			width: 52px;
			margin-right: 10px;
			display: inline-block;
			font-size: 0.8em;
		}

		#company {
			float: right;
			text-align: right;
		}

		#project div,
		#company div {
			white-space: nowrap;
		}

		table.items {
			width: 100%;
			border-collapse: collapse;
			border-spacing: 0;
			margin-bottom: 20px;
		}

		table.items tr:nth-child(2n-1) td {
			background: #F5F5F5;
		}

		table.items th,
		table.items td {
			text-align: center;
		}

		table.items th {
			padding: 5px 20px;
			color: #5D6975;
			border-bottom: 1px solid #C1CED9;
			white-space: nowrap;
			font-weight: normal;
		}

		table.items .service,
		table.items .desc {
			text-align: left;
		}

		table.items td {
			padding: 20px;
			text-align: right;
		}

		table.items td.service,
		table.items td.desc {
			vertical-align: top;
		}

		table.items td.unit,
		table.items td.qty,
		table.items td.total {
			font-size: 1.2em;
		}

		table.items td.grand {
			border-top: 1px solid #5D6975;
			;
		}

		#notices .notice {
			color: #5D6975;
			font-size: 1.2em;
		}

		footer {
			color: #5D6975;
			width: 100%;
			height: 30px;
			position: absolute;
			bottom: 0;
			border-top: 1px solid #C1CED9;
			padding: 8px 0;
			text-align: center;
		}

		.data {
			width: 96%;
			margin-bottom: 30px;
		}
	</style>
</head>

<body>
	<header class="clearfix">
		<h1>Order #<?php echo $data->order_number; ?></h1>
		<table class="data">
			<tr>
				<td>
					<div id="project" class="clearfix">
						<div><?php echo get_store_name(); ?></div>
						<div><?php echo get_settings('store_address'); ?></div>
						<div><?php echo get_settings('store_phone_number'); ?></div>
						<div><a href="mailto:<?php echo get_settings('store_email'); ?>"><?php echo get_settings('store_email'); ?></a></div>
					</div>
				</td>
				<td style="float: right;">
					<div id="company" class="clearfix">
						<div><span>Nama</span> <?php echo $delivery_data->customer->name; ?></div>
						<div><span>Alamat</span> <?php echo $delivery_data->customer->address; ?></div>
						<div><span>Hp</span> <?php echo $delivery_data->customer->phone_number; ?></div>
					</div>
				</td>
			</tr>
		</table>


	</header>
	<main>
		<table class="items">
			<thead>
				<tr>
					<th class="service">Barang</th>
					<th>Harga</th>
					<th>Kuantitas</th>
					<th>Subtotal</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($items as $item) : ?>
					<tr>
						<td class="service"><?php echo $item->name; ?></td>
						<td class="unit">Rp <?php echo format_rupiah($item->order_price); ?></td>
						<td class="qty"><?php echo $item->order_qty; ?></td>
						<td class="total">Rp <?php echo format_rupiah($item->order_price * $item->order_qty); ?></td>
					</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="3" class="grand total">Total</td>
					<td class="grand total">Rp <?php echo format_rupiah($data->total_price); ?></td>
				</tr>
			</tbody>
		</table>
	</main>
	<footer>
		Invoice ini dicetak pada <?php echo get_formatted_date(date('Y-m-d H:i:s')); ?> <?php echo date('H:i'); ?> dan merupakan bukti transaksi yang sah.
	</footer>
</body>

</html>