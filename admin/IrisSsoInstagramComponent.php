<?php

namespace IrisSsoInstagram\admin;

use IrisSsoInstagram\includes\IrisSsoInstagramFactory;
use IrisSsoInstagram\includes\IrisSsoInstagramUtils;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.iris-interactive.fr
 * @since      1.0.0
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/admin
 */


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/admin
 * @author     IRIS Interactive <dev@iris-interactive.fr>
 */
class IrisSsoInstagramComponent
{
    
    /**
     * IrisSsoInstagramComponent constructor.
     */
    public function __construct()
    {
        //DO NOTHING
    }
    
    /**
     * Retrieve a metabox by name partial
     *
     * @param $partial
     * @param $metas
     *
     * @since      1.0.0
     */
    public function get_meta_box( $partial, $metas )
    {
        $tpl = IrisSsoInstagramUtils::iris_sso_instagram_locate_template( 'iris_sso_instagram-' . $partial, '', 'metabox', false, 'admin' );
        require_once $tpl;
    }

	/**
	 *
	 */
	public function get_iris_sso_instagram_settings_page()
	{
		$tpl = IrisSsoInstagramUtils::iris_sso_instagram_locate_template( 'iris_sso_instagram-settings-page', '', 'pages', false, 'admin' );
		require_once $tpl;
	}

	/**
	 *
	 */
	public function get_iris_sso_instagram_social_walls_page()
	{
		$tpl = IrisSsoInstagramUtils::iris_sso_instagram_locate_template( 'iris_sso_instagram-social-walls-page', '', 'pages', false, 'admin' );
		require_once $tpl;
	}
}