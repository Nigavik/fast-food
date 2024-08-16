<?php

/**
 * bunker-food functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package bunker-food
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bunker_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on bunker-food, use a find and replace
		* to change 'bunker' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('bunker', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'bunker'),
			'menu-2' => esc_html__('footer_left', 'bunker'),
			'menu-3' => esc_html__('footer_center', 'bunker'),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'bunker_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'bunker_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function bunker_content_width()
{
	$GLOBALS['content_width'] = apply_filters('bunker_content_width', 640);
}
add_action('after_setup_theme', 'bunker_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bunker_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('mini-cart', 'bunker'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'bunker'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__('thankyou', 'bunker'),
			'id'            => 'sidebar-2',
			'description'   => esc_html__('Add widgets here.', 'bunker'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'bunker_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function bunker_scripts()
{

	/*wp_enqueue_style( 'bunker-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'bunker-style', 'rtl', 'replace' );*/

	//wp_enqueue_style('bunker-footer.css', get_template_directory_uri() . '/assets/css/footer.min.css');



	if (is_page_template('template-parts/templates-home.php')) {
		wp_enqueue_style('bunker-swiper-bundle.min.css', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css');
		//	wp_enqueue_style('bunker-main.css', get_template_directory_uri() . '/assets/css/main.min.css');
		wp_enqueue_script('bunker-swiper-bundle.min.js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), null, true);
		//		wp_enqueue_script('bunker-main.js', get_template_directory_uri() . '/assets/js/main.min.js?speed=0', array('jquery'), null, true);
	}
	if (is_page_template('template-parts/templates-about.php')) {
		wp_enqueue_style('bunker-about.css', get_template_directory_uri() . '/assets/css/about.css');
	}
	if (is_checkout()) {
		wp_enqueue_style('bunker-checkout.css', get_template_directory_uri() . '/assets/css/checkout.css');
		wp_enqueue_style('bunker-jquery-ui.css', get_template_directory_uri() . '/assets/css/jquery-ui.css');
		wp_enqueue_script('bunker-checkout.js', get_template_directory_uri() . '/assets/js/jquery-ui.js', array('jquery'), null, true);
		wp_enqueue_script('bunker-jquery-ui-timepicker-addon.js', get_template_directory_uri() . '/assets/js/jquery-ui-timepicker-addon.js', array('jquery'), null, true);
	}
	if (is_page_template('template-parts/templates-payment.php')) {
		wp_enqueue_style('bunker-payment.css', get_template_directory_uri() . '/assets/css/payment.css');
	}
	if (is_page_template('template-parts/templates-contacts.php')) {
		wp_enqueue_style('bunker-contacts.css', get_template_directory_uri() . '/assets/css/contacts.css');
	}
	wp_enqueue_style('bunker-header.css', get_template_directory_uri() . '/assets/css/header.min.css');
	wp_enqueue_script('bunker-header.js', get_template_directory_uri() . '/assets/js/header.min.js?speed=0', array('jquery'), null, true);
	//wp_enqueue_script('bunker-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
}
add_action('wp_enqueue_scripts', 'bunker_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}


add_action('init', 'register_post_types');

function register_post_types()
{

	register_post_type('product_dop', [
		'label'  => null,
		'labels' => [
			'name'               => 'Додатки за смаком', // основное название для типа записи
			'singular_name'      => 'Додаток за смаком', // название для одной записи этого типа
			'add_new'            => 'Додати', // для добавления новой записи
			'add_new_item'       => 'Додати', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редагування', // для редактирования типа записи
			'new_item'           => 'Нове', // текст новой записи
			'view_item'          => 'Перегляд', // для просмотра записи этого типа.
			'search_items'       => 'Пошук', // для поиска по этим типам записи
			'not_found'          => 'Не знайдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не знайдено в кошику', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Додатки за смаком', // название меню

		],
		'description'            => '',
		'public'                 => true,
		'publicly_queryable'  => false, // зависит от public
		'exclude_from_search' => true, // зависит от public
		'show_in_menu'           => null, // показывать ли в меню админки
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => null,
		'menu_icon'           => null,
		'hierarchical'        => false,
		'supports'            => ['title', 'editor', 'thumbnail'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	]);
}

// $woocommerce->cart->empty_cart( $clear_persistent_cart = true ); очистить корзину



add_action('wp_ajax_add_prod_home', 'add_prod_home_ajax'); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action('wp_ajax_nopriv_add_prod_home', 'add_prod_home_ajax');  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
function add_prod_home_ajax()
{
	$dop = json_decode(str_replace("\\", "", $_POST['dop']));
	$dop2 =   [];
	foreach ($dop as  $value) {
		$dop2 +=    (array) $value;
	}
	WC()->cart->add_to_cart($product_id = $_POST['id'], $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array('dop' => $dop2));
	woocommerce_mini_cart();
	die;
}

add_action('woocommerce_checkout_create_order_line_item', 'save_as_custom_order_item_meta_data', 10, 4);
function save_as_custom_order_item_meta_data($item, $cart_item_key, $values, $order)
{
	if (count($values['dop'])) {
		$item->update_meta_data('dop', $values['dop']);
	}
	return $item;
}
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment($fragments)
{
	global $woocommerce;

	ob_start();

?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count); ?> – <?php echo $woocommerce->cart->get_cart_total(); ?></a>
<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}

add_action('woocommerce_before_quantity_input_field', 'bunker_quantity_plus', 25);
add_action('woocommerce_after_quantity_input_field', 'bunker_quantity_minus', 25);

function bunker_quantity_plus()
{
	echo '<button type="button" class="plus"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve">
									<g>
										<path d="M281.672,48.328C250.508,17.163,209.073,0,164.999,0C120.927,0,79.492,17.163,48.328,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.492,312.837,120.927,330,165,330c44.073,0,85.508-17.163,116.672-48.328   C346.005,217.339,346.005,112.661,281.672,48.328z M260.46,260.46C234.961,285.957,201.06,300,165,300   c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919C95.039,44.042,128.94,30,164.999,30   c36.06,0,69.961,14.042,95.46,39.54C313.095,122.177,313.095,207.823,260.46,260.46z"></path>
										<path d="M254.999,150H180V75c0-8.284-6.716-15-15-15s-15,6.716-15,15v75H75c-8.284,0-15,6.716-15,15s6.716,15,15,15h75v75   c0,8.284,6.716,15,15,15s15-6.716,15-15v-75h74.999c8.284,0,15-6.716,15-15S263.284,150,254.999,150z"></path>
									</g>
								</svg></button>';
}

function bunker_quantity_minus()
{
	echo '<button type="button" class="minus"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve" style="
">
									<g>
										<path d="M281.633,48.328C250.469,17.163,209.034,0,164.961,0C120.888,0,79.453,17.163,48.289,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.453,312.837,120.888,330,164.962,330c44.073,0,85.507-17.163,116.671-48.328   c31.165-31.164,48.328-72.599,48.328-116.672S312.798,79.492,281.633,48.328z M260.42,260.46   C234.922,285.957,201.021,300,164.962,300c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919   C95,44.042,128.901,30,164.961,30s69.961,14.042,95.459,39.54c25.498,25.499,39.541,59.4,39.541,95.46   S285.918,234.961,260.42,260.46z"></path>
										<path d="M254.961,150H74.962c-8.284,0-15,6.716-15,15s6.716,15,15,15h179.999c8.284,0,15-6.716,15-15S263.245,150,254.961,150z"></path>
									</g>
								</svg></button>';
}
function enqueue_cart_qty_ajax()
{

	wp_register_script('my_cart_qty-ajax-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '', true);
	wp_localize_script('my_cart_qty-ajax-js', 'cart_qty_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
	wp_enqueue_script('my_cart_qty-ajax-js');
}
add_action('wp_enqueue_scripts', 'enqueue_cart_qty_ajax');
function ajax_my_cart_qty()
{

	// Set item key as the hash found in input.qty's name
	$cart_item_key = $_POST['hash'];

	// Get the array of values owned by the product we're updating
	$threeball_product_values = WC()->cart->get_cart_item($cart_item_key);

	// Get the quantity of the item in the cart
	$threeball_product_quantity = apply_filters('woocommerce_stock_amount_cart_item', apply_filters('woocommerce_stock_amount', preg_replace("/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT))), $cart_item_key);

	// Update cart validation
	$passed_validation  = apply_filters('woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity);

	// Update the quantity of the item in the cart
	if ($passed_validation) {
		WC()->cart->set_quantity($cart_item_key, $threeball_product_quantity, true);
	}

	// Refresh the page
	woocommerce_mini_cart();

	die();
}

add_action('wp_ajax_my_cart_qty', 'ajax_my_cart_qty');
add_action('wp_ajax_nopriv_my_cart_qty', 'ajax_my_cart_qty');


function ajax_delete_all()
{
	WC()->cart->empty_cart($clear_persistent_cart = true);
	// Refresh the page
	woocommerce_mini_cart();

	die();
}

add_action('wp_ajax_delete_all', 'ajax_delete_all');
add_action('wp_ajax_nopriv_delete_all', 'ajax_delete_all');


class Bunker_Walker_Nav_Menu extends Walker_Nav_Menu
{
	/*
	 * Позволяет перезаписать <ul class="sub-menu">
	 */
	function start_lvl(&$output, $depth = 0, $args = NULL)
	{
		// для WordPress 5.3+
		// function start_lvl( &$output, $depth = 0, $args = NULL ) {
		/*
		 * $depth – уровень вложенности, например 2,3 и т д
		 */
		$output .= '<ul class="menu_sublist">';
	}
	/**
	 * @see Walker::start_el()
	 * @since 3.0.0
	 *
	 * @param string $output
	 * @param object $item Объект элемента меню, подробнее ниже.
	 * @param int $depth Уровень вложенности элемента меню.
	 * @param object $args Параметры функции wp_nav_menu
	 */
	function start_el(&$output, $item, $depth = 0, $args = NULL, $id = 0)
	{
		// для WordPress 5.3+
		// function start_el( &$output, $item, $depth = 0, $args = NULL, $id = 0 ) {
		global $wp_query;

		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		/*
		 * Генерируем строку с CSS-классами элемента меню
		 */
		$class_names = $value = '';
		$classes = empty($item->classes) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// функция join превращает массив в строку
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = ' class="' . esc_attr($class_names) . '"';

		/*
		 * Генерируем ID элемента
		 */
		$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
		$id = strlen($id) ? ' id="' . esc_attr($id) . '"' : '';

		/*
		 * Генерируем элемент меню
		 */
		$output .= $indent . '<li' . $id . $value . $class_names . '>';

		// атрибуты элемента, title="", rel="", target="" и href=""
		$attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
		$attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
		$attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
		$attributes .= !empty($item->url)        ? ' href="#'   . esc_attr($item->object_id) . '"' : '';

		// ссылка и околоссылочный текст
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}
}

add_action('wp_ajax_send_phone', 'send_phone');
add_action('wp_ajax_nopriv_send_phone', 'send_phone');
function send_phone()
{
	print_r($_POST);
	$TOKEN = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXX';

	// ID чата
	$CHATID = 'XXXXXXXXXXXXX';
	$fileSendStatus = '';
	$textSendStatus = '';
	$txt = "ЗАМОВЛЕННЯ ДЗВІНКА %0A Ім'я: " . esc_sql($_POST['name']) . "%0A Телефон: " . esc_sql($_POST['phone']);
	$textSendStatus = @file_get_contents('https://api.telegram.org/bot' . $TOKEN . '/sendMessage?chat_id=' . $CHATID . '&parse_mode=html&text=' . $txt);
	$urlFile =  "https://api.telegram.org/bot" . $TOKEN . "/sendMediaGroup";
	// Путь загрузки файлов
	$path = $_SERVER['DOCUMENT_ROOT'] . '/telegramform/tmp/';
	// Загрузка файла и вывод сообщения
	$mediaData = [];
	$postContent = [
		'chat_id' => $CHATID,
	];
	$postContent['media'] = json_encode($mediaData);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
	curl_setopt($curl, CURLOPT_URL, $urlFile);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postContent);
	$fileSendStatus = curl_exec($curl);
	curl_close($curl);
	$files = glob($path . '*');
	foreach ($files as $file) {
		if (is_file($file))
			unlink($file);
	}
	print_r($fileSendStatus);
	if (!curl_errno($curl)) {
		switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
			case 200:  # OK
				break;
			default:
				echo 'Неожиданный код HTTP: ', $http_code, "\n";
		}
	}
}
add_action('wp_ajax_ajax_order', 'submited_ajax_order_data');
add_action('wp_ajax_nopriv_ajax_order', 'submited_ajax_order_data');
function submited_ajax_order_data()
{
	if (isset($_POST['fields']) && !empty($_POST['fields'])) {

		$order    = new WC_Order();
		$cart     = WC()->cart;
		$checkout = WC()->checkout;
		$data     = [];
		// Loop through posted data array transmitted via jQuery
		foreach ($_POST['fields'] as $values) {
			// Set each key / value pairs in an array
			$data[$values['name']] = $values['value'];
		}

		$cart_hash          = md5(json_encode(wc_clean($cart->get_cart_for_session())) . $cart->total);
		$available_gateways = WC()->payment_gateways->get_available_payment_gateways();

		// Loop through the data array
		foreach ($data as $key => $value) {
			// Use WC_Order setter methods if they exist
			if (is_callable(array($order, "set_{$key}"))) {
				$order->{"set_{$key}"}($value);

				// Store custom fields prefixed with wither shipping_ or billing_
			} elseif ((0 === stripos($key, 'billing_') || 0 === stripos($key, 'shipping_'))
				&& !in_array($key, array('shipping_method', 'shipping_total', 'shipping_tax'))
			) {
				$order->update_meta_data('_' . $key, $value);
			}
		}

		$order->set_created_via('checkout');
		$order->set_cart_hash($cart_hash);
		$order->set_customer_id(apply_filters('woocommerce_checkout_customer_id', isset($_POST['user_id']) ? $_POST['user_id'] : ''));
		$order->set_currency(get_woocommerce_currency());
		$order->set_prices_include_tax('yes' === get_option('woocommerce_prices_include_tax'));
		$order->set_customer_ip_address(WC_Geolocation::get_ip_address());
		$order->set_customer_user_agent(wc_get_user_agent());
		$order->set_customer_note(isset($data['order_comments']) ? $data['order_comments'] : '');
		$order->set_payment_method(isset($available_gateways[$data['payment_method']]) ? $available_gateways[$data['payment_method']]  : $data['payment_method']);
		$order->set_shipping_total($cart->get_shipping_total());
		$order->set_discount_total($cart->get_discount_total());
		$order->set_discount_tax($cart->get_discount_tax());
		$order->set_cart_tax($cart->get_cart_contents_tax() + $cart->get_fee_tax());
		$order->set_shipping_tax($cart->get_shipping_tax());
		$order->set_total($cart->get_total('edit'));

		$checkout->create_order_line_items($order, $cart);
		$checkout->create_order_fee_lines($order, $cart);
		$checkout->create_order_shipping_lines($order, WC()->session->get('chosen_shipping_methods'), WC()->shipping->get_packages());
		$checkout->create_order_tax_lines($order, $cart);
		$checkout->create_order_coupon_lines($order, $cart);

		/**
		 * Action hook to adjust order before save.
		 * @since 3.0.0
		 */
		do_action('woocommerce_checkout_create_order', $order, $data);

		// Save the order.
		$order_id = $order->save();

		do_action('woocommerce_checkout_update_order_meta', $order_id, $data);

		echo 'New order created with order ID: #' . $order_id . '.';
	}
	die();
}

add_filter('woocommerce_billing_fields', 'custom_override_checkout_fields', 10);

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields($fields)
{
	$fields['billing']['billing_phone']['required'] = false;
	$fields['billing']['billing_postcode']['required'] = false;
	return $fields;
}

add_filter('woocommerce_default_address_fields', 'custom_override_default_address_fields');

// Our hooked in function - $address_fields is passed via the filter!
function custom_override_default_address_fields($address_fields)
{
	$address_fields['postcode']['required'] = false;
	$address_fields['city']['required'] = false;

	return $address_fields;
}

add_action('woocommerce_order_status_processing', 'create_invoice_for_wc_order', 10, 3);
function create_invoice_for_wc_order($order_id, $order)
{
   /* print_r($_POST);
    exit;*/
    $data_time;
    if($_POST['date_time']>1){
        $data_time = $_POST['trip-start'] . ' ' . $_POST['appt'];
    }else{
         $data_time = 'Якнайшвидше';
    }
	$shipping_item_metod = [];
	foreach ($order->get_shipping_methods() as $shipping_item) {
		print_r($shipping_item);
		if ($shipping_item['instance_id'] > 2) {
			$shipping_item_metod = array('title' => $shipping_item['method_title'], 'price' => $shipping_item['total'].'₴');
		} else {
			$shipping_item_metod = array('title' => $shipping_item['method_title'], 'price' => '');
		}
	}
	// exit;
	$order_itemss = array();

	foreach ($order->get_items() as $item_id => $item) {
		$dop_box =  array();
		$premiere_box_abo =  array();
		$premiere_box_abo[] = $item->get_meta('dop');

		foreach ($premiere_box_abo as $premiere_box) {
			foreach ($premiere_box as $key => $value) {
				array_push($dop_box, get_the_title($key) . '%20x' . $value . '%20');
			}
		}
		$product = $item->get_product();

		$dop_box_item =  array(

			'Продукт' => $item->get_name() . '%20x' . $item->get_quantity(),
			'Ціна' => $product->get_price(),
			'Додаток' => implode(",", $dop_box),
			'Всього' => $item->get_total(),
		);

		array_push($order_itemss, $dop_box_item);
	}

	// Order data
	$data2 = array(
		"Ім'я" => $order->get_billing_first_name(),
		'Прізвище' => $order->get_billing_last_name(),
		'Адреса' => $order->get_billing_address_1(),
		'Телефон' => $order->get_billing_phone(),
		
	);


	$data_dop = array(
		'За все' => $order->get_total(),
		 $shipping_item_metod['title'] =>  $shipping_item_metod['price'],
		 'Час доставки' => $data_time,
	);
	// Токен
	$TOKEN = 'XXXXXXXXXXXXX';


	$CHATID = '- XXXXXXXXXXXXX';
	$fileSendStatus = '';
	$textSendStatus = '';
	$txt = 'ЗАМОВЛЕННЯ %0A';
	foreach ($data2 as $key => $value) {
		$txt .= "<b>" . $key . ":</b>%20" . $value . ";%0A";
	};
	$txt .= "%0A%0A";
	foreach ($order_itemss as $order_items) {
		foreach ($order_items as $key => $value) {
			$txt .= "<b>" . $key . ":</b>%20" . $value . ";%0A";
		};
		$txt .= "%0A%0A";
	}
	foreach ($data_dop as $key => $value) {
		$txt .= "<b>" . $key . ":</b>%20" . $value . "%0A";
	};


	$textSendStatus = @file_get_contents('https://api.telegram.org/bot' . $TOKEN . '/sendMessage?chat_id=' . $CHATID . '&parse_mode=html&text=' . $txt);
	$urlFile =  "https://api.telegram.org/bot" . $TOKEN . "/sendMediaGroup";
	// Путь загрузки файлов
	$path = $_SERVER['DOCUMENT_ROOT'] . '/telegramform/tmp/';
	// Загрузка файла и вывод сообщения
	$mediaData = [];
	$postContent = [
		'chat_id' => $CHATID,
	];
	$postContent['media'] = json_encode($mediaData);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
	curl_setopt($curl, CURLOPT_URL, $urlFile);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postContent);
	$fileSendStatus = curl_exec($curl);
	curl_close($curl);
}


add_action('init', 'jk_remove_storefront_header_search');
function jk_remove_storefront_header_search()
{
	remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
}
add_action('woocommerce_checkout_after_customer_details', 'woocommerce_checkout_payment', 20);


add_action('woocommerce_before_calculate_totals', 'truemisha_quantity_based_price');

function truemisha_quantity_based_price($cart_object)
{
	foreach ($cart_object->get_cart() as $cart_id => $cart_item) {
		$new_price = 0;
		if (!empty($cart_item['dop'])) {
			foreach ($cart_item['dop'] as $key => $value) {
				$post	= get_post($key);
				if ($post->post_type === 'product') {
					$products = wc_get_product($post->ID);
					$new_price = $new_price + ($products->get_price() *  $value);
				} else {
					$new_price = $new_price + (get_field('price', $post->ID) *  $value);
				}
			}
		}
		$cart_item['data']->set_price($cart_item['data']->get_price() + $new_price);
	}
}
add_action('admin_menu', 'true_remove_default_menus');

function true_remove_default_menus()
{
	remove_menu_page('edit.php');
	remove_menu_page('edit-comments.php');
}



add_action('woocommerce_admin_order_item_headers', 'download_image_admin_order_item_headers', 10, 0);
function download_image_admin_order_item_headers()
{
	echo '<th class="item sortable" colspan="1" data-sort="string-ins">' . __('Додаток', 'woocommerce') . '</th>';
}

add_action('woocommerce_admin_order_item_values', 'download_image_order_item_values', 10, 3);
function download_image_order_item_values($_product, $item, $item_id)
{

	$dop = $item->get_meta('dop');
	if (!empty($dop)) {
		echo '<td class="dop"><ul>';
		foreach ($dop as $key => $value) {
			echo '<li>' . get_the_title($key) . ' x' . $value . '</li>';
		}
		echo '</td></ul>';
	}
}

add_filter('wp_enqueue_scripts', 'true_dequeue_gutenberg_styles', 999);

function true_dequeue_gutenberg_styles()
{

	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('global-styles'); // глобальные CSS-переменные
	wp_dequeue_style('bunker-woocommerce-style');
	wp_dequeue_style('wc-blocks');

	wp_dequeue_style('safe-svg-svg-icon-style');
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_script('wc-order-attribution');
	wp_dequeue_script('sourcebuster-js');
}
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

add_filter('woocommerce_add_to_cart_fragments', 'header_add_to_cart_fragment');

function header_add_to_cart_fragment($fragments)
{
	ob_start();
?>
	<span class="count">(<?php echo sprintf(WC()->cart->cart_contents_count); ?>)</span>
<?php
	$fragments['.basket-btn__counter'] = ob_get_clean();
	return $fragments;
}
