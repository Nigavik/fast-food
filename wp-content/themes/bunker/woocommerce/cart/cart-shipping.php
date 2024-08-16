<?php

/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text          = '';
?>

<div class="order-ship">
	<div class="order_review_top">
		<span><?php echo wp_kses_post($package_name); ?></span>
		<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" height="800px" width="800px" version="1.1" id="Layer_1" viewBox="0 0 330 330" xml:space="preserve">
			<path id="XMLID_224_" d="M325.606,229.393l-150.004-150C172.79,76.58,168.974,75,164.996,75c-3.979,0-7.794,1.581-10.607,4.394  l-149.996,150c-5.858,5.858-5.858,15.355,0,21.213c5.857,5.857,15.355,5.858,21.213,0l139.39-139.393l139.397,139.393  C307.322,253.536,311.161,255,315,255c3.839,0,7.678-1.464,10.607-4.394C331.464,244.748,331.464,235.251,325.606,229.393z" />
		</svg>
	</div>
	<tr class="woocommerce-shipping-totals shipping">

		<td data-title="<?php echo esc_attr($package_name); ?>">
			<?php if (!empty($available_methods) && is_array($available_methods)) : ?>
				<ul id="shipping_method" class="woocommerce-shipping-methods">
					<?php foreach ($available_methods as $method) : ?>
						<li>
							<?php
							if (1 < count($available_methods)) {
								printf('<input type="radio" form="foo" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
							} else {
								printf('<input type="hidden" form="foo" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // WPCS: XSS ok.
							}
							printf('<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
							do_action('woocommerce_after_shipping_rate', $method, $index);
							?>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php if (is_cart()) : ?>
					<p class="woocommerce-shipping-destination">
						<?php
						if ($formatted_destination) {
							// Translators: $s shipping destination.
							printf(esc_html__('Shipping to %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>');
							$calculator_text = esc_html__('Change address', 'woocommerce');
						} else {
							echo wp_kses_post(apply_filters('woocommerce_shipping_estimate_html', __('Shipping options will be updated during checkout.', 'woocommerce')));
						}
						?>
					</p>
				<?php endif; ?>
			<?php
			elseif (!$has_calculated_shipping || !$formatted_destination) :
				if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
					echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'woocommerce')));
				} else {
					echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your address to view shipping options.', 'woocommerce')));
				}
			elseif (!is_cart()) :
				echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')));
			else :
				echo wp_kses_post(
					/**
					 * Provides a means of overriding the default 'no shipping available' HTML string.
					 *
					 * @since 3.0.0
					 *
					 * @param string $html                  HTML message.
					 * @param string $formatted_destination The formatted shipping destination.
					 */
					apply_filters(
						'woocommerce_cart_no_shipping_available_html',
						// Translators: $s shipping destination.
						sprintf(esc_html__('No shipping options were found for %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>'),
						$formatted_destination
					)
				);
				$calculator_text = esc_html__('Enter a different address', 'woocommerce');
			endif;
			?>

			<?php if ($show_package_details) : ?>
				<?php echo '<p class="woocommerce-shipping-contents"><small>' . esc_html($package_details) . '</small></p>'; ?>
			<?php endif; ?>

			<?php if ($show_shipping_calculator) : ?>
				<?php woocommerce_shipping_calculator($calculator_text); ?>
			<?php endif; ?>
		</td>
		<select form="foo" name="date_time" id="select_date_time" class="select">
			<option disabled>Якнайшвидше</option>
			<option value="1">Якнайшвидше</option>
			<option value="2">Обрати час</option>

		</select>
	</tr>
	<div id="date_time_box">
		<input type="date" form="foo" id="start" name="trip-start" value="<?= date("Y-m-d"); ?>" min="<?= date("Y-m-d"); ?>" max="" />
		<input type="time" form="foo" id="appt" name="appt" min="09:00" max="18:00" required />
	</div>
	<script>
		jQuery(function($) {
			$('.select').each(function() {
				const _this = $(this),
					selectOption = _this.find('option'),
					selectOptionLength = selectOption.length,
					selectedOption = selectOption.filter(':selected'),
					duration = 250; // длительность анимации 

				_this.hide();
				_this.wrap('<div class="select"></div>');
				$('<div>', {
					class: 'new-select',
					text: _this.children('option:disabled').text()
				}).insertAfter(_this);

				const selectHead = _this.next('.new-select');
				$('<div>', {
					class: 'new-select__list'
				}).insertAfter(selectHead);

				const selectList = selectHead.next('.new-select__list');
				for (let i = 1; i < selectOptionLength; i++) {
					$('<div>', {
							class: 'new-select__item',
							html: $('<span>', {
								text: selectOption.eq(i).text()
							})
						})
						.attr('data-value', selectOption.eq(i).val())
						.appendTo(selectList);
				}

				const selectItem = selectList.find('.new-select__item');
				selectList.slideUp(0);
				selectHead.on('click', function() {
					if (!$(this).hasClass('on')) {
						$(this).addClass('on');
						selectList.slideDown(duration);

						selectItem.on('click', function() {
							let chooseItem = $(this).data('value');
							console.log(chooseItem)
							$('select').val(chooseItem).attr('selected', 'selected');
							selectHead.text($(this).find('span').text());

							selectList.slideUp(duration);
							selectHead.removeClass('on');
							if (chooseItem > 1) {
								if (!$('#date_time_box').hasClass('open')) {
									$('#date_time_box').addClass('open')
								}
							} else {
								$('#date_time_box').removeClass('open')
							}
						});

					} else {
						$(this).removeClass('on');
						selectList.slideUp(duration);
					}
				});
			});
			$('#select_date_time').on('change', function() {
				if (this.value === 2) {
					$('#date_time_box').css('max-height', '1000px')
				} else {
					$('#date_time_box').css('max-height', '0px')
				}
				console.log(this.value);
			});
		});
	</script>
</div>