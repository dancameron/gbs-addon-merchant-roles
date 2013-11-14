<?php 

/**
* 
*/
class GBS_Merchant_Roles_Page_Access extends GBS_Merchant_Roles_Controller {
	
	public static function init() {
		// Restrict page access
		add_action( 'parse_request', array( __CLASS__, 'restrict_page_access_by_role') );
	}

	/**
	 * Restricts pages based on the user's role.
	 *
	 * TODO: Factor a user assigned to multiple merchants.
	 * 
	 */
	public function restrict_page_access_by_role() {
		$account_id = Group_Buying_Account::get_account_id_for_user();
		$user_id = Group_Buying_Account::get_user_id_for_account( $account_id );
		$merchant_id = gb_account_merchant_id( $user_id );
		$users_roles = GBS_Merchant_Roles_Controller::get_user_roles( $account_id, $merchant_id );

		if ( empty( $users_roles ) ) {
			return;
		}
		
		/**
		 * switch through the merchant role. 
		 * 
		 * array_shift will respect the hierarchical order.
		 */
		switch ( array_shift( $users_roles ) ) {
			/**
			 * TODO: remove dependency on GBS_Merchant_Roles_Controller::$roles key values
			 */
			case 'coupon_admin':
				self::prevent_deal_submission_access();
				self::prevent_merchant_purchases_report_access();
				self::prevent_merchant_purchase_report_access();
				self::prevent_deal_editing();
				break;
			case 'sales_admin':
				self::prevent_deal_submission_access();
				self::prevent_deal_editing();
				break;
			case 'deal_admin':
				self::prevent_merchant_purchases_report_access();
				self::prevent_merchant_purchase_report_access();
				break;
			default:
				break;
		}

	}

	/**
	 * Prevent deal submission page access
	 * @return 
	 */
	public function prevent_deal_submission_access() {
		// Prevent deal submission access
		if ( gb_on_deal_submit_page() ) {
			gb_set_message('You are not allowed to submit any deals with your access level.');
			self::redirect_to_dash();
		}
	}

	public function prevent_merchant_purchases_report_access() {
		// Prevent merchant purchases report access
		if ( GB_Router_Utility::is_on_page( Group_Buying_Reports::REPORT_QUERY_VAR ) || GB_Router_Utility::is_on_page( Group_Buying_Reports::CSV_QUERY_VAR )) {
			if ( isset( $_GET['report'] ) && $_GET['report'] == 'merchant_purchases' ) {
				gb_set_message('You are not allowed to view this report with your access level.');
				self::redirect_to_dash();
			}
		}
	}

	public function prevent_merchant_purchase_report_access() {
		// Prevent merchant purchases report access
		if ( GB_Router_Utility::is_on_page( Group_Buying_Reports::REPORT_QUERY_VAR ) || GB_Router_Utility::is_on_page( Group_Buying_Reports::CSV_QUERY_VAR )) {
			if ( isset( $_GET['report'] ) && $_GET['report'] == 'merchant_purchase' ) {
				gb_set_message('You are not allowed to view this report with your access level.');
				self::redirect_to_dash();
			}
		}
	}

	public function prevent_deal_editing() {
		// Prevent merchant purchases report access
		if ( Group_Buying_Deals_Edit::is_edit_page() ) {
			gb_set_message('You are not allowed to edit this deal with your access level.');
			self::redirect_to_dash();
		}
	}


	/**
	 * Utility to redirect the user back to the account page.
	 * @return  
	 */
	private static function redirect_to_dash( $redirect = '' ) {
		if ( $redirect == '' ) {
			$redirect = gb_get_merchant_account_url();
		}
		wp_redirect( add_query_arg( array( 'merchant_role' => 'access_denied' ), $redirect ) );
		exit;
	}
	
}