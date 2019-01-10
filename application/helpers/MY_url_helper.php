<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * PHP Students registation - MY_url_helper
 *
 * LICENSE
 *
 * BrandName is released with dual licensing, using the GPL v3 (license-gpl3.txt) and the MIT license (license-mit.txt).
 * You don't have to do anything special to choose one license or the other and you don't have to notify anyone which license you are using.
 * Please see the corresponding license file for details of these licenses.
 * You are free to use, modify and distribute this software, but all copyright information must remain.
 *
 * @package    	BrandName Students resgistration school application
 * @copyright  	Copyright (c) 2010 through 2012, Kechlimparis Athanasios
 * @license    	https://github.com//-crud/blob/master/.txt
 * @version    	1.4.2
 * @author     	Kechlimparis Athanasios <kechrimparis@gmail.com>
 *

 */

/**
 * Site URL
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @param  mixed  either a string reprenting the path or an array of path elements
 */
function site_url( $uri = '' )
{
	$CI =& get_instance();

	$url = $CI->config->site_url( $uri );

	if( parse_url( $url, PHP_URL_SCHEME ) == 'https' )
	{
		$url = substr( $url, 0, 4 ) . substr( $url, 5 );
	}

	return $url;
}

// --------------------------------------------------------------

/**
 * Secure Site URL
 *
 * If USE_SSL is set to 1, creates a HTTPS version of site_url().
 *
 * Create a local URL based on your basepath. Segments can be passed via the
 * first parameter either as a string or an array.
 *
 * @param  mixed either a string reprenting the path or an array of path elements
 */
function secure_site_url( $uri = '' )
{
	$CI =& get_instance();

	$url = $CI->config->site_url( $uri );

	if( USE_SSL === 1 )
	{
		if( parse_url( $url, PHP_URL_SCHEME ) == 'http' )
		{
			$url = substr( $url, 0, 4 ) . 's' . substr( $url, 4 );
		}
	}

	return $url;
}

// --------------------------------------------------------------

/**
 * If Secure Site URL
 *
 * If USE_SSL is set to 1 AND current request is in HTTPS, 
 * creates a HTTPS version of site_url(), else a standard HTTP version.
 *
 * @param  mixed either a string reprenting the path or an array of path elements
 */
function if_secure_site_url( $uri = '' )
{
	if( ! empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) !== 'off' )
	{
		return secure_site_url( $uri );
	}
	else
	{
		return site_url( $uri );
	}
}

// --------------------------------------------------------------

/**
 * Base URL
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @param  mixed  either a string reprenting the path, an array of path elements or a URL to a file
 */
function base_url( $uri = '' )
{
	$CI =& get_instance();

	$url = $CI->config->base_url( $uri );

	if( parse_url( $url, PHP_URL_SCHEME ) == 'https' )
	{
		$url = substr( $url, 0, 4 ) . substr( $url, 5 );
	}

	return $url;
}

// ---------------------------------------------------------------

/**
 * Secure Base URL
 *
 * If USE_SSL is set to 1, creates a HTTPS version of base_url().
 * 
 * Create a local URL based on your basepath.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @param  mixed  either a string reprenting the path, an array of path elements or a URL to a file
 */
function secure_base_url( $uri = '' )
{
	$CI =& get_instance();

	$url = $CI->config->base_url( $uri );

	if( USE_SSL === 1 )
	{
		if( parse_url( $url, PHP_URL_SCHEME ) == 'http' )
		{
			$url = substr( $url, 0, 4 ) . 's' . substr( $url, 4 );
		}
	}

	return $url;
}

// --------------------------------------------------------------

/**
 * If Secure Base URL
 *
 * If current request is HTTPS, creates a HTTPS version of base_url().
 * 
 * Create a local URL based on your basepath if current request is HTTPS.
 * Segments can be passed in as a string or an array, same as site_url
 * or a URL to a file can be passed in, e.g. to an image file.
 *
 * @param  mixed  either a string reprenting the path, an array of path elements or a URL to a file
 */
function if_secure_base_url( $uri = '' )
{
	$CI =& get_instance();

	$url = $CI->config->base_url( $uri );

	if( ! empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) !== 'off' )
	{
		if( parse_url( $url, PHP_URL_SCHEME ) == 'http' )
		{
			$url = substr( $url, 0, 4 ) . 's' . substr( $url, 4 );
		}
	}

	return $url;
}

// --------------------------------------------------------------

/**
 * Current URL
 *
 * Returns the full URL (including segments) of the page where this
 * function is placed
 *
 * Modified so that current_url() allows for HTTPS. Also modified
 * so that a specific host (domain) can replace the current one. 
 * This is important if you want to be able to have somebody 
 * switch the current page to another language using i18n domains.
 *
 * @param  string  the requested language.
 */
function current_url( $requested_lang = 'english' )
{
	$CI =& get_instance();

	$url = $CI->config->site_url( $CI->uri->uri_string() );

	if( ! empty( $_SERVER['HTTPS'] ) && strtolower( $_SERVER['HTTPS'] ) !== 'off' )
	{
		if( parse_url( $url, PHP_URL_SCHEME ) == 'http' )
		{
			$url = substr( $url, 0, 4 ) . 's' . substr( $url, 4 );
		}
	}

	/**
	 * If $requested_lang is a value in the domain_langs array,
	 * then we want to replace the URL's domain with the one requested
	 */
	$domain_langs = $CI->config->item('domain_langs');

	if( in_array( $requested_lang, $domain_langs ) )
	{
		// Get URL parts
		$url_parts = parse_url( $url );

		// Remove the scheme and host (domain) from the URL
		$url = str_replace( $url_parts['scheme'] . '://' . $url_parts['host'], '', $url );

		// Get the replacement domain/subdomain
		$replacement = array_search( $requested_lang, $domain_langs );

		// Replace the domain with the requested domain
		$url = $url_parts['scheme'] . '://' . $replacement . $url;
	}

	// Return the current URL, making sure to attach any query string that may exist
	return ( $_SERVER['QUERY_STRING'] ) ? $url . '?' . $_SERVER['QUERY_STRING'] : $url;
}

// --------------------------------------------------------------

/**
 * Secure Anchor Link
 *
 * Creates a secure anchor based on the local URL, and if USE_SSL is 'on'.
 *
 * @param  string  the URL
 * @param  string  the link title
 * @param  mixed   any attributes
 */
function secure_anchor( $uri = '', $title = '', $attributes = '' )
{
	$title = (string) $title;

	if( ! is_array( $uri ) )
	{
		$site_url = ( ! preg_match('!^\w+://! i', $uri ) ) ? secure_site_url( $uri ) : $uri;
	}
	else
	{
		$site_url = secure_site_url( $uri );
	}

	if ($title == '')
	{
		$title = $site_url;
	}

	if ($attributes != '')
	{
		$attributes = _parse_attributes( $attributes );
	}

	return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
}

function router_class (  )
{
	$CI =& get_instance();
	$data = str_replace( '_', ' ', $CI->router->fetch_class() );
	return $data;
	
	

}

function router_method ( )
{
	$CI =& get_instance();
	$data = str_replace( '_', ' ',  $CI->router->fetch_method() );
	return $data;
	
	

}

function class_url_nodash ( )
{
	$CI =& get_instance();
	$data = str_replace( '_', '-',  $CI->router->fetch_class() );
	return $data;
	
	

}

function method_url_nodash ( )
{
	$CI =& get_instance();
	$data = str_replace( '_', '-',  $CI->router->fetch_method() );
	return $data;
	
	

}


// --------------------------------------------------------------

/* End of file MY_url_helper.php */
/* Location: /application/helpers/MY_url_helper.php */