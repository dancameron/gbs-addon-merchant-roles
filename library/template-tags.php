<?php 

function gb_authorized_user_merchant_role( $account_id = 0, $merchant_id = 0 ) {
	return GBS_Merchant_Role_Controller::get_user_role( $account_id, $merchant_id );
}

function gb_merchant_role_title( $role = '' ) {
	return GBS_Merchant_Role_Controller::get_role_title( $role );
}