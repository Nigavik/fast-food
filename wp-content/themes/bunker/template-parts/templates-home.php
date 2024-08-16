<?php
/*
 * Template name: Home
 *  * Template post type: page
 */
//global $product;
get_header();
$id = get_the_ID();
$top_slider = get_field('banner', $id);
$twists = get_field('twists', $id);
$add_to_taste = get_field('add_to_taste', $id);
$pre_order = get_field('pre_order', $id);
$dodate_to_koshiku_za = get_field('dodate_to_koshiku_za', $id);
?>
<section class="top">
    <div class="container">
        <div class="swiper banner">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <?php foreach ($top_slider as $banner) {
                    echo  '<div class="swiper-slide"><img src="' . $banner . '" alt="banner" width="300" height="240"></div>';
                }
                ?>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
</section>
<section class="catalog">
    <div class="container">
        <?php $args = array(
            'taxonomy' => 'product_cat',
            'hide_empty' => false,
            'exclude' => array(15, 27),
            'meta_key' => 'order'
        );
        $product_categories = get_terms($args);
        $count = count($product_categories);
        if ($count > 0) {
            $product_cat = [];
            foreach ($product_categories as $product_category) {

                if ($product_category->parent == 0) {
                    $product_cat[$product_category->term_id] = $product_category;
                    $product_cat[$product_category->term_id]->ids = $product_category->term_id;
                } else {
                    $cat_id = $product_category->term_id;
                    if (!($product_cat[$product_category->parent]->children)) {
                        $product_cat[$product_category->parent]->children = (object)array();
                    }
                    $product_cat[$product_category->parent]->children->$cat_id = $product_category;
                    $product_cat[$product_category->parent]->ids .= ',' . $product_category->term_id;
                }
            }
        }
        $query_dop = new WP_Query([
            'post_type' => 'product_dop',
        ]);
        $query_dop =   $query_dop->posts;
        $query_dop2 = [];
        foreach ($query_dop as $product_dop) {
            $price = get_field('price',  $product_dop->ID);
            $img =  wp_get_attachment_image_src(get_post_thumbnail_id($product_dop->ID), 'full')[0];
            array_push($query_dop2, ['price' => $price, 'img' => $img]);
        }
        $query_soucie = new WP_Query([
            'post_type' => 'product',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => 22,
                )
            )
        ]);
        $query_soucie  =   $query_soucie->posts;
        $query_soucie2 = [];
        foreach ($query_soucie as $query_sou) {
            $query_sou = wc_get_product($query_sou->ID);
            array_push($query_soucie2, $query_sou);
        }
        foreach ($product_cat as $cat) {
        ?>
            <div class="catalog-box" id="<?= $cat->term_id ?>">
                <div class="catalog-nav">
                    <h1><?= $cat->name ?> <span>(<?= $cat->count ?>)</span></h1>
                    <div class="catalog-nav-subcat">
                        <?php if ($cat->children) {
                            foreach ($cat->children as $children) {
                                echo '<button style="order: 2;" data-id="' . $children->term_id . '" id="' . $children->term_id . '">' . $children->name . '</button>';
                            }
                        ?> <button class="filter-close" data-id="0"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Button_icon__4a1qk">
                                    <path stroke="#909090" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6 6 18M6 6l12 12"></path>
                                </svg></button><?php
                                            }
                                                ?>
                    </div>
                    <div class="sort">
                        <span>За замовчуванням</span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Field_rightIcon__Pq4Ip" style="color: rgb(144, 144, 144); transform: rotate(0deg);">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"></path>
                        </svg>
                        <ul>
                            <li>
                                <button data-sorting="0">За замовчуванням<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Dropdown_rightIcon__ZPX31">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m16.727 9-6 6L8 12.273"></path>
                                    </svg></button>
                            </li>
                            <li>
                                <button data-sorting="1">Найдорожчі<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Dropdown_rightIcon__ZPX31">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m16.727 9-6 6L8 12.273"></path>
                                    </svg></button>
                            </li>
                            <li>
                                <button data-sorting="2">Найдешевші<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Dropdown_rightIcon__ZPX31">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m16.727 9-6 6L8 12.273"></path>
                                    </svg></button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="products">
                    <?php
                    $query = new WP_Query([
                        'post_type' => 'product',
                        'orderby' => array(
                            'title'    => 'ASC',
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'id',
                                'terms'    => array($cat->ids),
                            ),

                        )
                    ]);
                    if (in_array(16, explode(',', $cat->ids))) {
                        $c = 1;
                    } elseif (in_array(19, explode(',', $cat->ids))) {
                        $c = 2;
                    } elseif (in_array(21, explode(',', $cat->ids)) || in_array(20, explode(',', $cat->ids))) {
                        $c = 3;
                    } else {
                        $c = 0;
                    }
                    $posts_i = 0;
                    foreach ($query->posts as $product) {
                        $products = wc_get_product($product->ID);
                        $text = get_field('text',  $products->get_id());
                    ?>
                        <div class="product-box" data-price="<?= $products->get_price(); ?>" data-id="<?= $products->get_id() ?>" data-number="<?= $posts_i; ?>" data-cat="<?= $products->get_category_ids()[0]; ?>">
                            <img class="product-img" src="<?php echo wp_get_attachment_url($products->get_image_id(), 'full'); ?>" alt="<?= $product->post_title; ?>" <?php if ($c != 1) { ?> loading="lazy" <?php } ?> width="252" height="252">
                            <div class="product-card">
                                <h2 class="product-title"><?= $product->post_title; ?></h2>
                                <span class="product-description"><?= $text ?></span>
                                <div class="product-bottom">
                                    <div class="price"><?php if ($products->get_stock_status() === 'instock') {
                                                            echo $products->get_price_html();
                                                        } else {
                                                            echo 'немає в наявності';
                                                        } ?></div>
                                    <?php if ($products->get_stock_status() === 'instock') { ?> <button class="select "><?= $twists; ?></button>
                                        <div class="product-popap">
                                            <div class="overlay"></div>
                                            <div class="product-popap-box">
                                                <div class="close"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="Button_icon__4a1qk">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6">
                                                        </path>
                                                    </svg></div>
                                                <div class="left">
                                                    <img src="<?php echo wp_get_attachment_url($products->get_image_id(), 'full'); ?>" alt="<?= $product->post_title; ?>" loading="lazy">
                                                </div>
                                                <div class="right  <?php if ($c != 1) { ?> no  <?php } ?>">
                                                    <div class="product-popap-right-box">
                                                        <h2 class="product-title"><?= $product->post_title; ?></h2>
                                                        <div class="product-popap-info">
                                                            <?php if (!empty($products->get_weight())) { ?>
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                                        <path fill="#6F6F6F" d="M17.025 8.917A1.67 1.67 0 0 0 15.358 7.5h-3.175a3.333 3.333 0 1 0-4.366 0H4.625a1.67 1.67 0 0 0-1.667 1.417l-1.291 8.458a.833.833 0 0 0 .833.958h15a.833.833 0 0 0 .833-.958zM10 14.167a1.667 1.667 0 1 1 0-3.334 1.667 1.667 0 0 1 0 3.334m0-7.5a1.667 1.667 0 1 1 0-3.334 1.667 1.667 0 0 1 0 3.334">
                                                                        </path>
                                                                    </svg>
                                                                    <?= $products->get_weight(); ?> <?php if ($c === 3) {
                                                                                                        echo 'л';
                                                                                                    } else {
                                                                                                        echo 'г';
                                                                                                    } ?> </span>
                                                            <?php }
                                                            if (!empty($products->get_length())) { ?>
                                                                <span>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 19 20">
                                                                        <path fill="#6F6F6F" fill-rule="evenodd" d="M9.359 1c2.48 0 5.138.511 7.483 1.44.83.33.963.926.825 1.336l-.014.037-.15.366a.644.644 0 0 1-.857.345 50 50 0 0 0-1.052-.46C13.72 3.3 11.687 2.929 9.377 2.929c-2.301 0-4.455.387-6.224 1.121-.123.05-.65.282-1.084.473a.643.643 0 0 1-.857-.349l-.163-.409c-.14-.435 0-1.018.815-1.348C4.143 1.503 6.805 1 9.36 1m0 3.214c2.094 0 4.343.423 6.172 1.16l.005.002.181.075a.64.64 0 0 1 .334.862L10.534 18.27l-.002.005A1.27 1.27 0 0 1 9.376 19a1.27 1.27 0 0 1-1.154-.723c-1.127-2.33-3.59-7.715-4.911-10.61l-.063-.138-.56-1.224a.643.643 0 0 1 .321-.854c.09-.04.151-.068.173-.076a17.1 17.1 0 0 1 6.177-1.16M6.144 8.531a1.286 1.286 0 1 0 1.322-2.205A1.286 1.286 0 0 0 6.144 8.53m2.571 5.143a1.286 1.286 0 1 0 1.323-2.206 1.286 1.286 0 0 0-1.323 2.206m2.572-4.5a1.286 1.286 0 1 0 1.322-2.205 1.286 1.286 0 0 0-1.322 2.205" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                    <?= $products->get_length(); ?> см
                                                                </span>
                                                            <?php } ?>
                                                        </div>
                                                        <span class="product-description"><?= $text ?></span>
                                                        <?php if ($c === 1 || $c === 2) {
                                                            if ($c === 2) { ?>

                                                                <div class="dop-nav">
                                                                    <button class="active"><?= $pre_order; ?></button>
                                                                    <div class="after"></div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="dop-nav">
                                                                    <button class="active"><?= $add_to_taste; ?></button>
                                                                    <button><?= $pre_order; ?></button>
                                                                    <div class="after"></div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php }
                                                        if ($c === 1 || $c === 2) {
                                                        ?>
                                                            <div class="product-popap-dop">
                                                                <div class="product-popap-dop-box">
                                                                    <?php
                                                                    if ($c === 1) {
                                                                        $i = 0;
                                                                        foreach ($query_dop as $prod_dop) {
                                                                    ?>
                                                                            <div class="product-dop-ingredient dop active" data-id="<?php echo $prod_dop->ID; ?>" data-count="0">
                                                                                <img src="<?= $query_dop2[$i]['img'] ?>" alt="<?= $prod_dop->post_title; ?>" loading="lazy">
                                                                                <span class="name"><?= $prod_dop->post_title; ?></span>
                                                                                <span class="price"><?= $query_dop2[$i]['price'] ?> ₴</span>
                                                                                <div class="add-box">
                                                                                    <button type="button" class="minus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve" style="&#10;">
                                                                                            <g>
                                                                                                <path d="M281.633,48.328C250.469,17.163,209.034,0,164.961,0C120.888,0,79.453,17.163,48.289,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.453,312.837,120.888,330,164.962,330c44.073,0,85.507-17.163,116.671-48.328   c31.165-31.164,48.328-72.599,48.328-116.672S312.798,79.492,281.633,48.328z M260.42,260.46   C234.922,285.957,201.021,300,164.962,300c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919   C95,44.042,128.901,30,164.961,30s69.961,14.042,95.459,39.54c25.498,25.499,39.541,59.4,39.541,95.46   S285.918,234.961,260.42,260.46z" />
                                                                                                <path d="M254.961,150H74.962c-8.284,0-15,6.716-15,15s6.716,15,15,15h179.999c8.284,0,15-6.716,15-15S263.245,150,254.961,150z" />
                                                                                            </g>
                                                                                        </svg> </button>
                                                                                    <div class="count" data-count="0">x0</div><button type="button" class="plus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve">
                                                                                            <g>
                                                                                                <path d="M281.672,48.328C250.508,17.163,209.073,0,164.999,0C120.927,0,79.492,17.163,48.328,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.492,312.837,120.927,330,165,330c44.073,0,85.508-17.163,116.672-48.328   C346.005,217.339,346.005,112.661,281.672,48.328z M260.46,260.46C234.961,285.957,201.06,300,165,300   c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919C95.039,44.042,128.94,30,164.999,30   c36.06,0,69.961,14.042,95.46,39.54C313.095,122.177,313.095,207.823,260.46,260.46z" />
                                                                                                <path d="M254.999,150H180V75c0-8.284-6.716-15-15-15s-15,6.716-15,15v75H75c-8.284,0-15,6.716-15,15s6.716,15,15,15h75v75   c0,8.284,6.716,15,15,15s15-6.716,15-15v-75h74.999c8.284,0,15-6.716,15-15S263.284,150,254.999,150z" />
                                                                                            </g>
                                                                                        </svg>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        <?php ++$i;
                                                                        }
                                                                        foreach ($query_soucie2 as $prod) {
                                                                        ?>
                                                                            <div class="product-dop-ingredient sauce" data-id="<?php echo $prod->get_id(); ?>" data-count="0">
                                                                                <img src="<?php echo wp_get_attachment_url($prod->get_image_id(), 'full'); ?>" alt="<?= $prod->get_name(); ?>" loading="lazy">
                                                                                <span class="name"><?= $prod->get_name(); ?></span>
                                                                                <span class="price"><?php echo $prod->get_price_html(); ?></span>
                                                                                <div class="add-box">
                                                                                    <button type="button" class="minus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve" style="&#10;">
                                                                                            <g>
                                                                                                <path d="M281.633,48.328C250.469,17.163,209.034,0,164.961,0C120.888,0,79.453,17.163,48.289,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.453,312.837,120.888,330,164.962,330c44.073,0,85.507-17.163,116.671-48.328   c31.165-31.164,48.328-72.599,48.328-116.672S312.798,79.492,281.633,48.328z M260.42,260.46   C234.922,285.957,201.021,300,164.962,300c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919   C95,44.042,128.901,30,164.961,30s69.961,14.042,95.459,39.54c25.498,25.499,39.541,59.4,39.541,95.46   S285.918,234.961,260.42,260.46z" />
                                                                                                <path d="M254.961,150H74.962c-8.284,0-15,6.716-15,15s6.716,15,15,15h179.999c8.284,0,15-6.716,15-15S263.245,150,254.961,150z" />
                                                                                            </g>
                                                                                        </svg> </button>
                                                                                    <div class="count" data-count="0">x0</div><button type="button" class="plus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve">
                                                                                            <g>
                                                                                                <path d="M281.672,48.328C250.508,17.163,209.073,0,164.999,0C120.927,0,79.492,17.163,48.328,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.492,312.837,120.927,330,165,330c44.073,0,85.508-17.163,116.672-48.328   C346.005,217.339,346.005,112.661,281.672,48.328z M260.46,260.46C234.961,285.957,201.06,300,165,300   c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919C95.039,44.042,128.94,30,164.999,30   c36.06,0,69.961,14.042,95.46,39.54C313.095,122.177,313.095,207.823,260.46,260.46z" />
                                                                                                <path d="M254.999,150H180V75c0-8.284-6.716-15-15-15s-15,6.716-15,15v75H75c-8.284,0-15,6.716-15,15s6.716,15,15,15h75v75   c0,8.284,6.716,15,15,15s15-6.716,15-15v-75h74.999c8.284,0,15-6.716,15-15S263.284,150,254.999,150z" />
                                                                                            </g>
                                                                                        </svg>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        foreach ($query_soucie2 as $prod) {
                                                                        ?>
                                                                            <div class="product-dop-ingredient sauce dop active" data-id="<?php echo $prod->get_id(); ?>" data-count="0">
                                                                                <img src="<?php echo wp_get_attachment_url($prod->get_image_id(), 'full'); ?>" alt="<?= $prod->get_name(); ?>" loading="lazy">
                                                                                <span class="name"><?= $prod->get_name(); ?></span>
                                                                                <span class="price"><?php echo $prod->get_price_html(); ?></span>
                                                                                <div class="add-box">
                                                                                    <button type="button" class="minus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve" style="&#10;">
                                                                                            <g>
                                                                                                <path d="M281.633,48.328C250.469,17.163,209.034,0,164.961,0C120.888,0,79.453,17.163,48.289,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.453,312.837,120.888,330,164.962,330c44.073,0,85.507-17.163,116.671-48.328   c31.165-31.164,48.328-72.599,48.328-116.672S312.798,79.492,281.633,48.328z M260.42,260.46   C234.922,285.957,201.021,300,164.962,300c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919   C95,44.042,128.901,30,164.961,30s69.961,14.042,95.459,39.54c25.498,25.499,39.541,59.4,39.541,95.46   S285.918,234.961,260.42,260.46z" />
                                                                                                <path d="M254.961,150H74.962c-8.284,0-15,6.716-15,15s6.716,15,15,15h179.999c8.284,0,15-6.716,15-15S263.245,150,254.961,150z" />
                                                                                            </g>
                                                                                        </svg> </button>
                                                                                    <div class="count" data-count="0">x0</div><button type="button" class="plus">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#fff" height="800px" width="800px" version="1.1" id="Capa_1" viewBox="0 0 330 330" xml:space="preserve">
                                                                                            <g>
                                                                                                <path d="M281.672,48.328C250.508,17.163,209.073,0,164.999,0C120.927,0,79.492,17.163,48.328,48.328   c-64.333,64.334-64.333,169.011,0,233.345C79.492,312.837,120.927,330,165,330c44.073,0,85.508-17.163,116.672-48.328   C346.005,217.339,346.005,112.661,281.672,48.328z M260.46,260.46C234.961,285.957,201.06,300,165,300   c-36.06,0-69.961-14.043-95.46-39.54c-52.636-52.637-52.636-138.282,0-190.919C95.039,44.042,128.94,30,164.999,30   c36.06,0,69.961,14.042,95.46,39.54C313.095,122.177,313.095,207.823,260.46,260.46z" />
                                                                                                <path d="M254.999,150H180V75c0-8.284-6.716-15-15-15s-15,6.716-15,15v75H75c-8.284,0-15,6.716-15,15s6.716,15,15,15h75v75   c0,8.284,6.716,15,15,15s15-6.716,15-15v-75h74.999c8.284,0,15-6.716,15-15S263.284,150,254.999,150z" />
                                                                                            </g>
                                                                                        </svg>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div> <?php } ?>
                                                    </div> <button class="add-card"><?= $dodate_to_koshiku_za ?> <?php echo $products->get_price_html(); ?></button>
                                                </div>

                                            </div>
                                        </div> <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php
                        ++$posts_i;
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</section>
<?php if (!isset($_COOKIE['age'])) {
?> <div class="popap-age">
        <div class="overlay"></div>
        <div class="age-box">
            <h2>Підтвердіть свій вік 18+</h2>
            <button id="cook">Підтвердити</button>
        </div>
    </div>
    <script>
        jQuery(document).ready(function($) {
            $('.catalog-box#21 .select').on('click',function(){
                $('.popap-age').css('display','block')
            })
            $('#cook').on('click', function() {
                Cookies.set("age", 18);  $('.popap-age').css('display','none')
            })
        })
    </script>
<?php
}
?>
<div class="nof"> Товар додано до кошику</div>
<script>
    jQuery(document).ready(function($) {
        Cookies.remove('age')
        $('.product-popap button.add-card').on('click', function() {
            $add_box = [];
            $id = $(this).parent().parent().parent().parent().parent().parent().attr('data-id');
            $(this).parent().children().eq(0).children().eq(4).children().children().each(function(index) {
                if ($(this).attr('data-count') > 0) {
                    $dat_id = $(this).attr('data-id');
                    $add_box.push({
                        [$dat_id]: $(this).attr('data-count')
                    });
                }
            })
            $.ajax({
                url: '<?php echo admin_url("admin-ajax.php") ?>',
                type: 'POST',
                data: 'action=add_prod_home&id=' + $id + '&dop=' + JSON.stringify($add_box),
                success: function(data) {
                    console.log(data)
                    $('.minicart-popap').html(data);
                    $('.nof').toggleClass('active');
                    setTimeout(function() {
                        $('.nof').toggleClass('active');
                    }, 5000);
                }
            })
        })
    })
</script>
<?php
get_footer();
?>