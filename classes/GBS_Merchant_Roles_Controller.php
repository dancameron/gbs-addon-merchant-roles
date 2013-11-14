<?php 

/**
* 
*/
class GBS_Merchant_Roles_Controller {
	const MERCHANT_META_PREFIX = '_merchant_role__';

	public static $roles = array(
			'merchant_admin' => 'Merchant Admin (full access)',
			'coupon_admin' => 'Coupon Admin',
			'sales_admin' => 'Sales Admin',
			'deal_admin' => 'Deal Admin'
		); 

	public static function init() {
		# code...
	}

	public static function get_roles() {
		return apply_filters( 'gb_merchant_roles', self::$roles );
	}

	public static function get_role_title( $key ) {
		$roles = self::get_roles();
		return $roles[$key];
	}

	public function set_user_roles( $roles, $account_id = 0, $merchant_id = 0 ) {
		if ( !is_array( $roles ) ) {
			$roles = array( $roles );
		}
		$roles = array_intersect( $roles, array_keys( self::get_roles() ) );
		if ( empty( $roles ) ) {
			return FALSE;
		}
		if ( !$account_id ) {
			$account_id = Group_Buying_Account::get_account_id_for_user();
		} elseif ( get_post_type( $account_id ) != Group_Buying_Account::POST_TYPE ) {
			$user_id = $account_id; // Possible a user_id is being passed instead.
			$account_id = Group_Buying_Account::get_account_id_for_user( $user_id );
			// Try this again with a new account id.
			return self::set_user_roles( $roles, $account_id, $merchant_id );
		}
		if ( !$merchant_id ) {
			$user_id = Group_Buying_Account::get_user_id_for_account( $account_id );
			$merchant_id = gb_account_merchant_id( $user_id );
		}
		update_post_meta( $account_id, self::MERCHANT_META_PREFIX.$merchant_id, $roles );
		return $roles;
	}

	public function get_user_roles( $account_id = 0, $merchant_id = 0 ) {
		if ( !$account_id ) {
			$account_id = Group_Buying_Account::get_account_id_for_user();
		} elseif ( get_post_type( $account_id ) != Group_Buying_Account::POST_TYPE ) {
			$user_id = $account_id; // Possible a user_id is being passed instead.
			$account_id = Group_Buying_Account::get_account_id_for_user( $user_id );
			// Try this again with a new account id.
			return self::get_user_roles( $account_id, $merchant_id );
		}
		if ( !$merchant_id ) {
			$user_id = Group_Buying_Account::get_user_id_for_account( $account_id );
			$merchant_id = gb_account_merchant_id( $user_id );
		}
		$roles = get_post_meta( $account_id, self::MERCHANT_META_PREFIX.$merchant_id, TRUE );
		if ( !is_array( $roles ) ) {
			$roles = array();
		}
		return $roles;
	}
	
}