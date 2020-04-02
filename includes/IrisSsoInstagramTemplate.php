<?php

namespace IrisSsoInstagram\includes;

use IrisSsoInstagram\shared\IrisSsoInstagramComponent as IrisSsoInstagramComponent_Shared;
use IrisSsoInstagram\admin\IrisSsoInstagramComponent as IrisSsoInstagramComponent_Admin;

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
class IrisSsoInstagramTemplate {

    /*
      _____                _                       _
     |  ___| __ ___  _ __ | |_       ___ _ __   __| |
     | |_ | '__/ _ \| '_ \| __|____ / _ \ '_ \ / _` |
     |  _|| | | (_) | | | | ||_____|  __/ | | | (_| |
     |_|  |_|  \___/|_| |_|\__|     \___|_| |_|\__,_|

    */
    
    /*
      ____             _                        _
     | __ )  __ _  ___| | __      ___ _ __   __| |
     |  _ \ / _` |/ __| |/ /____ / _ \ '_ \ / _` |
     | |_) | (_| | (__|   <_____|  __/ | | | (_| |
     |____/ \__,_|\___|_|\_\     \___|_| |_|\__,_|

    */
	
	/**
	 * Decorator for render admin meta boxes
	 *
	 * @param $partial
	 * @param $metas
	 *
	 * @since    1.0.0
	 */
	public static function get_meta_box( $partial, $metas ) {
		$cpnt = new IrisSsoInstagramComponent_Admin();
		echo $cpnt->get_meta_box( $partial, $metas );
	}

	public static function get_iris_sso_instagram_settings_page() {
		$cpnt = new IrisSsoInstagramComponent_Admin();
		echo $cpnt->get_iris_sso_instagram_settings_page();
	}
 
	public static function get_iris_sso_instagram_social_walls_page() {
		$cpnt = new IrisSsoInstagramComponent_Admin();
		echo $cpnt->get_iris_sso_instagram_social_walls_page();
	}

}