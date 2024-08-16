<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bunker-food
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<header>
		<div class="header-top">
			<div class="container">
				<div class="burger">
					<span></span>
				</div>
				<div class="mob-menu">
					<div class="header-nav">
						<ul class="parent">
							<ul>
								<?php
								$args = array(
									'taxonomy' => 'product_cat',
									'hide_empty' => false,
									'exclude' => array(15, 27),
									'meta_key' => 'order'
								);
								$product_categories = get_terms($args);

								$count = count($product_categories);

								if ($count > 0) {
									foreach ($product_categories as $product_category) {
										if ($product_category->parent == 0) {
											echo '	</ul>	</li>	<li><span>' . $product_category->name . '</span><ul class="children">';
										} else {
											echo '<li>  <a href="#' . $product_category->term_id . '"><img src="' . wp_get_attachment_url(get_term_meta($product_category->term_id, 'thumbnail_id', true)) . '" alt="' . $product_category->name . '_link"  loading="lazy">' . $product_category->name . '</a></li>';
										}
									}
								}
								?>
							</ul>
							<?php
							wp_nav_menu(
								array(
									'container'       => false,
									'theme_location' => 'menu-1',
									'menu_id'        => 'primary-menu',
									'items_wrap'      => '%3$s',
								)
							);
							?>
						</ul>
					</div>
					<div class="schedule-box">
						<?php $grafick =  get_field('grafick', 'term_23'); ?>
						<img src="<?= $grafick['img'] ?>" alt="clock">
						<span>
							<?= $grafick['text'] ?></span>
					</div>
				</div>
				<?php the_custom_logo(); ?>
				<div class="header-nav">
					<ul class="parent">
						<ul>
							<?php
							$count = count($product_categories);
							if ($count > 0) {
								foreach ($product_categories as $product_category) {
									if ($product_category->parent == 0) {
										echo '	</ul>	</li>	<li><span>' . $product_category->name . '</span><ul class="children">';
									} else {
										echo '<li>  <a href="#' . $product_category->term_id . '"><img src="' . wp_get_attachment_url(get_term_meta($product_category->term_id, 'thumbnail_id', true)) . '" alt="' . $product_category->name . '_link"  loading="lazy">' . $product_category->name . '</a></li>';
									}
								}
							}
							?>
						</ul>
						</li>
					</ul>
				</div>
				<div class="header-top-right">
					<div class="schedule-box">
						<img src="<?= $grafick['img'] ?>" alt="clock">
						<span>
							<?= $grafick['text'] ?></span>
					</div>
					<div id="minicart_btn">
						<?php $minicart =  get_field('minicart', 'term_23'); ?>
						<img src="<?= $minicart['svg'] ?>" alt="minicart"><?= $minicart['text'] ?>
						<span class="count"><?php echo sprintf(WC()->cart->cart_contents_count); ?></span>
					</div>
				</div>
			</div>
		</div>
	</header>
	<script>
        jQuery(document).ready(function($) {
            $("header,.mob-menu, footer").on("click", "a", function(event) {
                event.preventDefault();
                var id = $(this).attr('href');
                <?php if (is_front_page()) {
                ?>
                    id = id.replace('<?= get_site_url() ?>/#', '#');  
					  if (id.includes('<?= get_site_url() ?>')) {
                        location.href = id;
                    }
                <?php
                }else{
                ?>
                    if (id.includes('<?= get_site_url() ?>')) {
                        location.href = id;
                    }else{
						location.href = '<?= get_site_url() ?>' + id;
					}    
					<?php } ?>        
				
        $('.burger').removeClass('active')

    
              var  top = $(id).offset().top - 100;
                $('body,html').animate({
                    scrollTop: top
                }, 1000);
            });
        });
	</script>
	<div class="minicart-popap">
		<?php woocommerce_mini_cart(); ?>
	</div>
	<div class="call-popap">
		<div class="overlay"></div>
		<div class="call-box">
			<h2>Передзвонити вам?</h2>
			<div class="close"><svg xmlns="http://www.w3.org/2000/svg" width="800px" height="800px" viewBox="0 0 24 24" fill="none">
					<path d="M3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12Z" stroke="#000000" stroke-width="2" />
					<path d="M9 9L15 15M15 9L9 15" stroke="#000000" stroke-width="2" stroke-linecap="round" />
				</svg></div>
			<span>Вкажіть ваш номер телефону та ім'я. Ми зателефонуємо вам найближчим часом.</span>
			<form action="#" id="send_phone">
				<div class="form-box"><span>Ім'я
					</span><input type="text" name="name"></div>
				<div class="form-box"><span>Телефон
					</span><input type="number" name="phone"></div>
				<input type="hidden" name="action" value="send_phone">
				<input type="submit" value="Надіслати">
			</form>
		</div>
	</div>
	<main>