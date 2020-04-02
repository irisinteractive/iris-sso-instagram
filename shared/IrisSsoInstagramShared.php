<?php

namespace IrisSsoInstagram\shared;

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.iris-interactive.fr
 * @since      1.0.0
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/shared
 */


/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/shared
 * @author     IRIS Interactive <dev@iris-interactive.fr>
 */
class IrisSsoInstagramShared
{
    
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;
    
    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version     The version of this plugin.
     *
     * @since    1.0.0
     */
    public function __construct( $plugin_name, $version )
    {
        
        $this->plugin_name = $plugin_name;
        $this->version     = $version;
    }
    
    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in IrisSsoInstagramLoader as all of the hooks are defined
         * in that particular class.
         *
         * The IrisSsoInstagramLoader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/dist/css/app_shared.min.css', array(), $this->version, 'all' );
    }
    
    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in IrisSsoInstagramLoader as all of the hooks are defined
         * in that particular class.
         *
         * The IrisSsoInstagramLoader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/dist/js/app_shared.min.js', array( 'jquery' ), $this->version, false );
    }
}
