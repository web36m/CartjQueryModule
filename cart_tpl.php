<!DOCTYPE html>
<html>
	<head>
		<title>Cart Plugin Demo - Cart</title>
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
	<?php include 'ajax_tpl.php'; ?>
</div>
	</body>
</html>