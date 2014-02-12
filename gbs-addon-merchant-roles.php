<?php
/*
Plugin Name: Group Buying Site - Merchant Roles
Version: 1.0.2
Description: Provide a method to select a user's role when adding to the merchant. A basic set of filters are available.
Plugin URI: http://groupbuyingsite.com/
Author: Sprout Venture
Author URI: http://sproutventure.com/wordpress
Plugin Author: Dan Cameron
Contributors: Dan Cameron
Text Domain: group-buying
Domain Path: /lang
Text Domain: group-buying
*/

define ('GB_MERCHANT_ROLES_URL', plugins_url( '', __FILE__) );
define( 'GB_MERCHANT_ROLES_PATH', WP_PLUGIN_DIR . '/' . basename( dirname( __FILE__ ) ) );

// Load after all other plugins since we need to be compatible with groupbuyingsite
add_action( 'plugins_loaded', 'gb_load_merchant_roles' );
function gb_load_merchant_roles() {
	$gbs_min_version = '4.5';
	if ( class_exists( 'Group_Buying_Controller' ) && version_compare( Group_Buying::GB_VERSION, $gbs_min_version, '>=' ) ) {
		require_once 'classes/GBS_Merchant_Roles_Addon.php';

		// Hook this plugin into the GBS add-ons controller
		add_filter( 'gb_addons', array( 'GBS_Merchant_Roles_Addon', 'gb_addon' ) );
	}
}