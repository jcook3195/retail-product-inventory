<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	// Set form vals if search was submitted
	$product_val = '';
	$upc_val = '';
	$cat_val = '';
	if(isset($_POST['product']) && !empty($_POST['product'])) {		
		$product_val = $_POST['product'];
	}
	if(isset($_POST['upc']) && !empty($_POST['upc'])) {		
		$upc_val = $_POST['upc'];
	}
	if(isset($_POST['cat']) && !empty($_POST['cat'])) {
		$cat_val = $_POST['cat'];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Retail Product Lookup</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/style.css">
</head>
<body>
	<header class="bg-info space-bottom pad-verticle white-text">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1>Retail Product Lookup</h1>
				</div>
			</div>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 space-bottom">
				<h3>Product Search</h3>
				<form action="<?php echo base_url(); ?>Welcome/search" method="post" id="searchForm" class="space-bottom">
					<div class="form-group">
						<label for="product">Product Name</label>
						<input type="text" class="form-control" id="product" name="product" value="<?php echo $product_val; ?>">
					</div>
					<div class="form-group">
						<label for="upc">UPC</label>
						<input type="text" class="form-control" id="upc" name="upc" value="<?php echo $upc_val; ?>">
					</div>
					<div class="form-group">
						<label for="category">Category</label>
						<input type="text" class="form-control" id="category" name="cat" value="<?php echo $cat_val; ?>">
					</div>
					<div class="btn-row">
						<button type="submit" class="btn btn-info">Proceed</button>
						<a class="btn btn-danger" id="resetFormBtn">Clear Search</a>
					</div>
				</form>
				<div class="searched-for space-bottom">
					<?php
						if((isset($_POST['product']) && !empty($_POST['product'])) OR (isset($_POST['upc']) && !empty($_POST['upc'])) OR (isset($_POST['cat']) && !empty($_POST['cat'])))  {
							echo '<h4>Previous Search:</h4>';
						}					

						if(isset($_POST['product']) && !empty($_POST['product'])) {
							echo '<p><strong><em>Product Name:</em></strong> '.$product_val.'</p>';
						}

						if(isset($_POST['upc']) && !empty($_POST['upc'])) {
							echo '<p><strong><em>UPC:</em></strong> '.$upc_val.'</p>';
						}

						if(isset($_POST['cat']) && !empty($_POST['cat'])) {
							echo '<p><strong><em>Category:</em></strong> '.$cat_val.'</p>';
						}

					?>
				</div>
				<div class="cats-list space-bottom">
					<h4>All Categories:</h4>				
					<ul>
						<?php 

							foreach($categories as $category) {
								echo '<li>'.$category->name.'</li>';
							}

						?>
					</ul>
				</div>
			</div>
			<div class="col-lg-6">
				<h3 style="text-align: center;">Inventory Listing</h3>
				<div id="results-list">
					<?php
						if((isset($_POST['product']) && !empty($_POST['product'])) OR (isset($_POST['upc']) && !empty($_POST['upc'])) OR (isset($_POST['cat']) && !empty($_POST['cat'])))  {	
							if(isset($products)) {
								foreach($inventory as $inv) {
									foreach($products as $prod) {
										foreach($stores as $store) {
											if(($prod->id == $inv->product) && $store->id == $inv->store) {
												?>
													<div class="card space-bottom text-white bg-dark" style="width: 16rem; margin: 0 auto 12px auto;">
														<div class="card-body">
															<h5 class="card-title"><?php echo "Store ".$store->number; ?></h5>
															<p class="small"><?php echo $store->street_addr; ?><br>
															<?php echo $store->city; ?>, <?php echo $store->state; ?><br>
															<?php echo $store->zip; ?></p>
															<hr style="border-top: 1px solid #fff;">
															<h4 class="card-subtitle mb-2"><?php echo $prod->name; ?><br>
															<span class="small text-info"><?php echo $prod->description; ?></span><br>
															<span class="small">UPC: <?php echo $prod->upc; ?></span><br>
															<span class="small"><em><?php echo $prod->category; ?></em></h4>															
															&nbsp;
															<?php 
																if($inv->in_stock == 1) {
																	echo "<p><span class='text-success'>In Stock</span><br>Aisle ".$inv->aisle_num."</p>";
																} elseif($inv->in_stock == 0) {
																	echo "<p class='text-danger'>Out of Stock</p>";
																}
															?>
														</div>
													</div>
												<?php
											}
										}									
									}
								}
							} else {
								echo "<p style='text-align: center;' class='text-danger'>".$msg."</p>";
							}						
							
						} else {
							echo "<p style='text-align: center;'>Fill out search form to look for products.</p>";
						}
					?>
				</div>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="<?php echo base_url(); ?>assets/scripts.js"></script>
</body>
</html>