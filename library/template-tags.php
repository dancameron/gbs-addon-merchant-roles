<?php 

function gb_is_user_merchant_role( $roles = array(), $account_id = 0, $merchant_id = 0 ) {
	if ( !is_array( $roles ) ) {
		$roles = array( $roles );
	}
	$users_roles = gb_authorized_user_merchant_roles( $account_id, $merchant_id );
	return count( array_intersect( $users_roles, $roles ) );
}

function gb_authorized_user_merchant_role( $account_id = 0, $merchant_id = 0 ) {
	$roles = gb_authorized_user_merchant_roles( $account_id, $merchant_id );
	return array_shift( $roles );
}

function gb_authorized_user_merchant_roles( $account_id = 0, $merchant_id = 0 ) {
	return GBS_Merchant_Roles_Controller::get_user_roles( $account_id, $merchant_id );
}

function gb_merchant_role_title( $role = '' ) {
	return GBS_Merchant_Roles_Controller::get_role_title( $role );
}

function gb_list_users_roles( $account_id = 0, $merchant_id = 0, $deliminator = ', ' ) {
	$string = '';
	$roles = GBS_Merchant_Roles_Controller::get_user_roles( $account_id, $merchant_id );
	if ( !empty( $roles ) ) {
		$i = 1;
		foreach ( $roles as $role ) {
			$string .= gb_merchant_role_title( $role );
			if ( count( $roles ) > $i ) {
				$string .= $deliminator;
			}
			$i++;
		}
	}
	return $string;
}