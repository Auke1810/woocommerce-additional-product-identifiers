<?php
/*
Plugin Name: Woocommerce additional product identifier fields
Plugin URI: http://www.wpmarketingrobot.com
Description: This Plugin adds missing Product identifiers to Woocommerce products. It will add 4 important product identifiers Brand, MPN, UPC, EAN, GTIN to simple and variabel products required for sales channels
Author: WPmarketingrobot, Auke1810, Michel Jongbloed
Version: 1.4.0
Author URI: http://www.wpmarketingrobot.com
Source: http://www.remicorson.com/mastering-woocommerce-products-custom-fields/
*/

// Simple Product Hooks
// Display Fields
add_action( 'woocommerce_product_options_general_product_data', 'wpmr_custom_general_fields' );

// Save Fields
add_action( 'woocommerce_process_product_meta', 'wpmr_save_custom_general_fields' );

// Variable Product Hooks
// Display Fields
add_action( 'woocommerce_product_after_variable_attributes', 'wpmr_custom_variable_fields', 10, 3 );

// Save variation fields
add_action( 'woocommerce_save_product_variation', 'wpmr_save_custom_variable_fields', 10, 1 );

function wpmr_custom_general_fields()
{	
	global $woocommerce, $post;

	echo '<div id="wpmr_attr" class="options_group">';
	//ob_start();
	
	//Brand field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_wpmr_brand', 
			'label'       => __( 'Brand', 'woocommerce' ), 
			'desc_tip'    => 'true',
			//'type'      => 'text',
			'value' 	  =>  get_post_meta( $post->ID, '_wpmr_brand', true ),
			'description' => __( 'Enter the product Brand here.', 'woocommerce' )				
		)
	);

	echo '</div>';
	echo '<div id="wpmr_attr" class="options_group show_if_simple show_if_external">';
	

	//MPN Field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_wpmr_mpn', 
			'label'       => __( 'MPN', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the manufacturer product number', 'woocommerce' ),
		)
	);
	
	//niversal Product Code (UPC) Field
	woocommerce_wp_text_input( 
		array(	
			'id'          => '_wpmr_upc', 
			'label'       => __( 'UPC', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the Universal Product Code (UPC) here.', 'woocommerce' ),
		)
	);
	
	//International Article Number (EAN) Field
	woocommerce_wp_text_input(
		array(	
			'id'          => '_wpmr_ean', 
			'label'       => __( 'EAN', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the International Article Number (EAN) here.', 'woocommerce' ),
		)
	);
	
	//Global Trade Item Number (GTIN) Field
	woocommerce_wp_text_input(
		array(	
			'id'          => '_wpmr_gtin', 
			'label'       => __( 'GTIN', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter the product Global Trade Item Number (GTIN) here.', 'woocommerce' ),
		)
	);
	
	//Optimized product custom title Field
	woocommerce_wp_text_input(
		array(	
			'id'          => '_wpmr_optimized_title', 
			'label'       => __( 'Optimized title', 'woocommerce' ), 
			'desc_tip'    => 'true',
			'description' => __( 'Enter a optimized product title.', 'woocommerce' ),
		)
	);


	echo '</div>';	
}

/**
 * Save new fields for simple products
 *
*/
function wpmr_save_custom_general_fields($post_id)
{	
		  
	$woocommerce_brand 	= $_POST['_wpmr_brand'];
	$woocommerce_upc 	= $_POST['_wpmr_upc'];	  
	$woocommerce_mpn 	= $_POST['_wpmr_mpn'];
	$woocommerce_ean 	= $_POST['_wpmr_ean'];
	$woocommerce_gtin 	= $_POST['_wpmr_gtin'];
	$woocommerce_title 	= $_POST['_wpmr_optimized_title'];

	if(isset($woocommerce_brand))
		update_post_meta( $post_id, '_wpmr_brand', esc_attr($woocommerce_brand));

	if(isset($woocommerce_mpn))
		update_post_meta( $post_id, '_wpmr_mpn', esc_attr($woocommerce_mpn));
	
	if(isset($woocommerce_upc))
		update_post_meta( $post_id, '_wpmr_upc', esc_attr($woocommerce_upc));

	if(isset($woocommerce_ean))
		update_post_meta( $post_id, '_wpmr_ean', esc_attr($woocommerce_ean));

	if(isset($woocommerce_gtin))
		update_post_meta( $post_id, '_wpmr_gtin', esc_attr($woocommerce_gtin));

	if(isset($woocommerce_title))
		update_post_meta( $post_id, '_wpmr_optimized_title', esc_attr($woocommerce_title));

}

/**
 * Create new fields for variations
 *
*/
function wpmr_custom_variable_fields( $loop, $variation_id, $variation ) {
		
		// Variation Brand field
		woocommerce_wp_text_input( 
			array( 
				'id'       => '_wpmr_variable_brand['.$loop.']', 
				'label'       => __( '<br>Brand', 'woocommerce' ), 
				'placeholder' => 'Parent Brand',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the product Brand here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_brand', true),
				'wrapper_class' => 'form-row-full',
			)
		);
		
	
		// Variation MPN field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_wpmr_variable_mpn['.$loop.']', 
				'label'       => __( '<br>MPN', 'woocommerce' ),
				'placeholder' => 'Manufacturer Product Number',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_mpn', true),
				'wrapper_class' => 'form-row-first',
			)
		);
		// Variation UPC field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_wpmr_variable_upc['.$loop.']', 
				'label'       => __( '<br>UPC', 'woocommerce' ),
				'placeholder' => 'UPC',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the product UPC here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_upc', true),
				'wrapper_class' => 'form-row-last',
			)
		);
		
		// Variation EAN field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_wpmr_variable_ean['.$loop.']', 
				'label'       => __( '<br>EAN', 'woocommerce' ),
				'placeholder' => 'EAN',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the product EAN here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_ean', true),
				'wrapper_class' => 'form-row-first',
			)
		);
		
		// Variation GTIN field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_wpmr_variable_gtin['.$loop.']', 
				'label'       => __( '<br>GTIN', 'woocommerce' ),
				'placeholder' => 'GTIN',
				'desc_tip'    => 'true',
				'description' => __( 'Enter the product GTIN here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_gtin', true),
				'wrapper_class' => 'form-row-last',
			)
		);
		
		// Variation optimized title field
		woocommerce_wp_text_input( 
			array( 
				'id'          => '_wpmr_optimized_title['.$loop.']', 
				'label'       => __( '<br>Optimized title', 'woocommerce' ),
				'placeholder' => 'Opt title',
				'desc_tip'    => 'true',
				'description' => __( 'Enter a optimized product title here.', 'woocommerce' ),
				'value'       => get_post_meta($variation->ID, '_wpmr_optimized_title', true),
				'wrapper_class' => 'form-row-last',
			)
		);			

}

/**
 * Save new fields for variations
 *
*/
function wpmr_save_custom_variable_fields( $post_id ) {
	
	if (isset( $_POST['variable_sku'] ) ) {

		$variable_sku          = $_POST['variable_sku'];
		$variable_post_id      = $_POST['variable_post_id'];
		
		$max_loop = max( array_keys( $_POST['variable_post_id'] ) );

		for ( $i = 0; $i <= $max_loop; $i++ ) {

	        if ( ! isset( $variable_post_id[ $i ] ) ) {
	          continue;
	        }

		// Brand Field
		$_brand = $_POST['_wpmr_variable_brand'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_brand[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_brand', stripslashes( $_brand[$i]));				
			}
	
		
		// MPN Field
		$_mpn = $_POST['_wpmr_variable_mpn'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_mpn[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_mpn', stripslashes( $_mpn[$i]));
			}		
		
		// UPC Field
		$_upc = $_POST['_wpmr_variable_upc'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_upc[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_upc', stripslashes( $_upc[$i]));
			}		

		// EAN Field
		$_ean = $_POST['_wpmr_variable_ean'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_ean[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_ean', stripslashes( $_ean[$i]));
			}

		// GTIN Field
		$_gtin = $_POST['_wpmr_variable_gtin'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_gtin[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_gtin', stripslashes( $_gtin[$i]));
			}

		// Optimized title Field
		$_opttitle = $_POST['_wpmr_optimized_title'];
			$variation_id = (int) $variable_post_id[$i];
			if ( isset( $_opttitle[$i] ) ) {
				update_post_meta( $variation_id, '_wpmr_optimized_title', stripslashes( $_opttitle[$i]));
			}
		
		}
		
	}
}

/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */
function cf_search_join( $join ) {
    global $wpdb;

    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }

    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $pagenow, $wpdb;

    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

/**
 * Create shortcodes to retreive data
 * USE: [show_gtin]
 */
add_shortcode('show_gtin', 'show_gtin_function');
function show_gtin_function() {
     return get_post_meta( $post->ID, '_wpmr_gtin', true );;
}

add_shortcode('show_brand', 'show_brand_function');
function show_brand_function() {
     return get_post_meta( $post->ID, '_wpmr_brand', true );;
}

add_shortcode('show_upc', 'show_upc_function');
function show_upc_function() {
     return get_post_meta( $post->ID, '_wpmr_upc', true );;
}

add_shortcode('show_ean', 'show_upc_function');
function show_ean_function() {
     return get_post_meta( $post->ID, '_wpmr_ean', true );;
}

add_shortcode('show_mpn', 'show_upc_function');
function show_mpn_function() {
     return get_post_meta( $post->ID, '_wpmr_mpn', true );;
}
