<?php
/*
Plugin Name: Group Buying Site - Groupon Importer
Version: 1.0.1
Description: Import deals from Groupon
Plugin URI: http://groupbuyingsite.com/
Author: GroupBuyingSite.com
Author URI: http://groupbuyingsite.com/features
Plugin Author: Dan Cameron
Plugin Author URI: http://sproutventure.com/
Contributors: Dan Cameron, Jonathan Brinley
Text Domain: group-buying
*/


/**
 * Load all the plugin files and initialize appropriately
 *
 * @return void
 */
if ( !function_exists('gbs_groupon_importer_load') ) { // play nice
	function gbs_groupon_importer_load( $addons ) {
		$gbs_min_version = '4.5';
		if ( version_compare( Group_Buying::GB_VERSION, $gbs_min_version, '>=' ) ) {
			if ( isset($addons['gbs_importer_framework']) ) {
				$addons['gbs_importer_groupon'] = array(
					'label' => __( 'API Importer - Groupon' ),
					'description' => __( 'Import deals from Groupon' ),
					'files' => array(
						dirname(__FILE__).'/GBS_Groupon_Admin.php',
					),
					'callbacks' => array(
						array( 'GBS_Groupon_Admin', 'init' ),
					),
				);
			}
			return $addons;
		}
	}

	add_filter('gb_addons', 'gbs_groupon_importer_load', 10, 1);
}