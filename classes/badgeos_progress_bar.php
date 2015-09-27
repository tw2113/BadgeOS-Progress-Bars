<?php
/**
 * Master progress bar class intended to execute interchangeable implementations.
 *
 * @package BadgeOS Progress Bar
 */

/**
 * Class used to render our progress bars based on provided implementation.
 *
 * @since 1.0.0
 */
class BadgeOS_Progress_Bar {

	/**
	 * Set property to false to start.
	 *
	 * @since 1.0.0
	 */
	public $progress_bar = false;

	/**
	 * Set our object properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct( iBadgeOS_Progress_bar $progress_bar ) {
		$this->progress_bar = $progress_bar;
	}

	/**
	 * Render our progress bar.
	 *
	 * @since 1.0.0
	 */
	public function render_progress_bar() {
		return $this->progress_bar->get_user_progress_bar();
	}
}
