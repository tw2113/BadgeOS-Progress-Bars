<?php
/**
 * Class used for my custom implementation.
 *
 * Prefixing this implementation to avoid conflicts if
 * BadgeOS core ever adopts this for inclusion.
 *
 * @package BadgeOS Progress Bar
 */

/**
 * Creates a progress bar for a specified achievement ID and a given user.
 *
 * @since 1.0.0
 */
class tw2113_BadgeOS_Progress_Bar implements iBadgeOS_Progress_bar {

	/**
	 * Achievement ID to render progress bar for.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var integer
	 */
	public $achievement_id = 0;

	/**
	 * User ID to check the progress for.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var integer
	 */
	public $user_id = 0;

	/**
	 * Whether or not to list missing steps.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var boolean
	 */
	public $list_needed_steps = false;

	public function __construct( $args = array() ) {
        $this->achievement_id       = $args['achievement_id'];
        $this->user_id              = $args['user_id'];
        $this->list_needed_steps    = $args['list_needed_steps'];
	}

	/**
	 * Fetch and construct an array of data for the progress bar.
	 *
	 * @since 1.0.0
	 *
	 * @return array $data Array of data including required step counts,
	 *                     completed step counts, and conditionally completed
	 *                     steps for reference purposes.
	 */
	public function user_progress_bar_data() {
		$data = array();

        $achievements   = badgeos_get_required_achievements_for_achievement( $this->achievement_id );
        $user_steps     = badgeos_get_user_achievements(
			array(
				'user_id' => $this->user_id,
				'achievement_type' => 'step'
			)
		);


		$data['required_steps_count'] = count( $achievements );
		$count = 0;

		if ( $this->list_needed_steps ) {
			$data['completed_steps'] = array();
		}

		foreach ( $achievements as $achievement ) {
			foreach( $user_steps as $user ) {
				if ( (int)$user->ID == (int)$achievement->ID ) {
					$count++;

					if ( $this->list_needed_steps ) {
						$data['completed_steps'][] = $achievement;
					}

				}
			}
		}
		$data['completed_steps_count'] = $count;

		return $data;
	}

	/**
	 * Returns the HTML markup for the progress bar.
	 *
	 * @since 1.0.0
	 *
	 * @return mixed HTML markup.
	 */
	public function get_user_progress_bar() {
		$data = $this->user_progress_bar_data();

		/**
		 * Filters classes to be appended to progress bar markup.
		 *
		 * @since 1.0.0
		 *
		 * @param array $value Array with default value of "badgeos_progress_bar".
		 */
		$chosen_classes = apply_filters( 'badgeos_user_progress_bar_classes', array( 'badgeos_progress_bar' ) );

		$classes = implode( ' ', $chosen_classes );
		$progress_bar = sprintf(
			'<div class="%s"><span style="width: %s;"></span></div><div>%s</div>',
			$classes,
			$this->make_percentage( $data['completed_steps_count'], $data['required_steps_count'] ),
			$this->get_progress_bar_label( $data['completed_steps_count'], $data['required_steps_count'] )
		);

		/**
		 * Filters the markup constructed for the progress bar.
		 *
		 * @since 1.0.0
		 *
		 * @param string $progress_bar The default markup for the progress bar.
		 * @param array  $data         The data used to construct the progress bar.
		 */
		return apply_filters( 'badgeos_user_progress_bar', $progress_bar, $data );
	}

	/**
	 * Takes provided low and high values and converts to percent including percent sign.
	 *
	 * @since 1.0.0
	 *
	 * @return string $value Percentage complete for provided values.
	 */
	public function make_percentage( $low_value = 0, $high_value = 0 ) {
		return ( ( $low_value / $high_value ) * 100 ) . '%';
	}

	/**
	 * Generates label for the progress bar.
	 *
	 * Follows format of "$user has earned X out of Y required steps."
	 *
	 * @since 1.0.0
	 *
	 * @param int $completed_step_total Completed steps count.
	 * @param int $required_step_total  Required step count.
	 *
	 * @return string $value Label for the progress bar.
	 */
	public function get_progress_bar_label( $completed_step_total = 0, $required_step_total = 0 ) {
		$user_id = $this->user_id;

		if ( empty( $this->user_id ) ) {
			$user_id = get_current_user_id();
		}

		$user = get_user_by( 'id', $user_id );

		$message = sprintf(
			'<p>%s has earned %d out of %d required steps.</p>',
			$user->user_nicename,
			$completed_step_total,
			$required_step_total
		);

		/**
		 * Filters the message to be used for progress bar label.
		 *
		 * @since 1.0.0
		 *
		 * @param string $message              Label to be displayed.
		 * @param int    $completed_step_total Completed steps count.
		 * @param int    $required_step_total  Required step count.
		 */
		return apply_filters( 'badgeos_progress_bar_label', $message, $completed_step_total, $required_step_total, $user_id );
	}
}
