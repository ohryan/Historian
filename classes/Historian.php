<?php
namespace RP;
use \WP_Query;

class Historian {
	
	
	var $query_args;

	function __construct() {
		$this->query_args = array(
								'posts_per_page'	=>	-1,
								'post_status'		=>	'publish',
								'w'					=> date('W'),
								'date_query'		=>	array(
														'before'	=>	date( 'Y-m-d 00:00' ),

													)
							);
	}


	function displayDashboardWidget() {
		$q = new WP_Query( $this->query_args );

		if ( $q->have_posts() ) {
			while ( $q->have_posts() ){ 
				$q->the_post();
				if ( $loop_year != get_the_date( 'Y' ) ) {
					$loop_year = get_the_date('Y');
					$day_of_week = '';
					echo "<h2>$loop_year</h2>";
				}

				if ( $day_of_week != get_the_date('l') ) {
					
					echo '<h4>'.get_the_date( 'l' ).'</h4>';
				}
				echo '<h4><a href="'.get_the_permalink().'">'.get_the_title().'</a></h4></li>';
			}
		}			
	}

	function displaySidebarWidgetList() {
		$q = new WP_Query( $this->query_args );

		if ( $q->have_posts() ) {
			$first = true; 

			while ( $q->have_posts() ){ 
				$q->the_post();
				
				if ( $loop_year != get_the_date( 'Y' ) ) {
					$loop_year = get_the_date('Y');
				
					if ( !$first ) echo '</ul>';
					echo "<h3>$loop_year</h3>";
					echo '<ul>';

					$first = false;
				}

				echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
			}
		}	
	}
}