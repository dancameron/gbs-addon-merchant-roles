<?php


class GBS_Merchant_Roles_Addon {
	
	public static function init() {

		// Controller
		require_once 'GBS_Merchant_Roles_Controller.php';
		GBS_Merchant_Roles_Controller::init();

		// Administration
		require_once 'GBS_Merchant_Roles_Admin.php';
		GBS_Merchant_Roles_Admin::init();

		// Report Filtering
		require_once 'GBS_Merchant_Roles_Reports.php';
		GBS_Merchant_Roles_Reports::init();

		// Front-end Filtering
		require_once 'GBS_Merchant_Roles_Page_Access.php';
		GBS_Merchant_Roles_Page_Access::init();

		// Template tags
		require_once GB_MERCHANT_ROLES_PATH . '/library/template-tags.php';
	}

	public static function gb_addon( $addons ) {
		$addons['merchant_roles'] = array(
			'label' => gb__( 'Merchant Roles' ),
			'description' => gb__( 'Provide a method to select a user role when adding to the merchant. A basic set of filters are available.' ),
			'files' => array(),
			'callbacks' => array(
				array( __CLASS__, 'init' ),
			),
			//'url' => '',
			'support_url' => 'http://groupbuyingsite.com/forum/forumdisplay.php?41-GBS-marketplace-Add-on-Support'

		);
		return $addons;
	}
}
