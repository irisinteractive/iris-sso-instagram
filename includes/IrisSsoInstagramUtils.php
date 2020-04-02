<?php

namespace IrisSsoInstagram\includes;

use GuzzleHttp\Client;
use WP_Query;

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
class IrisSsoInstagramUtils
{
    
    /**
     * Get good template from plugin or theme arborescence
     *
     * @param string $template_name
     * @param string $template_path
     * @param string $default_path
     * @param bool   $mail
     * @param string $source
     *
     * @return string
     *
     * @since    1.0.0
     */
    public static function iris_sso_instagram_locate_template( $template_name, $template_path = '', $default_path = '', $mail = false, $source = 'shared', $compiled = false )
    {
        if ( !$template_path ) {
            $template_path = IRIS_SSO_INSTAGRAM_TEMPLATE_PATH;
        }
        
        if ( !$default_path ) {
            $default_path = IRIS_SSO_INSTAGRAM_TEMPLATE_PATH . '/' . $source . '/partials/';
        } else {
            $default_path = IRIS_SSO_INSTAGRAM_TEMPLATE_PATH . '/' . $source . '/partials/' . $default_path . '/';
        }
        
        $custom_template_path = get_template_directory() . '/IRIS/iris-sso-instagram/';
        
        if ( $mail === true ) {
            $template_path        .= 'mails/';
            $default_path         .= 'mails/';
            $custom_template_path .= 'mails/';
        }
        
        // Look within passed path within the theme - this is priority.
        $template = locate_template(
            array(
                trailingslashit( $template_path ) . $template_name,
                $template_name,
            )
        );
        
        // Get default template/
        if ( !$template ) {
            $template = $default_path . $template_name;
        }
        
        if ( file_exists( $custom_template_path . $template_name . '.php' ) ) {
            $template = $custom_template_path . $template_name;
        }
        
        // Return what we found and compile if needed.
        $template_filename = $template . '.php';
        $returned          = $template_filename;
        
        if ( $compiled !== false ) {
            ob_start();
            $datas = $compiled;
            require $template_filename;
            $returned = ob_get_clean();
        }
        
        return $returned;
    }
    
    /**
     * Allow to crypt and decrypt string with AES-256-CBC and WordPress SECURE_AUTH_KEY / SECURE_AUTH_SALT
     *
     * @param        $string
     * @param string $action
     *
     * @return bool|string
     *
     * @since    1.0.0
     */
    public static function cryptography( $string, $action = 'encode' )
    {
        $secret_key = SECURE_AUTH_KEY;
        $secret_iv  = SECURE_AUTH_SALT;
        
        $output         = false;
        $encrypt_method = "AES-256-CBC";
        $key            = hash( 'sha256', $secret_key );
        $iv             = substr( hash( 'sha256', $secret_iv ), 0, 16 );
        
        if ( $action === 'encode' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        } else if ( $action === 'decode' ) {
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
        
        return $output;
    }

	/**
	 * @return string
	 */
	public static function get_authorize_url() {
    	$clientId = get_option( IRIS_SSO_INSTAGRAM_CLIENT_ID );
    	$redirectURI = urlencode( trailingslashit( get_rest_url( get_current_blog_id() , '/iris-sso-instagram/v1/auth' ) ) );
    	return 'https://api.instagram.com/oauth/authorize?client_id=' . $clientId . '&redirect_uri=' . $redirectURI . '&scope=user_profile,user_media&response_type=code';
    }

	/**
	 * @return bool|mixed|void
	 */
	public static function get_token() {
		$irisSsoToken = get_option( IRIS_SSO_INSTAGRAM_TOKEN );
		if( empty( $irisSsoToken ) ) {
			return self::generate_token();
		} else {
			self::verify_expiration_token();
			return $irisSsoToken;
		}
    }

	/**
	 * @return mixed
	 */
	public static function generate_token() {
	    // Generate short live token
	    $clientShortLiveToken = new Client([
	        'base_uri' => 'https://api.instagram.com',
		    'verify' => false
		]);
	    $responseShortLiveToken = $clientShortLiveToken->request( 'POST', '/oauth/access_token', [
		    'form_params' => [
			    'client_id' => get_option( IRIS_SSO_INSTAGRAM_CLIENT_ID ),
			    'client_secret' => get_option( IRIS_SSO_INSTAGRAM_CLIENT_SECRET ),
			    'grant_type' => 'authorization_code',
			    'redirect_uri' => trailingslashit( get_rest_url( get_current_blog_id() , '/iris-sso-instagram/v1/auth' ) ),
			    'code' => get_option( IRIS_SSO_INSTAGRAM_CODE )
		    ]
	    ]);
	    $shortLiveToken = json_decode( $responseShortLiveToken->getBody()->getContents() );

	    // Get Long live token
	    $clientLongLiveToken = new Client([
			'base_uri' => 'https://graph.instagram.com',
			'verify' => false
		]);
	    $responseLongLiveToken = $clientLongLiveToken->request( 'GET', '/access_token', [
		    'query' => [
			    'grant_type' => 'ig_exchange_token',
			    'client_secret' => get_option( IRIS_SSO_INSTAGRAM_CLIENT_SECRET ),
			    'access_token' => $shortLiveToken->access_token
		    ]
	    ]);
	    $longLiveToken = json_decode( $responseLongLiveToken->getBody()->getContents() );
	    $longLiveToken->expire_timestamp = time() + (int)$longLiveToken->expires_in;

	    update_option( IRIS_SSO_INSTAGRAM_TOKEN, json_encode( $longLiveToken ) );

	    return $longLiveToken;
    }

	/**
	 *
	 */
	public static function refresh_token() {
    	$currentToken = json_decode( get_option( IRIS_SSO_INSTAGRAM_TOKEN ) );
	    $clientLongLiveToken = new Client([
			'base_uri' => 'https://graph.instagram.com',
			'verify' => false
		]);
	    $responseLongLiveToken = $clientLongLiveToken->request( 'GET', '/refresh_access_token', [
		    'query' => [
			    'grant_type' => 'ig_refresh_token',
			    'access_token' => $currentToken->access_token
		    ]
	    ]);
	    $longLiveToken = json_decode( $responseLongLiveToken->getBody()->getContents() );
	    $longLiveToken->expire_timestamp = time() + $longLiveToken->expires_in;

	    update_option( IRIS_SSO_INSTAGRAM_TOKEN, json_encode( $longLiveToken ) );
    }

	/**
	 *
	 */
	public static function verify_expiration_token() {
	    $currentToken = json_decode( get_option( IRIS_SSO_INSTAGRAM_TOKEN ) );

	    if( ((int)$currentToken->expire_timestamp - (int)time()) <= 432000 ) {
			self::refresh_token();
	    }
    }
}