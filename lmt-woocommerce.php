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
        $args['min_value']      = 0;    // Minimum value
        $args['step']           = 1;    // Quantity steps
        return $args;
}

add_filter( 'woocommerce_available_variation', 'jk_woocommerce_available_variation' ); // Variations
function jk_woocommerce_available_variation( $args ) {
        $args['max_qty'] = 80;          // Maximum value (variations)
        $args['min_qty'] = 1;           // Minimum value (variations)
        return $args;
}

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

add_filter('woocommerce_package_rates', 'wf_sort_shipping_methods', 10, 2);

function wf_sort_shipping_methods($available_shipping_methods, $package)
{
	// Arrange shipping methods as per your requirement
	$sort_order	= array(
		'wf_shipping_ups'	=>	array(),
		'wf_shipping_usps'	=>	array(),
		'free_shipping'		=>	array(),
		'local_pickup'		=>	array(),
		'legacy_flat_rate'	=>	array(),		
	);
	
	// unsetting all methods that needs to be sorted
	foreach($available_shipping_methods as $carrier_id => $carrier){
		$carrier_name	=	current(explode(":",$carrier_id));
		if(array_key_exists($carrier_name,$sort_order)){
			$sort_order[$carrier_name][$carrier_id]	=		$available_shipping_methods[$carrier_id];
			unset($available_shipping_methods[$carrier_id]);
		}
	}
	
	// adding methods again according to sort order array
	foreach($sort_order as $carriers){
		$available_shipping_methods	=	array_merge($available_shipping_methods,$carriers);
	}
	return $available_shipping_methods;
}

?>