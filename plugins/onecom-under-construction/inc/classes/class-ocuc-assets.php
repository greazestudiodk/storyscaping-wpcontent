<?php

/**
 * Defines assets functions
 *
 * This class includes all assets for admin and public.
 *
 * @since      0.1.0
 * @package    Under_Construction
 * @subpackage OCUC_Assets
 */

// Exit if file accessed directly.
if (!defined('ABSPATH')) {
	exit;
}

class OCUC_Assets
{

	/**
	 * Constructor to add actions for enqueue styles and scripts
	 */
	public function init_assets()
	{
		add_action('admin_head', array($this, 'uc_custom_css'));
		add_action('admin_enqueue_scripts', array($this, 'admin_styles'));
		add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
	}

	/**
	 * Enqueue admin styles.
	 */
	public function admin_styles()
	{

		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		// Register admin styles.
		wp_register_style('onecom_uc_responsive_tabs_styles', ONECOM_UC_DIR_URL . 'assets/css/responsive-tabs.css', array(), ONECOM_UC_VERSION);
		wp_register_style('onecom_uc_flatpickr_styles', ONECOM_UC_DIR_URL . 'assets/css/flatpickr.css', array(), ONECOM_UC_VERSION);
		wp_register_style('onecom_uc_admin_styles', ONECOM_UC_DIR_URL . 'assets/css/admin.css', array(), ONECOM_UC_VERSION);
		wp_register_style('onecom_uc_select2_styles', ONECOM_UC_DIR_URL . 'assets/css/select2.min.css', array(), ONECOM_UC_VERSION);
		
		/* Google fonts */
        if( ! wp_style_is( 'onecom-wp-google-fonts', 'registered' ) ) {
            wp_register_style( 
                $handle = 'onecom-wp-google-fonts', 
                $src = '//fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&display=swap', 
                $deps = null, 
                $ver = null, 
                $media = 'all'
            );
        }



		// Enqueue style only on required plugin pages
		if (in_array($screen_id, array('toplevel_page_onecom-wp-under-construction'))) {
			wp_enqueue_style( 'onecom-wp-google-fonts' );
			wp_enqueue_style('onecom_uc_responsive_tabs_styles');
			wp_enqueue_style('onecom_uc_flatpickr_styles');
			wp_enqueue_style('onecom_uc_admin_styles');
			wp_enqueue_style('onecom_uc_select2_styles');
		}

		return null;
	}

	/**
	 * Enqueue admin scripts.
	 */
	public function admin_scripts()
	{
		$screen       = get_current_screen();
		$screen_id    = $screen ? $screen->id : '';

		// Register scripts.
		wp_register_script('onecom_uc_flatpickr_script', ONECOM_UC_DIR_URL . 'assets/js/flatpickr.js', array('jquery'), ONECOM_UC_VERSION, true);
		wp_register_script('onecom_uc_tabs_script', ONECOM_UC_DIR_URL . 'assets/js/jquery.responsiveTabs.min.js', array('jquery'), ONECOM_UC_VERSION, false);
		wp_register_script('onecom_uc_admin_script', ONECOM_UC_DIR_URL . 'assets/js/admin.js', array('jquery'), ONECOM_UC_VERSION, true);
		wp_register_script('onecom_uc_select2_script', ONECOM_UC_DIR_URL . 'assets/js/select2.min.js', array('jquery'), ONECOM_UC_VERSION, true);

		// Enqueue script only on plugin pages
		if (in_array($screen_id, array('toplevel_page_onecom-wp-under-construction'))) {
			wp_enqueue_script('onecom_uc_tabs_script');
			wp_enqueue_script('onecom_uc_flatpickr_script');
			wp_enqueue_script('onecom_uc_admin_script');
			wp_enqueue_script('onecom_uc_select2_script');
			$theme_info = array('theme_directory_uri' => ONECOM_UC_DIR_URL . 'assets/images');
			wp_localize_script('onecom_uc_admin_script', 'theme_info_obj', $theme_info);
		}

		return null;
	}

	/**
	 * Hide UC tabs initially,
	 * * else it shows unformatted tabs
	 */
	public function uc_custom_css()
	{
		echo '<style>
		.ddresponsiveTabsDemo {
			display: none;
		  } 
		</style>';
	}
}

