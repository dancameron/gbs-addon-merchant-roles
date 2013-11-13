<?php 

/**
* 
*/
class GBS_Merchant_Role_Controller {
	const MERCHANT_META_PREFIX = '_merchant_role__';

	public static $roles = array(
			'merchant_admin' => 'Merchant Admin',
			'coupon_admin' => 'Coupon Admin',
			'sales_admin' => 'Sales Admin',
			'deal_admin' => 'Deal Admin'
		); 

	public static function init() {
		# code...
	}

	public static function get_roles() {
		return self::$roles;
	}

	public static function get_role_title( $key ) {
		return self::$roles[$key];
	}

	public function set_user_role( $role, $account_id = 0, $merchant_id = 0 ) {
		if ( !array_key_exists( $role, self::$roles ) ) {
			return FALSE;
		}
		if ( !$account_id ) {
			$account_id = Group_Buying_Account::get_account_id_for_user();
		} elseif ( get_post_type( $account_id ) != Group_Buying_Account::POST_TYPE ) {
			$user_id = $account_id; // Possible a user_id is being passed instead.
			$account_id = Group_Buying_Account::get_account_id_for_user( $user_id );
			// Try this again with a new account id.
			return self::set_user_role( $role, $account_id, $merchant_id );
		}
		if ( !$merchant_id ) {
			$user_id = Group_Buying_Account::get_user_id_for_account( $account_id );
			$merchant_id = gb_account_merchant_id( $user_id );
		}
		update_post_meta( $account_id, self::MERCHANT_META_PREFIX.$merchant_id, $role );
		return $role;
	}

	public function get_user_role( $account_id = 0, $merchant_id = 0 ) {
		if ( !$account_id ) {
			$account_id = Group_Buying_Account::get_account_id_for_user();
		} elseif ( get_post_type( $account_id ) != Group_Buying_Account::POST_TYPE ) {
			$user_id = $account_id; // Possible a user_id is being passed instead.
			$account_id = Group_Buying_Account::get_account_id_for_user( $user_id );
			// Try this again with a new account id.
			return self::get_user_role( $account_id, $merchant_id );
		}
		if ( !$merchant_id ) {
			$user_id = Group_Buying_Account::get_user_id_for_account( $account_id );
			$merchant_id = gb_account_merchant_id( $user_id );
		}
		return get_post_meta( $account_id, self::MERCHANT_META_PREFIX.$merchant_id, TRUE );
	}
	
}