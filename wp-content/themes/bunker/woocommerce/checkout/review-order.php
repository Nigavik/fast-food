<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
//print_r(WC()->cart);
?>
<script>
	jQuery(document).ready(function($) {
		$('.order_review_top').on('click', function() {
			$(this).toggleClass('none-box ')
		})
	})
</script>
<div class="order_review_top">
	<span>Підсумок замовлення</span>
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
		<path id="XMLID_224_" d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394  l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393  C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z" />
	</svg>
</div>




<div class="product-box">
	<?php
	do_action('woocommerce_review_order_before_cart_contents');

	foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
		$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

		if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
	?>

			<div class="product-cart">
				<div class="product-content">
					<div class="product-img"><img src="<?php echo wp_get_attachment_url($_product->get_image_id(), 'full'); ?>" alt="<?= $_product->get_name(); ?>">
						<span class="count"><?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' ' . sprintf('%s', $cart_item['quantity']) . '', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
											?></span>
					</div>
					<div class="product-info">
						<h4><?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?></h4>
						<span class="subtotal_price"><?php echo $_product->get_price_html(); ?></span>
					</div>
				</div>
				<div class="price"><?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?></div>
				<?php if (count($cart_item['dop'])) {
				?>
					<div class="card-dop">
						<h4>Додатки до піци
						</h4>
						<div class="card-dop-box">
							<?php foreach ($cart_item['dop'] as $key => $dop) {
								$dop_post = get_post($key);
							?>
								<div class="dop-ingredient">
									<img src="<?php echo wp_get_attachment_image_src(get_post_thumbnail_id($dop_post->ID), 'full')[0];
												?>" alt="<?= $dop_post->post_title; ?>">
									<span class="name"><?= $dop; ?>x Додаток <?= $dop_post->post_title; ?></span>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php
				}
				?>
			</div>


	<?php
		}
	}

	do_action('woocommerce_review_order_after_cart_contents');
	?>
</div>
</div>
<?php do_action('woocommerce_before_checkout_form', $checkout); ?>
<div class="cart-subtotal">
	<span><?php esc_html_e('Subtotal', 'woocommerce'); ?></span>
	<span><?php wc_cart_totals_subtotal_html(); ?></span>
</div>

<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
	<div class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
		<span><?php wc_cart_totals_coupon_label($coupon); ?></span>
		<span><?php wc_cart_totals_coupon_html($coupon); ?></span>
	</div>
<?php endforeach; ?>

<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>



		<?php wc_cart_totals_shipping_html(); ?>

	
	
<?php endif; ?>

<?php foreach (WC()->cart->get_fees() as $fee) : ?>
	<div class="fee">
		<span><?php echo esc_html($fee->name); ?></span>
		<span><?php wc_cart_totals_fee_html($fee); ?></span>
		
	</div>
<?php endforeach; ?>

<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
	<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
		<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
		?>
			<div class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
				<span><?php echo esc_html($tax->label); ?></span>
				<span><?php echo wp_kses_post($tax->formatted_amount); ?></span>
			</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="tax-total">
			<span><?php echo esc_html(WC()->countries->tax_or_vat()); ?></span>
			<span><?php wc_cart_totals_taxes_total_html(); ?></span>
		</div>
	<?php endif; ?>
<?php endif; ?>

<?php do_action('woocommerce_review_order_before_order_total'); ?>

<div class="order-total">
	<span><?php esc_html_e('Total', 'woocommerce'); ?></span>
	<span><?php wc_cart_totals_order_total_html(); ?></span>
</div>

<?php do_action('woocommerce_review_order_after_order_total'); ?>