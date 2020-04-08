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
class IrisSsoInstagramPostType {

	public function __construct() {
		// DO NOTHING.
	}

	public function init_custom_post_type() {
		foreach( IRIS_SSO_INSTAGRAM_POST_TYPE as $key => $parametersPostType ) {
			$labels = array(
				'name'               => __( $parametersPostType[ 'NAME' ], IRIS_SSO_INSTAGRAM_DOMAIN ),
				'singular_name'      => __( $parametersPostType[ 'SINGULAR_NAME' ], IRIS_SSO_INSTAGRAM_DOMAIN ),
				'add_new'            => __( 'Ajouter', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'add_new_item'       => __( 'Ajouter', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'edit'               => __( 'Modifier', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'edit_item'          => __( 'Modifier', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'new_item'           => __( 'Nouveau', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'view'               => __( 'Voir', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'view_item'          => __( 'Voir', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'search_items'       => __( 'Rechercher', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'not_found'          => __( 'Aucun élément trouvé', IRIS_SSO_INSTAGRAM_DOMAIN ),
				'not_found_in_trash' => __( 'Aucun dans la corbeille', IRIS_SSO_INSTAGRAM_DOMAIN ),
			);
			$params = $parametersPostType[ 'PARAMS' ];
			$params[ 'labels' ] = $labels;
			register_post_type(
				$parametersPostType[ 'SLUG' ],
				$params
			);
		}
	}

}
