<?php
   /*
   Plugin Name: LMT WooCommerce
   Plugin URI: https://lmt.ca
   description: A plugin for WooCommerce.
   Version: 0.1
   Author: jordantrask
   Author URI: https://lmt.ca
   License: GPL2
   */

/**
 * Adjust the quantity input values
 */
add_filter( 'woocommerce_quantity_input_args', 'jk_woocommerce_quantity_input_args', 10, 2 ); // Simple products

function jk_woocommerce_quantity_input_args( $args, $product ) {
        if ( is_singular( 'product' ) ) {
                $args['input_value']    = 1;    // Starting value (we only want to affect product pages, not cart)
        }
        $args['max_value']      = 80;   // Maximum value
        $args['min_value']      = 1;    // Minimum value
        $args['step']           = 1;    // Quantity steps
        return $args;
}

add_filter( 'woocommerce_available_variation', 'jk_woocommerce_available_variation' ); // Variations

function jk_woocommerce_available_variation( $args ) {
        $args['max_qty'] = 80;          // Maximum value (variations)
        $args['min_qty'] = 1;           // Minimum value (variations)
        return $args;
}

/* Move the Coupon Code field to */
add_action( 'woocommerce_review_order_before_payment', 'woocommerce_checkout_coupon_form', 10 );

/* Enable Hook Debugging
$debug_tags = array();
add_action( 'all', function ( $tag ) {
    global $debug_tags;
    if ( in_array( $tag, $debug_tags ) ) {
        return;
    }
    echo "<pre>" . $tag . "</pre>";
    $debug_tags[] = $tag;
} );
*/

?>