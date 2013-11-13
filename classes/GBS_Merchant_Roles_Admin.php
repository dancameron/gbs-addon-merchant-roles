<?php 

/**
* 
*/
class GBS_Merchant_Roles_Admin extends Group_Buying_Controller {
	
	public static function init() {
		// Add new options
		add_filter( 'group_buying_template_meta_boxes/merchant-authorized-users.php', array( __CLASS__, 'replace_merchant_authorized_users_metabox'), 10, 1 );
		add_filter( 'load_view_args_meta_boxes/merchant-authorized-users.php', array( __CLASS__, 'filter_merchant_authorized_users_metabox_args'), 10, 1 );

	}
	
}