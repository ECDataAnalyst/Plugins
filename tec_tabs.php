<?php 
/*
Plugin Name: The English College Plugin
Plugin URI: https://github.com/ECDataanalyst
Description: The English College, Dubai plugin for future use and add some feature on it's wordpress website.
Version: 1.0.0
Author: Luther John
License: GPL2
*/

/*
== License ==
This file is part of Your Plugin Name.

The English College Tab is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the 
Free Software Foundation, either version 2 of the License or (at your option) any later version.

Your Plugin Name is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or 
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

Get a copy of the GNU General Public License in <http://www.gnu.org/licenses/>.
*/

/****/
defined ('ABSPATH') or die( 'You dont have permission to view this page' );
class WP_TEC_Tab{
		
		function __construct(){
			//no codes fo the moment
			add_action( 'init' , array( $this, 'custom_post_type' ) );
		}
		
		function activate(){
			//activate 
			$this->custom_post_type();
			flush_rewrite_rules();
		}
		
		function deactivate(){
			//deactivate 
			flush_rewrite_rules();
		}
		
		function custom_post_type(){
			register_post_type('tec' , [
										'public' => true, 
										'label' => 'TEC Tabs', 
										'menu_position' => 80 ,
										'menu_icon' => 'dashicons-feedback' 
										] );
		}
		
		function enqueue(){
			//enqueue all css and js files
		}
		
		
}
if ( class_exists('WP_TEC_Tab')){
	
	$tec_tab = new WP_TEC_Tab();
	
}

include( plugin_dir_path( __FILE__ ) . '../tec_tabs/tec_widgets.php');

register_activation_hook( __FILE__, array( $tec_tab, 'activate') );


register_deactivation_hook( __FILE__, array( $tec_tab, 'deactivate') );

