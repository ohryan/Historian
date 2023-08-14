<?php
/*
Plugin Name: Historian Block
Plugin URI: https://github.com/ohryan/RetroPosts
Description: Historian Block provides a "this day in history" for your blog.
Version: 2.0
Author: Ryan Neudorf
Author URI: http://ohryan.ca/
Text Domain: ohryan-historian
License: GPLv2 or later
*/
namespace Ohryan\Historian;

require_once 'classes/Historian-class.php';
require_once 'classes/HistorianWidget-class.php';

function historian_add_dashboard_widgets() {
	wp_add_dashboard_widget(
                 'retroposts_dashboard_widget',
                 'Historian',
                 __NAMESPACE__.'\\historian_dashboard_widget_display'
        );
}

add_action( 'wp_dashboard_setup', __NAMESPACE__.'\\historian_add_dashboard_widgets' );

function historian_dashboard_widget_display() {
	$h = new Historian();
	$h->display_legacy_widget();
}

add_action('widgets_init', function(){ return register_widget(__NAMESPACE__."\\HistorianWidget"); });

function historian_block_render_callback($attributes, $content, $block) {
	return $content . (new Historian())->get_widget_content();
}

function historian_block_init() {
    register_block_type(
		__DIR__ . '/build',
	    array(
		    'render_callback' => __NAMESPACE__ . "\\historian_block_render_callback"
	    )
    );
}

add_action( 'init', __NAMESPACE__ . "\\historian_block_init" );