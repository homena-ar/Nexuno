<header class="site-header">
	<div class="site-branding">
		<?php growla_the_logo(); ?>
	</div><!-- .site-branding -->

	<nav class="default-navigation">
		<div class="navigation-slider-wrapper">
        <?php
			// desktop menu
            if ( has_nav_menu( 'default-menu' ) )
                wp_nav_menu(
                    array(
                        'theme_location' => 'default-menu',
                        'menu_class' => 'navigation-menu desktop swiper-wrapper',
                        'container_class' => 'navigation-menu-wrapper desktop-wrapper swiper-container'
                    )
                );
		?>
        </div>

		<div class="hamburger direction-left">
            <div class="hamburger-wrapper">
                <div class="hamburger-icon">
                    <svg 
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        width="27px" height="11px">
                        <path fill-rule="evenodd"  fill="rgb(255, 255, 255)"
                        d="M-0.003,8.932 L26.997,8.932 L26.997,10.932 L-0.003,10.932 L-0.003,8.932 ZM26.997,0.932 L26.997,2.932 L-0.003,2.932 L-0.003,0.932 L26.997,0.932 Z"/>
                    </svg>
                </div>
                <div class="hamburger-content">
                    <div class="hamburger-content-wrapper">
                        <!-- header - start -->
                        <div class="hamburger-content-header">
                            <div class="logo">
								<?php growla_the_logo(); ?>
                            </div>
                            <div class="hamburger-close">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="22px" height="22px"><path fill-rule="evenodd" fill="rgb(250, 212, 0)" d="M1.831,0.367 L21.648,20.184 L20.233,21.599 L0.416,1.782 L1.831,0.367 ZM20.208,0.411 L21.623,1.827 L1.806,21.643 L0.391,20.228 L20.208,0.411 Z"></path></svg>
                            </div>
                        </div>
                        <!-- header - end -->
                        <!-- main - start -->
                        <div class="hamburger-content-main">
                            <?php
                                if ( has_nav_menu( 'default-menu' ) )
                                    wp_nav_menu(
                                        array(
                                            'theme_location' => 'default-menu',
                                            'menu_class' => 'navigation-menu mobile',
                                            'container_class' => 'navigation-menu-wrapper mobile-wrapper'
                                        )
                                    );
                            ?>
                        </div>
                        <!-- main - end -->
                    </div>

                </div>
            </div>
        </div>

	</nav><!-- #site-navigation -->
</header>