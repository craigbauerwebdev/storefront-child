<?php

register_nav_menus(
	apply_filters(
		'storefront_register_nav_menus', array(
			'top'  => __( 'Top Menu', 'storefront' ),
			'mobile' => __( 'Mobile Menu', 'storefront' )
		)
	)
);

add_action( 'get_header', 'remove_storefront_sidebar' );
function remove_storefront_sidebar() {
	if ( is_woocommerce() || is_checkout() ) {
		remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
	}
}

/* Edit The header container */
if ( ! function_exists( 'storefront_header_container' ) ) {
	function storefront_header_container() {
		echo '
			<div class="top-bar">
				<div class="top-ber-inner" style="padding: 1px 15px; letter-spacing: 2px; color: #fff; font-size: 1.05em;">
					<span class="phone-number">(845)547-2427</span>
					<span class="address" style="float: right;">83 Lafayette Ave, Suffern, NY</span>
				</div>
			</div>
			<div class="col-full-header clearfix" style="position: relative;">';
	}
}

if ( ! function_exists( 'storefront_header_container_close' ) ) {
	/**
	 * The header container close
	 */
	function storefront_header_container_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'storefront_product_search' ) ) {
	function storefront_product_search() {
		if ( storefront_is_woocommerce_activated() ) {
			?>
			<div class="site-search">
				<?php //the_widget( 'WC_Widget_Product_Search', 'title=' );
				wp_nav_menu(
					array(
						'theme_location'  => 'top',
						'container_class' => 'top-navigation',
					)
				); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'storefront_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_footer_widgets() {
		echo '<div id="socials">
			<a href="https://www.instagram.com/mias_kitchen_suffern/" target="_blank">
				<img src="http://miaskitchensuffern.com/wp-content/themes/mias_theme/images/social/instagram.png">
			</a>
			<a href="https://www.facebook.com/miaskitchensuffern/" target="_blank">
				<img src="http://miaskitchensuffern.com/wp-content/themes/mias_theme/images/social/facebook.png">
			</a>
		</div>';
		
		$rows    = intval( apply_filters( 'storefront_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'storefront_footer_widget_columns', 1 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :

			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . esc_attr( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) :
				?>
				<div class=<?php echo '"footer-widgets row-' . esc_attr( $row ) . ' col-' . esc_attr( $columns ) . ' fix"'; ?>>
				<?php
				for ( $column = 1; $column <= $columns; $column++ ) :
					$footer_n = $column + $regions * ( $row - 1 );

					if ( is_active_sidebar( 'footer-' . esc_attr( $footer_n ) ) ) :
						?>
					<div class="block footer-widget-<?php echo esc_attr( $column ); ?>">
						<?php dynamic_sidebar( 'footer-' . esc_attr( $footer_n ) ); ?>
					</div>
						<?php
					endif;
				endfor;
				?>
			</div><!-- .footer-widgets.row-<?php echo esc_attr( $row ); ?> -->
				<?php
				unset( $columns );
			endif;
		endfor;
	} 	
}

if ( ! function_exists( 'storefront_credit' ) ) {
	/**
	 * Display the theme credit
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_credit() {
		$links_output = '';
		if ( apply_filters( 'storefront_credit_link', true ) ) {
			if ( storefront_is_woocommerce_activated() ) {
				$links_output .= '<a href="https://woocommerce.com" target="_blank" title="' . esc_attr__( 'WooCommerce - The Best eCommerce Platform for WordPress', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront &amp; WooCommerce', 'storefront' ) . '</a>.';
			} else {
				$links_output .= '<a href="https://woocommerce.com/storefront/" target="_blank" title="' . esc_attr__( 'Storefront -  The perfect platform for your next WooCommerce project.', 'storefront' ) . '" rel="noreferrer">' . esc_html__( 'Built with Storefront', 'storefront' ) . '</a>.';
			}
		}
		if ( apply_filters( 'storefront_privacy_policy_link', true ) && function_exists( 'the_privacy_policy_link' ) ) {
			$separator = '<span role="separator" aria-hidden="true"></span>';
			$links_output = get_the_privacy_policy_link( '', ( ! empty( $links_output ) ? $separator : '' ) ) . $links_output;
		}
		$links_output = apply_filters( 'storefront_credit_links_output', $links_output );
		?>
		<div class="site-info">
			<?php echo esc_html( apply_filters( 'storefront_copyright_text', $content = '&copy; ' . get_bloginfo( 'name' ) . ' ' . date( 'Y' ) ) ); ?>	
		</div><!-- .site-info -->
		<?php

		echo '<div class="mobile-menu-wrap">';
			echo '<div class="mobile-menu-inner">';
					wp_nav_menu(
						array(
							'theme_location'  => 'mobile',
							'container_class' => 'mobile-navigation',
						)
					); 
				echo '<div class="close-menu">×</div>';
			echo '</div>';
		echo '</div>';
	}
}

if ( ! function_exists( 'storefront_primary_navigation' ) ) {
	/**
	 * Display Primary Navigation
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function storefront_primary_navigation() {
		?>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
		<button class="menu-toggle-custom"><span>☰</span></button>

			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'primary',
						'container_class' => 'primary-navigation',
					)
				);
			?>
		</nav>
		<?php
	}
}
/* Remove Product main editor  */
function remove_product_editor() {
  remove_post_type_support( 'product', 'editor' );
}
add_action( 'init', 'remove_product_editor' );

/**
 * Add a custom product data tab
 */
add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['ingredients'] = array(
		'title' 	=> __( 'Ingredients', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'woo_new_product_tab_content'
	);

	return $tabs;

}
function woo_new_product_tab_content() {

	// The new tab content

	echo '<h2>Ingredients</h2>';
	echo '<p>Here\'s your new product tab.</p>';
	
}
//remove_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );

/**
 * Remove product data tabs
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

    unset( $tabs['description'] );
	unset( $tabs['ingredients'] );
	unset( $tabs['additional_information'] );

    return $tabs;
}

/* New Script */
function customJS(){
	if ( ! is_admin() ) {
		global $storefront_version;
		wp_enqueue_script( 'storefront-mobile-navigation', get_stylesheet_directory_uri() . '/assets/js/custom-child.js', array(), $storefront_version, true );
	}
}

add_action( 'wp_enqueue_scripts', 'customJS' );

/**
 * Minimum order amount for checkout
 */
add_action( 'woocommerce_checkout_process', 'wc_minimum_order_amount' );
add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );
 
function wc_minimum_order_amount() {
    // Set this variable to specify a minimum order value
    $minimum = 30;
    if ( WC()->cart->total < $minimum ) {
        if( is_cart() ) {
            wc_print_notice( 
                sprintf( 'Your current order total is %s — you must have an order with a minimum of %s to place your order ' , 
                    wc_price( WC()->cart->total ), 
                    wc_price( $minimum )
                ), 'error' 
            );
        } else {
            wc_add_notice( 
                sprintf( 'Your current order total is %s — you must have an order with a minimum of %s to place your order' , 
                    wc_price( WC()->cart->total ), 
                    wc_price( $minimum )
                ), 'error' 
            );
        }
    }
}

/* Describe what the code snippet does so you can remember later on */
add_action('wp_head', 'add_analytics');
function add_analytics(){ ?>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-173623056-2"></script>
	<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-173623056-2');
	</script>
<?php }; 