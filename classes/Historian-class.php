<?php
namespace Ohryan\Historian;
use \WP_Query;

class Historian {


	/**
	 * Get all posts by week.
	 *
	 * @return WP_Query
	 */
	private function get_posts_for_this_week_of_the_year() {
		return new WP_Query(array(
			'posts_per_page'	=>	25, // @todo perhaps make this configurable
			'post_status'		=>	'publish',
			'w'					=> date('W'),
			'date_query'		=>	array( 'before'	=>	date( 'Y-m-d 00:00' ),)
		));

	}


	/**
	 * Group posts by year.
	 *
	 * @param WP_Query $posts
	 *
	 * @return array
	 */
	private function group_posts_by_year($posts) {

		$output = array();

		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) {
				$posts->the_post();

				$post_year            = get_the_date('Y');
				$output[$post_year][] = array(
					'permalink' => get_the_permalink(),
					'title'     => get_the_title(),
				);
			}
		}

		return $output;
	}

	/**
	 * Output the widget.
	 *
	 * @return void
	 */
	public function display_legacy_widget() {
		echo $this->get_widget_content();
	}

	public function get_widget_content(){
		$output        = '';
		$posts         = $this->get_posts_for_this_week_of_the_year();
		$posts_by_year = $this->group_posts_by_year( $posts );

		foreach ( $posts_by_year as $year => $posts ) {
			$output .= "<h4>$year</h4>";
			$output .= '<ul>';
			array_walk($posts, function($post) use (&$output) {
				 $output .= "<li><a href='{$post['permalink']}'>{$post['title']}</a></li>";
			});
			$output .= '</ul>';
		}

		return $output;
	}
}