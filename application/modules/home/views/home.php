<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Sell Made Easy</title>
	
	<!-- Bootstrap CSS CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4"
	 crossorigin="anonymous">
	<!-- Our Custom CSS -->
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url('assets/css/main.css'); ?>" />
	<!-- Fontawesome CSS CDN -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

	<!-- Font Awesome JS -->
	<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/solid.js" integrity="sha384-6FXzJ8R8IC4v/SKPI8oOcRrUkJU8uvFK6YJ4eDY11bJQz4lRw5/wGthflEOX8hjL" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.7.2/js/fontawesome.js" integrity="sha384-xl26xwG2NVtJDw2/96Lmg09++ZjrXPc89j0j7JHjLOdSwHDHPHiucUjfllW0Ywrq" crossorigin="anonymous"></script>
	
	<!-- Datatables CSS CDN -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	
	

</head>

<body>
	<div class="text-center">
		<img src="<?php echo base_url('assets/img/logo_novo_big.png'); ?>" class="img-fluid" alt="">
	</div>
	
    <!-- echo '<a href="#' . $key . '" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">' . $key. '</a>';
	echo '<ul class="collapse list-unstyled" id="' . $key . '">';
 -->
	<div class="wrapper">
		<!-- Sidebar Holder -->
		<?php 
			$base_url = base_url();
		?>
		<nav id="sidebar">
			<div class="sidebar-header">
				<h3><a href="<?php echo base_url(); ?>">Products</a></h3>
			</div>

			<ul class="list-unstyled components">
				<li>
					<?php
						$this->load->module('category');
						
						$marks = array();
						foreach ($categorias->result() as $row)
							{  
								if($row->parent_cat_id==0) {
									$marks += array( $row->name => array());
								} else {
									foreach ($marks as $key => $value){

										$parent_cat_title=$this->category->_get_cat_title($row->parent_cat_id); 
										if($key == $parent_cat_title){

											$marks[$key][] = $row->name . "#" . $row->id ; 

										}

									}

								}
							}

							foreach ($marks as $key => $value){
								 echo '<a href="#" data-toggle="" aria-expanded="false" >' . $key. '</a>';
								 echo '<ul class="list-unstyled" id="' . $key . '">';
								 foreach ($value as $something){
									$pieces = explode("#", $something);
									echo '<li><a href="' . $base_url . 'items/display/' . $pieces[1] . '">' . $pieces[0]. '</a></li>';
								 }
								 echo '</ul>';
							}
										
					?>

					</li>
				
		</nav>

		<!-- Page Content Holder -->
		<div id="content">

			<nav class="navbar navbar-expand-lg navbar-light bg-light">
				<div class="container-fluid">

					<button type="button" id="sidebarCollapse" class="navbar-btn">
						<span></span>
						<span></span>
						<span></span>
					</button>
					<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<i class="fas fa-align-justify"></i>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item">
								<a class="nav-link" href="#">
									<?php if($this->session->userdata('email') != null) { echo 'Welcome ', $this->session->userdata('email'); } ?>
								</a>
							</li>
							
								<?php 
									$base_url = base_url();
									if($this->session->userdata('email') == null){
										
										echo <<< EOD
										<li class="nav-item active">
											<a class="nav-link" href="{$base_url}users/login_form ">Login</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="{$base_url}users/sign_form" >Sign in</a>
										</li>
									
EOD;
									
									} else if($this->session->userdata('email') == "plnascimento@hotmail.com") {
										
										echo <<< EOT
											<li class="nav-item">
												<a class="nav-link" href="{$base_url}users/destroy_session" >Logout</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{$base_url}category/category_form" >Categories</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" href="{$base_url}items/items_form" >Items</a>
											</li>
										
EOT;
									} else {

										echo <<< EOT
													<li class="nav-item">
														<a class="nav-link" href="{$base_url}users/destroy_session" >Logout</a>
													</li>
												
										
EOT;

							}
							?>
						</ul>
					</div>
				</div>
			</nav>

			<?php
				if(isset($module) && isset($view_file))
				{
					$this->load->view($module.'/'.$view_file);
				}
			?>
			<div style="padding: 75px 10px;">
			</div>
			<section class="container content-section">
				<h2 class="section-header">CART</h2>
				<div class="cart-row">
					<span class="cart-item cart-header cart-column">ITEM</span>
					<span class="cart-price cart-header cart-column">PRICE</span>
					<span class="cart-quantity cart-header cart-column">QUANTITY</span>
				</div>
				<div class="cart-items">
				</div>
				<div class="cart-total">
					<strong class="cart-total-title">Total</strong>
					<span class="cart-total-price">$0</span>
				</div>
				<button class="btn btn-primary btn-purchase" type="button">PURCHASE</button>
			</section>
		</div>
	</div>
	

	<!-- jQuery CDN - Slim version (=without AJAX) -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" 
	crossorigin="anonymous"></script>
	<!-- Popper.JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
	 crossorigin="anonymous"></script>
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
	 crossorigin="anonymous"></script>
	<!-- Datatables JS CDN -->
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
	<!-- tinymce -->
	<script src="https://cloud.tinymce.com/5/tinymce.min.js"></script>
  	<script>tinymce.init({selector:'textarea', encoding : 'raw', mobile: { theme: 'mobile' }});</script>
	  	 		

	<script type="text/javascript">
		$(document).ready(function () {
			$('#sidebarCollapse').on('click', function () {
				$('#sidebar').toggleClass('active');
				$(this).toggleClass('active');
			});

			$("#showHide").click(function () {
				if ($(".password").attr("type") == "password") {
					$(".password").attr("type", "text");
					$("#showHide span").text("Ocultar");
				} else {
					$(".password").attr("type", "password");
					$("#showHide span").text("Mostrar");

				}
			});

			$('#category_table').DataTable({
    			responsive: true
			} );

			$('.custom-file-input').on('change', function() {
    			let fileName = $(this).val().split('\\').pop();
    			$(this).siblings('.custom-file-label').addClass('selected').html(fileName);
			});
			
			
	
			// copy paste	
			
			var BASE_URL = "<?php echo base_url()?>";

			if (document.readyState == 'loading') {
				document.addEventListener('DOMContentLoaded', ready);
			} else {
				ready();
			}

			var cond;

			$( document ).ajaxStop(function() {
  				if(cond){

					var shopItem = document.getElementsByClassName("shop-item")[0];
					var userId = shopItem.getElementsByTagName('input')[0].value;
				
					
					addItemToCart(userId);
				
					cond = false;
				}
			});


			var userId = '<?php echo $this->session->userdata("id"); ?>';

			function ready() {

				//var shopItem = document.getElementsByClassName("shop-item")[0]
				var userId = '<?php echo $this->session->userdata("id"); ?>';
				
				if (typeof userId !== 'undefined') {	
					addItemToCart(userId);
				}


				var removeCartItemButtons = document.getElementsByClassName('btn-danger');
				for (var i = 0; i < removeCartItemButtons.length; i++) {
					var button = removeCartItemButtons[i];
					button.addEventListener('click', removeCartItem);
				}

				var quantityInputs = document.getElementsByClassName('cart-quantity-input');
				for (var i = 0; i < quantityInputs.length; i++) {
					var input = quantityInputs[i];
					input.addEventListener('change', quantityChanged);
				}

				var addToCartButtons = document.getElementsByClassName('shop-item-button');
				for (var i = 0; i < addToCartButtons.length; i++) {
					var button = addToCartButtons[i];
					button.addEventListener('click', addToCartClicked);
				}

				document.getElementsByClassName('btn-purchase')[0].addEventListener('click', purchaseClicked)
			}
			
			//paypal

			function purchaseClicked() {
				
				window.location = "<?php echo base_url();?>paypal/sendPurchase";

			}


			async function removeCartItem(event) {
				var buttonClicked = event.target
				var cartRow	=	buttonClicked.parentElement.parentElement
				
				var id = cartRow.getElementsByTagName('input')[0].value
				var userId = cartRow.getElementsByTagName('input')[1].value

				deleteData(id)
				
				cond = true;
				
			}

			function deleteData(id){

				$.ajax({
					url: BASE_URL + 'cart/delete_from_cart',
					type: 'POST',
					data: {
						'id': id
					},
					success: function (data) {
						alert("Item deleted");
					},
					error: function () {
						alert("error");
					}
				});

			}

			function quantityChanged(event) {
				var input = event.target
				var cart_row = input.parentElement.parentElement
				var id = cart_row.getElementsByTagName('input')[0].value
				var item_id = cart_row.getElementsByClassName('item_id')[0].value

				qty = input.value

				
				$.ajax({
					url: BASE_URL + 'cart/search_qty',
					type: 'POST',
					data: {
						'item_id': item_id
						
					},
					dataType: 'json',
					success: function (data) {
						var item_qty =data[0].qty
						
						console.log(item_qty)
						console.log(qty)

						if (+qty <= +item_qty && +qty > 0 && !isNaN(qty)){
							updateQty(id, qty)
						} else {
							addItemToCart(userId)
							alert("we dont have " + qty + " in stock")		
						}

					},
					error: function () {
						alert("error");
					}
				});

				
				

				updateCartTotal()
			}	

			function updateQty(id, qty){
					
				$.ajax({
						url: BASE_URL + 'cart/update_qty',
						type: 'POST',
						data: {
							'qty': qty,
							'id': id
							
						},
						success: function (data) {
							alert(data);
						},
						error: function () {
							alert("error");
						}
					}); 
			}


			async function addToCartClicked(event) {
				var button = event.target
				var shopItem = button.parentElement.parentElement

				var title = shopItem.getElementsByClassName('shop-item-title')[0].innerText
				var price = shopItem.getElementsByClassName('shop-item-price')[0].innerText
				var imageSrc = shopItem.getElementsByClassName('shop-item-image')[0].src
				var user_id = shopItem.getElementsByTagName('input')[0].value
				var item_id = shopItem.getElementsByTagName('input')[1].value

				insertData(title, price, imageSrc, user_id, item_id)

				cond = true;
				
			}

			function insertData(title, price, imageSrc, user_id, item_id){
				
				$.ajax({
					url: BASE_URL + 'cart/add_cart',
					type: 'POST',
					data: {
						'title': title,
						'price': price,
						'image': imageSrc,
						'user_id': user_id,
						'item_id': item_id
						
					},
					success: function (data) {
						alert(data);
					},
					error: function () {
						alert("error");
					}
				});
			}

			function addItemToCart(user_id) {

				var cartItems = document.getElementsByClassName('cart-items')[0]
				cartItems.innerHTML = "";

				$.ajax({
					url: BASE_URL + 'cart/get_cart',
					type: 'POST',
					data: {
						'user_id': user_id
					},
					dataType: 'json',
					success: function (data) {
						var i;

						for (i=0; i<data.length; i++){

							var cartRow = document.createElement('div')
							cartRow.classList.add('cart-row')

							


							var cartRowContents = `
								<div class="cart-item cart-column">
									<img class="cart-item-image" src="${data[i].image}" width="100" height="100">
									<span class="cart-item-title">${data[i].title}</span>
								</div>
								<input type="hidden" name="id" value="${data[i].id}">
								<input type="hidden" name="user_id" value="${data[i].user_id}">
								<input type="hidden" class="item_id" name="item_id" value="${data[i].item_id}">
								<span class="cart-price cart-column">${data[i].price}</span>
								<div class="cart-quantity cart-column">
									<input class="cart-quantity-input" type="number" value="${data[i].qty}">
									<button class="btn btn-danger" type="button">REMOVE</button>
								</div>`;

							cartRow.innerHTML = cartRowContents
							cartItems.append(cartRow)

							cartRow.getElementsByClassName('btn-danger')[0].addEventListener('click', removeCartItem)
							cartRow.getElementsByClassName('cart-quantity-input')[0].addEventListener('change', quantityChanged) 
						}

						updateCartTotal() 
						
					},
					error: function () {
						alert("error");
					}
					
					
				});					

			}

			function updateCartTotal() {
				var cartItemContainer = document.getElementsByClassName('cart-items')[0]
				var cartRows = cartItemContainer.getElementsByClassName('cart-row')
				var total = 0
				for (var i = 0; i < cartRows.length; i++) {
					var cartRow = cartRows[i]
					var priceElement = cartRow.getElementsByClassName('cart-price')[0]
					var quantityElement = cartRow.getElementsByClassName('cart-quantity-input')[0]
					var price = parseFloat(priceElement.innerText.replace('$', ''))
					var quantity = quantityElement.value
					total = total + (price * quantity)
				}
				total = Math.round(total * 100) / 100
				document.getElementsByClassName('cart-total-price')[0].innerText = '€' + total
	
			}
									
		});

	</script>
</body>

</html>
