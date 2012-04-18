<?php

class Cart {
	
	public $data;
	
	public function __construct() {
		ob_end_clean();
		if (!isset($_SESSION))
			session_start();
		$this->data = require 'data.php';
	}

	public function indexAction() {
		$view = (object)array(
			'topcart' => $this->getTopCart(),
			'cart' => $this->getCart(),
		);
		include 'cart_tpl.php';
	}

	public function addAction() {
		if (!isset($_SESSION['cart']))
			$_SESSION['cart'] = array();
		if (isset($_SESSION['cart']) && !isset($_SESSION['cart'][(int)$_POST['id']]))
			$_SESSION['cart'][(int)$_POST['id']] = 1;
		elseif (isset($_SESSION['cart']) && isset($_SESSION['cart'][(int)$_POST['id']]))
			$_SESSION['cart'][(int)$_POST['id']] = (int)$_SESSION['cart'][(int)$_POST['id']] + 1;
		$result = $this->getTopCart();
		$result['message'] = 'Товар добавлен в корзину';
		echo json_encode($result);
	}
	
	public function countAction() {
		$id = (int)$_POST['id'];
		$count = (int)$_POST['count'];
		if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id]) && $count>0)
			$_SESSION['cart'][$id] = $count;
		$this->ajaxIndex();
	}

	public function clearAction() {
		if (isset($_SESSION['cart']))
			unset($_SESSION['cart']);
		$this->ajaxIndex();
	}

	public function delAction() {
		$id = (int)$_POST['id'];
		if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$id]))
			unset($_SESSION['cart'][$id]);
		$this->ajaxIndex();
	}

	public function getAction() {
		echo json_encode($this->getTopCart());
	}
	
	private function ajaxIndex() {
		$view = (object)array(
			'topcart' => $this->getTopCart(),
			'cart' => $this->getCart(),
		);
		include 'ajax_tpl.php';
	}

	private function getTopCart() {
		$return = array(
			'count' => 0,
			'summ' => 0,
		);
		if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
			foreach(array_keys($_SESSION['cart']) as $key) {
				if (isset($this->data[$key])) {
					$price = $this->data[$key]['price'];
					$return = array(
						'count' => $return['count']+$_SESSION['cart'][$key],
						'summ' => $return['summ']+(($price) ? $price : 0)*$_SESSION['cart'][$key],
					);
				}
			}
		}
		return $return;
	}
	
	private function getCart() {
		$return = array();
		if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
			foreach(array_keys($_SESSION['cart']) as $key) {
				if (isset($this->data[$key])) {
					$product = $this->data[$key];
					$product['id'] = $key;
					$product['count'] = $_SESSION['cart'][$key];
					$product['summ'] = (int)$_SESSION['cart'][$key] * $product['price'];
					$return[] = $product;
				}
			}
		}
		return $return;
	}
	
	private function count() {
		return (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) ? count($_SESSION['cart']) : 0;
	}
}

$cart = new Cart;
$action = preg_replace('/[^a-z]/i', '', isset($_GET['action']) ? $_GET['action'] : 'index').'Action';
if (method_exists($cart, $action))
	$cart->$action();
else
	header("HTTP/1.1 404 Not Found");