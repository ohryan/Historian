<?php
namespace Ohryan\Historian;
use \WP_Query;

class HistorianWidget extends \WP_Widget {

	function __construct() {
		parent::__construct('Historian_Widget',
						$name = __('Historian', 'rp_historian_plugin' ), 
						array( 'description' => __('Posts from this week in your site\'s history.', 'wp_historian_plugin' )));
	}	

	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance['title'] );
		} else {
			$title = __('This Week In History', 'rp_historian_plugin');
		}

		$title_field_id = $this->get_field_id( 'title' ); 

		echo '<p><label for="'.$title_field_id.'">'.__('Title:','rp_historian_plugin').'</label><input type="text" value="'.$title.'" id="'.$title_field_id.'" name="'.$this->get_field_name('title').'" class="widefat"></p>';
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}

	function widget( $args, $instance ) { 
		extract( $args );

		$h = new Historian();
	   	$title = apply_filters('widget_title', $instance['title']);

	   	echo $before_widget.'<div class="widget_links">';

	   	if ( $title )       echo $before_title . $title . $after_title;

	   	$h->display_legacy_widget();

	   	echo '</div>'.$after_widget;
	}
}