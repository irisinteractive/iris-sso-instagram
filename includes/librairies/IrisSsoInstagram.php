<?php
/**
 * IRIS Interactive
 *
 * NOTICE OF LICENSE
 *
 * This source file is no subject to a specific license
 * but it belongs to the company IRIS Interactive.
 * You can contact IRIS Interactive at the following
 * address: contact@iris-interactive.fr
 *
 * @author      Bernard REDARES
 * @date        6/16/19 8:48 PM
 * @copyright   Copyright (c) 2002-2019 IRIS Interactive, Inc. (http://www.iris-interactive.fr)
 */

namespace IrisSsoInstagram\includes;

use \Symfony\Component\Yaml\Yaml;
use IrisSsoInstagram\includes\IrisSsoInstagramRenter;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.iris-interactive.fr
 * @since      1.0.0
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/includes
 */


/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/includes
 * @author     Bernard REDARES <dev@iris-interactive.fr>
 */
class IrisSsoInstagram
{
    
    /**
     *
     */
    private static function load_factory()
    {
        IrisSsoInstagramFactory::set_dependence( 'yamlizer', new Yaml() );
        IrisSsoInstagramFactory::set_dependence( 'configurizer', new IrisSsoInstagramConfig( 'config' ) );
        IrisSsoInstagramFactory::set_dependence( 'pluginizer', self::class );
        IrisSsoInstagramFactory::set_dependence( 'loaderizer', new IrisSsoInstagramLoader() );
        IrisSsoInstagramFactory::set_dependence( 'utilizer', IrisSsoInstagramUtils::class );
        IrisSsoInstagramFactory::set_dependence( 'templatizer', IrisSsoInstagramTemplate::class );
        IrisSsoInstagramFactory::set_dependence( 'renterizer', new IrisSsoInstagramRenter( 'iris-sso-instagram', '1.0.0' ) );
    }
    
    /**
     *
     */
    public static function run()
    {
        self::load_factory();
        IrisSsoInstagramFactory::get_dependence( 'loaderizer' )->add_action( 'after_setup_theme', new IrisSsoInstagramI18n(), 'load_plugin_textdomain' );
        IrisSsoInstagramFactory::get_dependence( 'renterizer' )->rent_frontend();
        
        if ( is_admin() || ( isset( $GLOBALS[ 'pagenow' ] ) && $GLOBALS[ 'pagenow' ] === 'wp-login.php' ) ) {
            IrisSsoInstagramFactory::get_dependence( 'renterizer' )->rent_backend();
        }
        
        IrisSsoInstagramFactory::get_dependence( 'loaderizer' )->run();
    }
}
