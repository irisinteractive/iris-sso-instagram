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
class IrisSsoInstagramException extends \Exception
{
    
    /**
     * IrisSsoInstagramException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     *
     * @since      1.0.0
     */
    public function __construct( $message, $code = 0, \Exception $previous = null )
    {
        //We need toa affect all the data correctly
        parent::__construct( $message, $code, $previous );
    }
    
    /**
     * Format exception
     *
     * @return string
     *
     * @since      1.0.0
     */
    public function __toString()
    {
        //Format the first line of trace
        $arrayTrace             = explode( '|', preg_replace( "/\n/", '|', $this->getTraceAsString() ) );
        $catchException         = $arrayTrace[ 0 ];
        $arrayCatchException    = explode( ':', $catchException );
        $fileAndLineCaller      = array_shift( $arrayCatchException );
        $arrayFileAndLineCaller = explode( '(', $fileAndLineCaller );
        //the final strings
        $theFileCaller = str_replace( '#0 ', '', $arrayFileAndLineCaller[ 0 ] );
        $theLineCaller = trim( $arrayFileAndLineCaller[ 1 ], ')' );
        $theCaller     = $arrayCatchException[ 0 ];
        
        $strException = '<div class="iris-exception">
                            <h1>' . __CLASS__ . '</h1>
                            <hr/>
                            <ul>
                                <li class="exception-line"><span class="exception-line-title">Code:</span><p class="exception-line-content">' . $this->code . '</p></li>
                                <li class="exception-line"><span class="exception-line-title">Message:</span><p class="exception-line-content"><strong>' . $this->message . '</strong></p></li>
                                <li class="exception-line"><span class="exception-line-title">Caller exception file:</span><p class="exception-line-content"><code>' . $theFileCaller . '</code></p></li>
                                <li class="exception-line"><span class="exception-line-title">Caller exception line:</span><p class="exception-line-content"><code>' . $theLineCaller . '</code></p></li>
                                <li class="exception-line"><span class="exception-line-title">Caller exception:</span><p class="exception-line-content"><code>' . $theCaller . '</code></p></li>
                                <li class="exception-line"><span class="exception-line-title">Exception source file:</span><p class="exception-line-content"><code>' . $this->getFile() . '</code></p></li>
                                <li class="exception-line"><span class="exception-line-title">Exception source line:</span><p class="exception-line-content"><code>' . $this->getLine() . '</code></p></li>
                                <li class="exception-line"><span class="exception-line-title">Trace:</span><p class="exception-line-content"><code>' . preg_replace( "/\n/", '<br>', $this->getTraceAsString() ) . '</code></p></li>
                            </ul>
                         </div>';
        
        //We send return string only when WP_DEBUG is true
        if ( WP_DEBUG === true ) {
            return $strException;
        } else {
            return true;
        }
    }
    
    /**
     * Return formatted exception string
     *
     * @return string
     *
     * @since      1.0.0
     */
    public function getIrisMessage()
    {
        return $this->__toString();
    }
}