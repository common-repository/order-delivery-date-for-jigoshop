<?php 
/*
Plugin Name: Order Delivery Date for Jigoshop (Lite version)
Plugin URI: http://www.tychesoftwares.com/store/free-plugins/order-delivery-date-for-jigoshop-lite
Description: This plugin allows customers to choose their preferred Order Delivery Date during checkout.
Author: Ashok Rane
Version: 1.0
Author URI: http://www.tychesoftwares.com/about
Contributor: Tyche Softwares, http://www.tychesoftwares.com/
*/
$wpefield_version = '1.0';

function jigo_mod_wp()
{
	if ( class_exists( 'jigoshop_checkout' ) )
	{
		jigoshop_checkout::instance()->billing_fields[] =   array(  'name'=>'e_deliverydate', 
																	'label' => __('Delivery Date', 'jigoshop'), 
																	'placeholder' => __('Delivery Date', 'jigoshop'), 
																	'class' => array('e_deliverydate') );
	}
}
add_action ( 'wp', 'jigo_mod_wp' );

//////////////////////////////////////////////////////////////////////////////////
//		Adds the script for the date picker before the checkout form.			//
//////////////////////////////////////////////////////////////////////////////////

function before_checkoutForm()
{
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css' , '', '', false);
    
    wp_enqueue_style( 'datepicker.css', plugins_url('/datepicker.css', __FILE__ ) , '', '', false);
	wp_enqueue_script(
		'initialize-datepicker.js',
		plugins_url('/initialize-datepicker.js', __FILE__),
		'',
		'',
		false
	);
}

add_action('before_checkout_form','before_checkoutForm');

add_action('jigoshop_new_order','store_order_date');

function store_order_date($postID){
	if(!empty($postID)){
		$orderData = get_post_meta($postID, $key = 'order_data', TRUE);

		$orderDataNew = $orderData;
		$orderDataNew['e_deliverydate'] = $_POST['e_deliverydate'];
		update_post_meta($postID, $key = 'order_data', $orderDataNew , $orderData);

		$orderData = get_post_meta($postID, $key = 'order_data', TRUE);
	}
}


add_action('admin_head', 'jigoshop_adminside_script');
function jigoshop_adminside_script(){
	$order_id = $_REQUEST['post'];
	$orderData = get_post_meta($order_id, $key = 'order_data', TRUE);

	print('<script type="text/javascript">
		jQuery("a[href=#order_customer_shipping_data]").live("click",function()
		{
			if (jQuery("#e_deliverydate").text() == "")
			{
				jQuery("#order_customer_shipping_data").append("<p class=\'form-field\' id=\'e_deliverydate\'><label for=\'excerpt\'>Delivery Date:</label>'.$orderData['e_deliverydate'].'</p>");
			}
		});
	</script>');
}

?>