<?php if (!isset($view)) die(); ?>
<h1><a href="index.php">Cart Plugin Demo</a></h1>
<h2>Cart</h2>
<?php if ($view->cart) { ?>
<table class="carts">
<?php foreach($view->cart as $items) { ?>
	<tr>
		<td><a class="photo" href="/product/<?php echo $items['id']; ?>"><img src="<?php echo $items['image']; ?>" alt="" /></a></td>
		<td class="price">Цена: <strong><?php echo $items['price']; ?></strong> р.</td>
		<td class="count">Количество: <input name="<?php echo $items['id']; ?>" type="text" value="<?php echo $items['count']; ?>" /></td>
		<td class="price">Сумма: <strong><?php echo $items['summ']; ?></strong> р.</td>
		<td class="delete"><input name="<?php echo $items['id']; ?>" type="button" value="Удалить" /></td>
	</tr>
<?php } ?>
</table>
<ul class="cartaction">
	<li><a class="toorder" href="javascript:void(0);">Оформить заказ</a></li>
	<li><a class="cartclear" href="javascript:void(0);">Очистить корзину</a></li>
</ul>
<div class="cartinfo">
	<p>Количество: <strong><?php echo (int)$view->topcart['count']; ?></strong> шт.</p>
	<p>На сумму: <strong><?php echo (int)$view->topcart['summ']; ?></strong> р.</p>
</div>
<?php } else { ?>
<p>Ваша корзина пуста.</p>
<?php } ?>