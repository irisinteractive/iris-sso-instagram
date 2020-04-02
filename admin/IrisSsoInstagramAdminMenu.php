<?php

namespace IrisSsoInstagram\admin;

use IrisSsoInstagram\includes\IrisSsoInstagramException;
use IrisSsoInstagram\includes\IrisSsoInstagramFactory;
use IrisSsoInstagram\includes\IrisSsoInstagramUtils;

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
class IrisSsoInstagramAdminMenu
{
	public function __construct() {
		// DO NOTHING.
	}

	public function init_menu() {
		add_menu_page(
			'SSO Instagram',
			'SSO Instagram',
			'administrator',
			'iris-sso-instagram',
			function(){},
			'dashicons-instagram',
		80
		);
		add_submenu_page(
			'iris-sso-instagram',
			'Settings',
			'Settings',
			'administrator',
			'iris-sso-instagram-settings',
			[$this, 'render_iris_sso_instagram_settings_page'],
			0
		);
		add_submenu_page(
			'iris-sso-instagram',
			'Social wall',
			'Social wall',
			'administrator',
			'iris-sso-instagram-social-wall',
			[$this, 'render_iris_sso_instagram_social_walls_page'],
			1
		);
		remove_submenu_page(
			'iris-sso-instagram',
			'iris-sso-instagram'
		);
	}

	public function render_iris_sso_instagram_settings_page() {
		$this->listen_post_settings();
		try {
			$tplz = IrisSsoInstagramFactory::get_dependence( 'templatizer' );
			$tplz::get_iris_sso_instagram_settings_page();
		} catch(IrisSsoInstagramException $iris_sso_instagram_exception) {
			echo $iris_sso_instagram_exception->getIrisMessage();
		}
	}

	public function render_iris_sso_instagram_social_walls_page() {
		try {
			$tplz = IrisSsoInstagramFactory::get_dependence( 'templatizer' );
			$tplz::get_iris_sso_instagram_social_walls_page();
		} catch(IrisSsoInstagramException $iris_sso_instagram_exception) {
			echo $iris_sso_instagram_exception->getIrisMessage();
		}
	}

	private function listen_post_settings() {
		if( isset( $_POST ) && !empty( $_POST ) ) {
			foreach( $_POST as $key => $value ) {
				if( isset( $_POST['submit_metas'] ) ) {
					switch( $key ) {
						case 'iris_sso_instagram_client_id':
						case 'iris_sso_instagram_client_secret':
							update_option( $key, $value );
							break;

						default:
							// DO NOTING
					}
				} else if( isset( $_POST['refresh_token'] ) ) {
					IrisSsoInstagramUtils::refresh_token();
				}
			}
		}
	}
}