<?php
/*
Plugin Name: Historian
Plugin URI: https://github.com/ohryan/RetroPosts
Description: Historian surfaces old blog posts on your dashboard and as a sidebar widget.
Version: 1.0
Author: Ryan Neudorf
Author URI: http://ohryan.ca/
License: GPLv2 or later
*/
namespace RP;

require_once 'classes/Historian.php';
require_once 'classes/HistorianWidget.php';

function retroposts_add_dashboard_widgets() {
	wp_add_dashboard_widget(
                 'retroposts_dashboard_widget',
                 'Historian',
                 __NAMESPACE__.'\\retroposts_dashboard_widget_display'
        );
}

add_action( 'wp_dashboard_setup', __NAMESPACE__.'\\retroposts_add_dashboard_widgets' );

function retroposts_dashboard_widget_display() {
	$h = new Historian();
	$h->displayDashboardWidget();
}

add_action('widgets_init', function(){ return register_widget(__NAMESPACE__."\\HistorianWidget"); });
?>