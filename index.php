<!DOCTYPE html>
<html>
	<head>
		<title>Cart Plugin Demo - Catalog</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
		<script type="text/javascript" src="js/cart.js"></script>
		<script type="text/javascript">
			$(function(){
				$.Cart.init({
					topcart : '.cart',
					urladd : 'cart.php?action=add',
					urlget : 'cart.php?action=get',
					urlcart : 'cart.php',
					urlcount : 'cart.php?action=count',
					urlclear : 'cart.php?action=clear',
					urldel : 'cart.php?action=del',
					counta : '.carts .count input',
					del : '.carts .delete input'
				});
			});
		</script>
		<link rel="stylesheet" type="text/css" media="all" href="css/cart.css" />
	</head>
	<body>
<div class="lmenu">
	<div class="cart">
		<p><a href="javascript:void(0);">Моя корзина</a></p>
		<p class="prod">Товаров: <span><font>0</font> шт</span></p>
		<p class="summ">На сумму: <span><font>0</font> р.</span></p>
	</div>
</div>
<div class="content">
	<h1><a href="index.php">Cart Plugin Demo</a></h1>
	<h2>Catalog</h2>
	<div class="catalog">
		<ul>
<?php
$data = require './data.php';
foreach($data as $key=>$item) {
?>
			<li>
				<a href="#"><img src="<?php echo $item['image']; ?>" alt="" /></a>
				<p><strong>Цена: <?php echo $item['price']; ?> руб.<strong></p>
				<input class="tocart" name="<?php echo $key; ?>" type="button" value="В корзину" />
			</li>
<?php } ?>
		</ul>
	</div>
</div>
	</body>
</html>