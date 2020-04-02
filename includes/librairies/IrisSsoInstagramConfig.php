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
class IrisSsoInstagramConfig
{
    
    /**
     * @var null
     */
    private $configuration = null;
    
    /**
     * IrisSsoInstagramConfig constructor.
     *
     * @param $nameFIle
     *
     * @throws \Exception
     */
    public function __construct( $nameFIle )
    {
        $yml_config = null;
        
        try {
            $yml        = IrisSsoInstagramFactory::get_dependence( 'yamlizer' );
            $yml_config = $yml::parse( file_get_contents( WP_PLUGIN_DIR . '/iris-sso-instagram/parameters/' . $nameFIle . '.yml' ), $yml::PARSE_CONSTANT + $yml::PARSE_CUSTOM_TAGS );
        } catch ( IrisSsoInstagramException $e ) {
            echo $e->getIrisMessage();
        }
        
        foreach ( $yml_config as $keyCfg => $valueCfg ) {
            if ( ( gettype( $valueCfg ) === 'object' ) && ( get_class( $valueCfg ) === 'Symfony\Component\Yaml\Tag\TaggedValue' ) ) {
                switch ( $valueCfg->getTag() ) {
                    case 'concat':
                        $valueCfg = join( '', $valueCfg->getValue() );
                        break;
                    case 'wp_option':
                        $params_option = $valueCfg->getValue();
                        $valueCfg      = get_option( $params_option[ 0 ] );
                        $last_value    = array_pop( $params_option );
                        $the_value     = $valueCfg;
                        unset( $params_option[ 0 ] );
                        foreach ( $params_option as $sPath ) {
                            $the_value = $the_value[ $sPath ];
                        }
                        if ( empty( $the_value ) ) {
                            $the_value = $last_value;
                        }
                        $valueCfg = $the_value;
                        break;
                    default:
                        $valueCfg = join( '', $valueCfg->getValue() );
                }
            }
            self::set_config( $keyCfg, $valueCfg );
        }
    }
    
    /**
     * Load array $configuration to constant
     *
     * @since      1.0.0
     */
    public function load_config()
    {
        foreach ( $this->configuration as $keyCfg => $valueCfg ) {
            if ( !defined( $keyCfg ) ) {
                define( $keyCfg, $valueCfg );
            }
        }
    }
    
    /**
     * Allow to add new configuration globally
     *
     * @param $name_config
     * @param $value_config
     *
     * @throws \Exception
     *
     * @since      1.0.0
     */
    public function set_config( $name_config, $value_config )
    {
        if ( !isset( $this->configuration[ $name_config ] ) ) {
            $this->configuration[ $name_config ] = $value_config;
            $this->load_config();
        } else {
            throw new IrisSsoInstagramException( 'You are not allowed to update the ' . $name_config . ' constante' );
        }
    }
    
    /**
     * Return configuration element
     *
     * @return array|null
     *
     * @since      1.0.0
     */
    public function list_config()
    {
        return $this->configuration;
    }
}