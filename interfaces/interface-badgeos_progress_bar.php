<?php
/**
 * Sets up the interface for our progress bar so 3rd parties can implement their own.
 *
 * @package BadgeOS Progress Bar
 */

/**
 * Sets up our required methods to implement your own progress bar version.
 *
 * @since 1.0.0
 */
interface iBadgeOS_Progress_bar {

	public function get_user_progress_bar();

}
