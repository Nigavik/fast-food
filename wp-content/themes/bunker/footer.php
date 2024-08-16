<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package bunker-food
 */
$contact_information =  get_field('contact_information', 'term_28');
$contact_information_box =  get_field('contact_information_box', 'term_28');
$mi_in_social_media =  get_field('mi_in_social_media', 'term_28');
$mi_in_social_media_box =  get_field('mi_in_social_media_box', 'term_28');
$address_box = get_field('address_box', 'term_28');
$cooperation = get_field('cooperation', 'term_28');
?>
</main>
<footer>
    <div class="container">
        <div class="left">
            <?php the_custom_logo(); ?>
            <div class="footer-box">
                <h3><?= $mi_in_social_media; ?></h3>
                <div class="social-box">
                    <?php 
                    foreach ($mi_in_social_media_box as $mi_in_social_media_boxs){
                        ?>
                            <a href="<?=  $mi_in_social_media_boxs['link']; ?>" class="social-link   <?=  $mi_in_social_media_boxs['class_css']; ?>" aria-label="<?=  $mi_in_social_media_boxs['class_css']; ?>">
                                <?=  $mi_in_social_media_boxs['svg1']; ?>
                          </a>
                        <?php
                    }
                    ?>
                </div>
                <span class="map"><?= $address_box['svg'], $address_box['address']; ?></span>
            </div>
            <span class="cop"><?= $cooperation; ?></span>
        </div>
        <div class="right">
            <div class="footer-box">
                <h3>Каталог</h3>
                <ul>
                    <?php
                    wp_nav_menu(
                        array(
                            'container'       => false,
                            'theme_location' => 'menu-2',
                            'menu_id'        => 'footer_left',
                            'items_wrap'      => '%3$s',
                            'walker'=> new Bunker_Walker_Nav_Menu()
                        )
                    );
                    ?>
                </ul>
            </div>
            <div class="footer-box">
                <h3>Клієнтам</h3>
                <ul>
                    <?php
                    wp_nav_menu(
                        array(
                            'container'       => false,
                            'theme_location' => 'menu-3',
                            'menu_id'        => 'footer_center',
                            'items_wrap'      => '%3$s',
                        )
                    );
                    ?>
                    <li><button class="popap call-me">Передзвонити вам?</button></li>
                </ul>
            </div>
            <div class="footer-box tel">
                <h3><?= $contact_information; ?></h3>
                <ul>
                    <?php
                    foreach ($contact_information_box as $contact_info) { ?>
                        <li>
                            <a href="<?php if (isset($contact_info['dop'])) {
                                            echo $contact_info['dop'];
                                        } ?><?= $contact_info['number']; ?>" class="<?= $contact_info['class_css']; ?>"><?= $contact_info['svg'];
                                                                                                                        if (!isset($contact_info['number2'])) {
                                                                                                                            echo $contact_info['number'];
                                                                                                                        } else {
                                                                                                                            echo $contact_info['number2'];
                                                                                                                        } ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="footer-box soc">
                <h3><?= $mi_in_social_media; ?></h3>
                <div class="social-box">
                      <?php 
                    foreach ($mi_in_social_media_box as $mi_in_social_media_boxs){
                        ?>
                            <a href="<?=  $mi_in_social_media_boxs['link']; ?>" class="social-link   <?=  $mi_in_social_media_boxs['class_css']; ?>" aria-label="<?=  $mi_in_social_media_boxs['class_css']; ?>">
                                <?=  $mi_in_social_media_boxs['svg2']; ?>
                          </a>
                        <?php
                    }
                    ?>
                </div>
                <span class="map"><?= $address_box['svg'], $address_box['address']; ?></span>
            </div>
        </div>
    </div>
</footer>
<script>
    jQuery(function($) {
        $('body').on('click', 'button.plus, button.minus', function() {
            var qty = $(this).parent().find('input'),
                val = parseInt(qty.val()),
                min = parseInt(qty.attr('min')),
                max = parseInt(qty.attr('max')),
                step = parseInt(qty.attr('step'));

            if ($(this).is('.plus')) {
                if (max && (max <= val)) {
                    qty.val(max);
                } else {
                    qty.val(val + step);
                }
            } else {
                if (min && (min >= val)) {
                    qty.val(min);
                } else if (val > 0) {
                    qty.val(val - step);
                }
            }
            qty.trigger("change");
        });
        $(document).on('change', 'input.qty', function() {
            var $thisbutton = $(this);
            var item_hash = $(this).attr('name').replace(/cart\[([\w]+)\]\[qty\]/g, "$1");
            var item_quantity = $(this).val();
            var currentVal = parseFloat(item_quantity);
            $.ajax({
                type: 'POST',
                url: cart_qty_ajax.ajax_url,
                data: {
                    action: 'my_cart_qty',
                    hash: item_hash,
                    quantity: currentVal
                },
                success: function(response) {
                    $('.minicart-popap').html(response); //jQuery(document.body).trigger('update_checkout');
                }
            });
        });
        $('form#send_phone').submit(function (e) {
    e.preventDefault();
    var data =  $('form').serializeArray();
    var form = $(this);

    $.ajax({
        type: "POST",
        url: '<?php echo admin_url("admin-ajax.php") ?>',
        data: data,
         success: function(data) {
                  $(form).parent().children().eq(0).text('Дякуємо ми скоро вам передзвонимо');
                        $(form).parent().children().eq(2).remove();
                     $(form).remove();
         }
        });       });
    });
</script>
<?php wp_footer(); ?>
</body>
</html>