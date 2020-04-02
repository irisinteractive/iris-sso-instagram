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
 * Register all actions and filters for the plugin
 *
 * @link       https://www.iris-interactive.fr
 * @since      1.0.0
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    IrisSsoInstagram
 * @subpackage IrisSsoInstagram/includes
 * @author     IRIS Interactive <dev@iris-interactive.fr>
 */
class IrisSsoInstagramLoader
{
    
    /**
     * The array of actions registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array $actions The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;
    /**
     * The array of filters registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array $filters The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;
    /**
     * The array of shortcodes registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array $shortcode The shortcodes registered with WordPress to fire when the plugin loads.
     */
    protected $shortcodes;
    /**
     * The array of remove action and filters already registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array $removes The array of remove action and filters already registered with WordPress to fire when the plugin loads.
     */
    protected $removes;
    
    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        
        $this->actions    = array();
        $this->filters    = array();
        $this->shortcodes = array();
        
        $this->removes = array(
            'action'    => array(),
            'filter'    => array(),
            'shortcode' => array(),
        );
    }
    
    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @param string $hook          The name of the WordPress action that is being registered.
     * @param object $component     A reference to the instance of the object on which the action is defined.
     * @param string $callback      The name of the function definition on the $component.
     * @param int    $priority      Optional. he priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
     *
     * @since    1.0.0
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
    }
    
    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @param string $hook          The name of the WordPress filter that is being registered.
     * @param object $component     A reference to the instance of the object on which the filter is defined.
     * @param string $callback      The name of the function definition on the $component.
     * @param int    $priority      Optional. he priority at which the function should be fired. Default is 10.
     * @param int    $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
     *
     * @since    1.0.0
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 )
    {
        $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
    }
    
    /**
     * Add a new shortcode to the collection to be registered with WordPress.
     *
     * @param string $hook      The name of the WordPress shortcode that is being registered.
     * @param object $component A reference to the instance of the object on which the action is defined.
     * @param string $callback  The name of the function definition on the $component.
     *
     * @since    1.0.0
     * @access   public
     */
    public function add_shortcode( $hook, $component, $callback )
    {
        $this->shortcodes = $this->add( $this->shortcodes, $hook, $component, $callback, '', '' );
    }
    
    /**
     * Remove action to the collection already registered by WordPress.
     *
     * @param string $hook     The name of the WordPress action that is being registered.
     * @param string $callback The name of the function definition on the $component.
     * @param int    $priority Optional. he priority at which the function should be fired. Default is 10.
     *
     * @since    1.0.0
     */
    public function remove_action( $hook, $callback, $priority = 10 )
    {
        $this->removes[ 'action' ] = $this->remove( $this->removes[ 'action' ], $hook, $callback, $priority );
    }
    
    /**
     * Remove filter to the collection already registered with WordPress.
     *
     * @param string $hook     The name of the WordPress filter that is being registered.
     * @param string $callback The name of the function definition on the $component.
     * @param int    $priority Optional. he priority at which the function should be fired. Default is 10.
     *
     * @since    1.0.0
     */
    public function remove_filter( $hook, $callback, $priority = 10 )
    {
        $this->removes[ 'filter' ] = $this->remove( $this->removes[ 'filter' ], $hook, $callback, $priority );
    }
    
    /**
     * Remove shortcode already collection to be registered with WordPress.
     *
     * @param string $hook     The name of the WordPress shortcode that is being registered.
     * @param string $callback The name of the function definition on the $component.
     *
     * @since    1.0.0
     * @access   public
     */
    public function remove_shortcode( $hook, $callback )
    {
        $this->removes[ 'shortcode' ] = $this->remove( $this->removes[ 'shortcode' ], $hook, $callback, '' );
    }
    
    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @param array  $hooks         The collection of hooks that is being registered (that is, actions or filters).
     * @param string $hook          The name of the WordPress filter that is being registered.
     * @param object $component     A reference to the instance of the object on which the filter is defined.
     * @param string $callback      The name of the function definition on the $component.
     * @param int    $priority      The priority at which the function should be fired.
     * @param int    $accepted_args The number of arguments that should be passed to the $callback.
     *
     * @return   array                                  The collection of actions and filters registered with WordPress.
     * @since    1.0.0
     * @access   private
     */
    private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args )
    {
        
        $hooks[] = array(
            'hook'          => $hook,
            'component'     => $component,
            'callback'      => $callback,
            'priority'      => $priority,
            'accepted_args' => $accepted_args,
        );
        
        return $hooks;
    }
    
    /**
     * A utility function that is used to unregister the actions and hooks into a single
     * collection.
     *
     * @param $hooks
     * @param $hook
     * @param $callback
     * @param $priority
     *
     * @return array
     * @since    1.0.0
     * @access   private
     */
    private function remove( $hooks, $hook, $callback, $priority )
    {
        
        $hooks[] = array(
            'hook'     => $hook,
            'callback' => $callback,
            'priority' => $priority,
        );
        
        return $hooks;
    }
    
    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        
        foreach ( $this->filters as $hook ) {
            add_filter( $hook[ 'hook' ], array(
                $hook[ 'component' ],
                $hook[ 'callback' ],
            ), $hook[ 'priority' ], $hook[ 'accepted_args' ] );
        }
        
        foreach ( $this->actions as $hook ) {
            add_action( $hook[ 'hook' ], array(
                $hook[ 'component' ],
                $hook[ 'callback' ],
            ), $hook[ 'priority' ], $hook[ 'accepted_args' ] );
        }
        
        foreach ( $this->removes[ 'shortcode' ] as $hook ) {
            remove_shortcode( $hook[ 'hook' ] );
        }
        
        foreach ( $this->filters as $hook ) {
            add_filter( $hook[ 'hook' ], array(
                $hook[ 'component' ],
                $hook[ 'callback' ],
            ), $hook[ 'priority' ], $hook[ 'accepted_args' ] );
        }
        
        foreach ( $this->actions as $hook ) {
            add_action( $hook[ 'hook' ], array(
                $hook[ 'component' ],
                $hook[ 'callback' ],
            ), $hook[ 'priority' ], $hook[ 'accepted_args' ] );
        }
        
        foreach ( $this->shortcodes as $hook ) {
            add_shortcode( $hook[ 'hook' ], array(
                $hook[ 'component' ],
                $hook[ 'callback' ],
            ) );
        }
    }
}
