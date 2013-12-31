<?php
/*
Plugin Name: RetroPosts
Plugin URI: https://github.com/ohryan/RetroPosts
Description: Displays posts from the past!
Version: 0.1.1
Author: Ryan Neudorf
Author URI: http://ohryan.ca/
License: GPLv2 or later
*/

function retroposts_add_dashboard_widgets() {
	wp_add_dashboard_widget(
                 'retroposts_dashboard_widget',
                 'RetroPosts',
                 'retroposts_dashboard_widget_display'
        );
}

add_action( 'wp_dashboard_setup', 'retroposts_add_dashboard_widgets' );


function retroposts_dashboard_widget_display() {
	$week = date('W');
	$loop_year = null;



	add_filter( 'posts_where', 'retroposts_filter_year' );
	add_filter( 'posts_orderby', 'retroposts_filter_order' );
	$query = new WP_Query( "w=$week&post_status=publish&posts_per_page=-1");
	remove_filter( 'posts_where', 'retroposts_filter_year' );
	remove_filter( 'posts_orderby', 'retroposts_filter_order' );

	$post_count = $query->post_count;

	if ($query->have_posts()): ?>
		<p>This week in the past you wrote <strong><?php echo $post_count ?></strong> posts.</p>
		<ul>
		<?php while ( $query->have_posts() ): $query->the_post(); ?>

			<li>
				<?php
				if ( $loop_year != get_the_date( 'Y' ) ) {
					$loop_year = get_the_date('Y');
					$day_of_week = '';
					echo "<h2>$loop_year</h2>";
				}

				if ( $day_of_week != get_the_date('l') ) {
					$day_of_week = get_the_date( 'l' );
					echo "<h4>$day_of_week</h4>";
				}
				?>

			<h4><a href="<?php echo the_permalink() ?>"><?php echo the_title(); ?></a></h4></li>


		<?php endwhile; ?>
		</ul>
	<?php else: ?>
		<p>You haven't written any posts during this week in the past.</p>
	<?php endif; 
	
}

function retroposts_filter_year( $where = '' ) {
	$year = date('Y');
	$where .= " AND YEAR(post_date) < $year";
	return $where;
}

function retroposts_filter_order( $orderyby_statement ) {
	$orderyby_statement = 'YEAR(post_date) DESC, DAYOFYEAR(post_date) ASC';
	return $orderyby_statement;
}
?>