<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;/*
$order_items = array();
foreach ($order->get_items() as $item_id => $item) {

		$product = $item->get_product();
		$order_items[] = array(
			'id' => $item->get_product_id(),
			'name' => $item->get_name(),
			'price' => $product->get_price(),
			'quantity' => $item->get_quantity(),
			'total' => $item->get_total(),
		);
	
}
print_r($order);
*/


?>
<h1><?php the_field('thankyou', 10); ?></h1>
<style>.woocommerce{width: 100%;}

	figure.wp-block-image>img{
		max-width: 250px;
		margin: 0 auto;
	}
</style>
