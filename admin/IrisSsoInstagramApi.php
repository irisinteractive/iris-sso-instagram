<?php

namespace IrisSsoInstagram\admin;

use IrisSsoInstagram\includes\IrisSsoInstagramUtils;
use WP_REST_Request;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.iris-interactive.fr
 * @since      1.0.0
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/admin
 */


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/admin
 * @author     IRIS Interactive <dev@iris-interactive.fr>
 */
class IrisSsoInstagramApi {

	public function __construct() {
		// DO NOTHING.
	}

	public function init_endpoint() {
		register_rest_route( 'iris-sso-instagram/v1', '/auth/', array(
			'methods' => [ 'GET' ],
			'callback' => array(
				$this,
				'get_auth_code'
			),
			'args' => array(
				'code'
			)
		) );
	}

	public function get_auth_code( WP_REST_Request $request ) {
		if( !empty( $request->get_param( 'code' ) ) ) {
			update_option( IRIS_SSO_INSTAGRAM_CODE, $request->get_param( 'code' ) );
			IrisSsoInstagramUtils::generate_token();
			wp_safe_redirect( admin_url( 'admin.php?page=iris-sso-instagram-settings' ) );
		}
	}

}