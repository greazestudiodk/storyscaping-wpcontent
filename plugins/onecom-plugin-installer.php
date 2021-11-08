<?php
/*
 * One.com Plugin Installer
 * Version: 0.1.1
 * For internal use only.
 *
 * */

/* get self url */
function onecom_get_self_url(){
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
		$link = "https";
	else
		$link = "http";

	// Here append the common URL characters.
	$link .= "://";

	// Append the host(domain name, ip) to the URL.
	$link .= $_SERVER['HTTP_HOST'];

	// Append the requested resource location to the URL
	$link .= $_SERVER['REQUEST_URI'];

	return $link;
}

/* response generator */
function onecom_response($code, $text){
	http_response_code($code);
	die($text);
}

/* get the path of the plugin to install */
if(isset($_REQUEST['plugin']) && trim($_REQUEST['plugin']) !== ''){
	$onecom_plugin_path = trim($_REQUEST['plugin']);
}


/* exit if path empty */
if(!strlen($onecom_plugin_path))
	onecom_response(400, 'Plugin name/path missing!');


/* exclude theme functions */
define( 'WP_USE_THEMES', false );


/* WP Path */
$onecom_wpli_path = dirname(dirname(__DIR__));

if(! file_exists( $onecom_wpli_path . '/wp-load.php')){
	onecom_response(404, 'WordPress path not found at'.$onecom_wpli_path);
}


/* load wordpress */
require_once ( $onecom_wpli_path .'/wp-load.php' );


if(!class_exists('WP'))
	onecom_response(405, 'Could not load WordPress libraries!');


/* load plugin functions */
require_once ($onecom_wpli_path .'/wp-admin/includes/plugin.php');


/* strip slashes */
$onecom_plugin_path = wp_unslash($onecom_plugin_path);


/* return if plugin directory/file not present on webspace */
$installed_plugins = get_plugins();

if(! array_key_exists( $onecom_plugin_path, $installed_plugins))
	onecom_response(404, 'No plugin directory/file found on webspace matching path: '.$onecom_plugin_path);


/* backward compatibility */
if(!function_exists('get_home_path')){
	require_once ($onecom_wpli_path.'/wp-admin/includes/file.php');
}


/* check if required function loaded. */
if(! (function_exists( 'activate_plugin') &&
      function_exists( 'uninstall_plugin') &&
      function_exists( 'deactivate_plugins')))

	onecom_response(405, 'Plugin handling method(s) not found! Programmatic plugin handling not available with this version of WordPress: v'.@get_bloginfo('version'));


$re='';
/* Deactivate if plugin already active */
if( is_plugin_active( $onecom_plugin_path ) ) {
	$re='Re';
	deactivate_plugins($onecom_plugin_path, true, is_multisite());
}


/* Uninstall if it allows */
if ( !is_plugin_active( $onecom_plugin_path ) && is_uninstallable_plugin( $onecom_plugin_path )) {

	// Handle uninstall call
	if(isset($_REQUEST['uninstall']) && $_REQUEST['uninstall'] == 1){
		uninstall_plugin($onecom_plugin_path);
	}
	// trigger uninstall call
	else{
		file_get_contents( onecom_get_self_url().'&uninstall=1');
	}
}

// handle an edge case where DB value of active_plugins is empty
// then update that to contain an empty array, so that WP core functions can work properly.
$db = get_site_option('active_plugins', array());
if(""===$db){
    update_site_option('active_plugins', array());
}

/* Activate the plugin, (network wide & silently) */
$activate = activate_plugin($onecom_plugin_path, '', is_multisite(), false);


/* if error, return the reason */
if ( is_wp_error( $activate ) ) {

	if ( 'unexpected_output' == $activate->get_error_code() ) {
		onecom_response( 417, $activate->get_error_code(). '---'. $activate->get_error_data());
	}
	else {
		die('Activated!!');
	}
}
/* if installed without any error */
else{
	onecom_response(200, 'Plugin activated!');
}

/* Verify if installed */
/*if($activate === null && ! is_plugin_active( $onecom_plugin_path)){

	// Handle verification call
	if(isset($_REQUEST['verify']) && $_REQUEST['verify'] == 1){
		if(is_plugin_active( $onecom_plugin_path)){
			die('Installed plugin!');
		}
		else{
			die('Could not install the plugin');
		}
	}
	// trigger verification call
	else{
		file_get_contents( onecom_get_self_url().'&verify=1');
		die(var_dump($onecom_plugin_path));
	}
}*/
?>
