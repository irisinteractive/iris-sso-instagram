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
 * @date        6/16/19 9:26 PM
 * @copyright   Copyright (c) 2002-2019 IRIS Interactive, Inc. (http://www.iris-interactive.fr)
 */

namespace IrisSsoInstagram\includes;

use IrisSsoInstagram\admin\IrisSsoInstagramAdmin;
use IrisSsoInstagram\admin\IrisSsoInstagramAdminMenu;
use IrisSsoInstagram\admin\IrisSsoInstagramApi;
use IrisSsoInstagram\shared\IrisSsoInstagramPostType;
use IrisSsoInstagram\shared\IrisSsoInstagramShared;

/**
 * Class IrisSsoInstagramRenter
 *
 * @package IrisSsoInstagram\includes
 */
class IrisSsoInstagramRenter
{
    
    /**
     * @var
     */
    private $plugin_name;
    /**
     * @var
     */
    private $version;
    /**
     * @var mixed
     */
    private $loader;
    
    /**
     * IrisSsoInstagramRenter constructor.
     *
     * @param $plugin_name
     * @param $version
     *
     * @throws IrisSsoInstagramException
     */
    public function __construct( $plugin_name, $version )
    {
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
        $this->loader      = IrisSsoInstagramFactory::get_dependence( 'loaderizer' );
        $this->globalize();
    }
    
    /**
     *
     */
    private function globalize()
    {
        global $factory_deployer;
        global $configurizer_deployer;
        global $utilizer_deployer;
        
        $factory_deployer      = IrisSsoInstagramFactory::get_instance();
        $configurizer_deployer = $factory_deployer::get_dependence( 'configurizer' );
        $utilizer_deployer     = $factory_deployer::get_dependence( 'utilizer' );
    }
    
    /**
     *
     */
    public function rent_frontend()
    {
        $plugin_shared = new IrisSsoInstagramShared( $this->get_plugin_name(), $this->get_version() );
        $plugin_api = new IrisSsoInstagramApi();
	    $plugin_post_type = new IrisSsoInstagramPostType();

	    $this->loader->add_action( 'rest_api_init', $plugin_api, 'init_endpoint' );
	    $this->loader->add_action( 'init', $plugin_post_type, 'init_custom_post_type' );
/*        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_shared, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_shared, 'enqueue_scripts' );*/
    }
    
    /**
     *
     */
    public function rent_backend()
    {
        $plugin_admin = new IrisSsoInstagramAdmin( $this->get_plugin_name(), $this->get_version() );
        $plugin_admin_menu = new IrisSsoInstagramAdminMenu();

/*        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );*/
        $this->loader->add_action( 'admin_menu', $plugin_admin_menu, 'init_menu' );
    }

    /**
     * @return mixed
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }
    
    /**
     * @return mixed
     */
    public function get_version()
    {
        return $this->version;
    }
}