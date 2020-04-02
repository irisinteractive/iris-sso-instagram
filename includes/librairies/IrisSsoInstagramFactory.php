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
 * @date        6/16/19 9:47 PM
 * @copyright   Copyright (c) 2002-2019 IRIS Interactive, Inc. (http://www.iris-interactive.fr)
 */

namespace IrisSsoInstagram\includes;

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
 * @author     IRIS Interactive <dev@iris-interactive.fr>
 */
class IrisSsoInstagramFactory
{
    
    private static $arrayDependence = null;
    private static $initialized = false;
    private static $self;
    
    /**
     * IrisSsoInstagramFactory constructor.
     */
    private function __construct()
    {
        //DO NOTHING
    }
    
    /**
     * IrisSsoInstagramFactory initializer.
     *
     * @since      1.0.0
     */
    private static function init()
    {
        if ( self::$initialized === true ) {
            return;
        }
        self::$arrayDependence = [];
        self::$initialized     = true;
        self::$self            = new IrisSsoInstagramFactory();
    }
    
    /**
     * Set a new dependence to Factory
     *
     * @param $name
     * @param $instance
     *
     * @throws IrisSsoInstagramException
     *
     * @since      1.0.0
     */
    public static function set_dependence( $name, $instance )
    {
        self::init();
        if ( isset( self::$arrayDependence[ $name ] ) && !empty( self::$arrayDependence[ $name ] ) ) {
            throw new IrisSsoInstagramException( 'The dependence <strong><i>' . $name . '</i></strong> is already set in Factory', 200 );
        } else {
            self::$arrayDependence[ $name ] = $instance;
        }
    }
    
    /**
     * Get dependence from Factory
     *
     * @param $name
     *
     * @return mixed
     * @throws IrisSsoInstagramException
     *
     * @since      1.0.0
     */
    public static function get_dependence( $name )
    {
        self::init();
        if ( isset( self::$arrayDependence[ $name ] ) && !empty( self::$arrayDependence[ $name ] ) ) {
            return self::$arrayDependence[ $name ];
        } else {
            throw new IrisSsoInstagramException( 'The dependence <strong><i>' . $name . '</i></strong> is not set in Factory', 200 );
        }
    }
    
    /**
     * Verify existence of dependence
     *
     * @param $name
     *
     * @return bool
     */
    public static function is_set( $name )
    {
        return ( isset( self::$arrayDependence[ $name ] ) && !empty( self::$arrayDependence[ $name ] ) ) ? true : false;
    }
    
    /**
     * Return self instance
     *
     * @return mixed
     *
     * @since      1.0.0
     */
    public static function get_instance()
    {
        return self::$self;
    }
    
    /**
     * List all dependence
     *
     * @return array|null
     *
     * @since      1.0.0
     */
    public static function list_dependence()
    {
        self::init();
        
        return self::$arrayDependence;
    }
}