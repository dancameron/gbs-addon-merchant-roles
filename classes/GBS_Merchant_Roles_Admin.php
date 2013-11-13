<?php 

/**
* 
*/
class GBS_Merchant_Roles_Admin extends Group_Buying_Controller {
	const OPTION_NAME = 'authorized_user_role';

	public static function init() {
		// Add new options
		add_filter( 'group_buying_template_meta_boxes/merchant-authorized-users.php', array( __CLASS__, 'replace_merchant_authorized_users_metabox'), 10, 1 );
		add_filter( 'load_view_args_meta_boxes/merchant-authorized-users.php', array( __CLASS__, 'filter_merchant_authorized_users_metabox_args'), 10, 1 );

		// Save post
		add_action( 'save_post', array( get_class(), 'maybe_save_user_role' ), 10, 2 );
	}

	public function replace_merchant_authorized_users_metabox( $file ) {
		return GB_MERCHANT_ROLES_PATH . '/views/merchant-authorized-users.php';
	}

	public function filter_merchant_authorized_users_metabox_args( $args ) {
		$args['merchant_user_role_option_name'] = self::OPTION_NAME;
		$args['merchant_user_roles'] = GBS_Merchant_Role_Controller::get_roles();
		return $args;
	}

	public function maybe_save_user_role( $post_id, $post ) {
		// only continue if it's a merchant post
		if ( $post->post_type != Group_Buying_Merchant::POST_TYPE ) {
			return;
		}
		if ( isset( $_POST['authorized_user'] ) && ( $_POST['authorized_user'] != '' ) ) {
			if ( isset( $_POST[self::OPTION_NAME] ) && $_POST[self::OPTION_NAME] != '' ) {
				$authorized_user_id = $_POST['authorized_user'];
				$account_id = Group_Buying_Account::get_account_id_for_user( $authorized_user_id );
				$role = $_POST[self::OPTION_NAME];
				GBS_Merchant_Role_Controller::set_user_role( $role, $account_id, $post_id );
			}
		}
	}
	
}