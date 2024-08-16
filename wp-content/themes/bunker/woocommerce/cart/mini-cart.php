<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */
defined('ABSPATH') || exit;
do_action('woocommerce_before_mini_cart'); ?>
<div class="overlay"> </div>
<div class="minicart">
	<div class="close">
		<svg height="24" width="24" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="Button_icon__4a1qk">
			<path d="M18 6L6 18" stroke="#909090" stroke-linecap="round" stroke-width="2"></path>
			<path d="M6 6L18 18" stroke="#909090" stroke-linecap="round" stroke-width="2"></path>
		</svg>
	</div>
	<?php if (!WC()->cart->is_empty()) : ?>
		<div class="minicart-top">
			<h2>Кошик <span>(<?php echo sprintf(WC()->cart->cart_contents_count); ?>)</span></h2> <a href="#" id="delete_all">Очистити все</a>
		</div>
		<div class="minicart-content">
			<?php
			do_action('woocommerce_before_mini_cart_contents');
			foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			?>
				<div class="card">
					<?php
					$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
					$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
					$text =  get_field('text', $product_id);
					if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
						/**
						 * This filter is documented in woocommerce/templates/cart/cart.php.
						 *
						 * @since 2.1.0
						 */
						$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
						$thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
						$product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
						$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
					}
					do_action('woocommerce_mini_cart_contents');
					?>
					<div class="card-box">
						<?php echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
						<div class="card-info">
							<h4><?= wp_kses_post($product_name);  ?></h4>
							<?php if ($text) {
								echo '<span>' . $text . '</span>';
							} ?>
							<span class="price"><?= $product_price ?></span>
						</div>
						<div class="add-box">
							<div class="count">
								<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
									<?php
									if ($_product->is_sold_individually()) {
										$min_quantity = 1;
										$max_quantity = 1;
									} else {
										$min_quantity = 0;
										$max_quantity = $_product->get_max_purchase_quantity();
									}
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $max_quantity,
											'min_value'    => $min_quantity,
											'product_name' => $product_name,
										),
										$_product,
										false
									);
									echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
									?>
								</td>
							</div>
						</div>
					</div>
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
													?>" alt="<?= $dop_post->post_title; ?>" loading="lazy">
										<span class="name"><?= $dop; ?>x Додаток <?= $dop_post->post_title; ?></span>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			<?php } ?>
		</div>
		<div class="minicart-bottom">
			<h4>Сума замовлення:
			</h4>
			<span> <?php
					/**
					 * Hook: woocommerce_widget_shopping_cart_total.
					 *
					 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
					 */
					do_action('woocommerce_widget_shopping_cart_total');
					?>
			</span>
			<a href="<?php echo wc_get_checkout_url(); ?>">Оформити замовлення</a>
		</div>
	<?php else : ?>
		<style>
			.wp-block-image img {
				max-width: 50%;
				margin: 20px auto;
			}

			.woocommerce-mini-cart__empty-message {
				font-size: 1.25rem;
				line-height: 2rem;
				margin-bottom: .125rem;
				color: #000;
				text-align: center;
				font-weight: 600;
			}
		</style>
		<p class="woocommerce-mini-cart__empty-message"><?php the_field('cart', 10); ?></p>
		<?php get_sidebar('mini-cart'); ?>
	<?php endif; ?>
</div>
<script>
	jQuery(document).ready(function($) {
	    $count = <?php echo sprintf(WC()->cart->cart_contents_count); ?>;
	    if( $count>0){
	        	    $('#minicart_btn .count').text('<?php echo sprintf(WC()->cart->cart_contents_count); ?>');
	        	       $('#minicart_btn .count').css('display','block')
	    }else{
	           $('#minicart_btn .count').css('display','none')
	    }
	    

		$('#minicart_btn').on('click', function() {

			$('.minicart-popap').addClass('active')
			$('body').addClass('none-scroll')

		})
		$('#pay').on('click', function() {

			$('.minicart-top,.minicart-content,.minicart-bottom').css('display', 'none')

		})

		$('.minicart-popap .overlay,.minicart-popap .close').on('click', function() {

			$('.minicart-popap').removeClass('active')
			$('body').removeClass('none-scroll')

		})
		$('#delete_all').on('click', function(e) {
			e.stopPropagation();
			$.ajax({
				url: '<?php echo admin_url("admin-ajax.php") ?>',
				type: 'POST',
				data: 'action=delete_all',
				success: function(data) {
					console.log(data)
					$('.minicart-popap').html(data);
				}
			})
		})
	})
</script>