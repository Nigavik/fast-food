<?php
/*
 * Template name: Payment 
 *  * Template post type: page
 */
global $query;
get_header();
$id = get_the_ID();

//$top_slider = get_field('slider', $id);

?>
        <section class="content">
            <div class="container">
                <nav>
               
					<?php
			
						wp_nav_menu(
							array(
                                'container'       => false,
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					

					?>

                </nav>
                <div class="content-box">
                    <div class="breadcrumbs">
                        <a href="<?php echo home_url();?>">Головна</a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="Field_rightIcon__Pq4Ip"
                            style="color: rgb(144, 144, 144); transform: rotate(-90deg);">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m6 9 6 6 6-6"></path>
                        </svg>
                        <span><?php the_title(); ?></span>
                    </div>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                  
                </div>
            </div>
        </section>
<?php

get_footer();
?>