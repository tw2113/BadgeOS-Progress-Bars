<?php
/**
 * Loader file for our Progress Bar plugin.
 *
 * @package BadgeOS Progress Bar
 */

/*
Plugin Name: BadgeOS Progress Bars
Plugin URI: http://trexthepirate.com/badgeos
Description: Create and display progress bars for achievements a user is working on.
Version: 1.0.0
Author: Michael Beckwith
Author URI: http://trexthepirate.com/badgeos
License: MIT
Text Domain: badgeos_progress_bar
*/

/*
 TODO: Caching via user meta. Use achievement ID for key.
 TODO: Update cache upon achievement awarding. Check if completed step total is higher before updating. Saves on query.
 TODO: Finish needed steps output.
*/


class tw2113_BadgeOS_Progress_Bar_Loader {

	public $minimum_version = '5.3.0';

	/**
	 * It's all happening.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		// Define plugin constants
		$this->basename       = plugin_basename( __FILE__ );
		$this->directory_path = plugin_dir_path( __FILE__ );
		$this->directory_url  = plugin_dir_url( __FILE__ );
	}

	/**
	 * Execute our hooks when we want to.
	 *
	 * @since 1.0.0
	 */
	public function do_hooks() {
		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'admin_notices', array( $this, 'maybe_disable_plugin' ) );
	}

	/**
	 * We want to be i18n friendly.
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'badgeos_progress_bar', false, dirname( $this->basename ) . '/languages' );
	}

	/**
	 * Load required files to work.
	 *
	 * @since 1.0.0
	 */
	public function includes() {
		if ( $this->meets_requirements() ) {
			require_once( $this->directory_path . 'interfaces/interface-badgeos_progress_bar.php' );
			require_once( $this->directory_path . 'classes/badgeos_progress_bar.php' );
			require_once( $this->directory_path . 'classes/tw2113_badgeos_progress_bar.php' );
			require_once( $this->directory_path . 'includes/helper-functions.php' );
		}
	}

	/**
	 * Check if BadgeOS is available
	 *
	 * @since  1.0.0
	 *
	 * @return bool True if BadgeOS is available, false otherwise
	 */
	public function meets_requirements() {

		if ( $this->is_minimum_php_version( PHP_VERSION ) && class_exists( 'BadgeOS' ) ) {
			return true;
		}

		return false;

	}

}
$say_yes_to_progress = new tw2113_BadgeOS_Progress_Bar_Loader();
$say_yes_to_progress->do_hooks(); # Long live the Hook!
