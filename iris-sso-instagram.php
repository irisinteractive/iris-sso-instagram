<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.iris-interactive.fr
 * @since             1.0.0
 * @package           IrisSsoInstagram
 *
 * @wordpress-plugin
 * Plugin Name:       IRIS SSO Instagram
 * Plugin URI:        https://www.iris-interactive.fr
 * Description:       Get token and refresh long live token for instagram API
 * Version:           1.0.0
 * Author:            IRIS Interactive
 * Author URI:        https://www.iris-interactive.fr
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iris-sso-instagram
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'composer_vendor/autoload.php';

use \IrisSsoInstagram\includes\IrisSsoInstagramActivator;
use \IrisSsoInstagram\includes\IrisSsoInstagramDeactivator;
use \IrisSsoInstagram\includes\IrisSsoInstagram;

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iris-sso-instagram-activator.php
 */
function activate_iris_sso_instagram() {
	IrisSsoInstagramActivator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iris-sso-instagram-deactivator.php
 */
function deactivate_iris_sso_instagram() {
	IrisSsoInstagramDeactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iris_sso_instagram' );
register_deactivation_hook( __FILE__, 'deactivate_iris_sso_instagram' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
IrisSsoInstagram::run();