<?php
/**
 * Loads our helper function for the plugin.
 *
 * @package BadgeOS Progress Bar
 */

/**
 * Echos a progress bar for a given achievement and user.
 *
 * @see badgeos_get_user_progress_bar() for argument details.
 *
 * @since 1.0.0
 *
 * @param array $args Array of arguments for the progress bar.
 *
 * @return mixed HTML output for progress bar.
 */
function badgeos_user_progress_bar( $args = array() ) {
	echo badgeos_get_user_progress_bar( $args );
}

/**
 * Returns a progress bar for a given achievement and user.
 *
 * The arguments you should pass in as part of the $args array are:
 * - Integer. Achievement ID.
 * - Integer. User ID.
 * - Boolean. Whether or not to list missing/need steps.
 *
 * Example:
 * 	$args = array( 'achievement_id' => 54, 'user_id' => 1, 'list_needed_steps' => false );
 *  badgeos_user_progress_bar( $args );
 *
 * @since 1.0.0
 *
 * @param array $args Array of arguments for the progress bar.
 *
 * @return mixed HTML output for progress bar.
 */
function badgeos_get_user_progress_bar( $args = array() ) {
	# Create an instance of our custom progress bar using the arguments provided.
	$myprogress = new tw2113_BadgeOS_Progress_Bar( $args );

	# Pass the object above to the master progress bar class.
	$progress_bar = new BadgeOS_Progress_Bar( $myprogress );
	return $progress_bar->render_progress_bar();
}

/**
 * Adds some basic CSS to our header output for styling.
 *
 * To unhook so you can use your own styles, add the following to your theme's functions.php
 *
 * remove_action( 'wp_head', 'badgeos_progress_bar_styles' );
 *
 * @since 1.0.0
 *
 * @return mixed CSS tag.
 */
function badgeos_progress_bar_styles() { ?>
	<style type="text/css">
		.badgeos_progress_bar {
			height: 40px;
			position: relative;
			background: #555;
			-moz-border-radius: 25px;
			-webkit-border-radius: 25px;
			border-radius: 25px;
			padding: 10px;
			box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
		}
		.badgeos_progress_bar > span {
		  display: block;
		  height: 100%;
		  border-top-right-radius: 8px;
		  border-bottom-right-radius: 8px;
		  border-top-left-radius: 20px;
		  border-bottom-left-radius: 20px;
		  background-color: rgb(43,194,83);
		  background-image: linear-gradient(
		    center bottom,
		    rgb(43,194,83) 37%,
		    rgb(84,240,84) 69%
		  );
		  box-shadow:
		    inset 0 2px 9px  rgba(255,255,255,0.3),
		    inset 0 -2px 6px rgba(0,0,0,0.4);
		  position: relative;
		  overflow: hidden;
		}
	</style>
<?php
}
add_action( 'wp_head', 'badgeos_progress_bar_styles' );
