<?php
/**
 * @package ClicTracker
 */
/*
Plugin Name: ClicTracker
Plugin URI: http://clictracker.com/
Description: Plugin avanzado para rastrear, ocultar, rotar enlaces y muchas otras tacticas controversiales...
Version: 1.0.5
Author: Gus Sevilla
Author URI: http://clictracker.com/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/
require(ABSPATH . WPINC . '/pluggable.php');
require(ABSPATH . 'wp-content/plugins/clictracker/include/function.php');

function registerfunction() {
	add_menu_page('ClicTracker', 'ClicTracker', 8, basename(__FILE__), 'clictracker');
	add_submenu_page(basename(__FILE__), 'urltrack', 'Tracking', 8, basename(__FILE__) . 'graph', 'clictraking');
	add_submenu_page(basename(__FILE__), 'contentblock', 'Content Blocking', 8, basename(__FILE__) . 'contentblock', 'contentblock');
	add_submenu_page(basename(__FILE__), 'Settings', 'Setting', 8, basename(__FILE__) . 'setting', 'clicsetting');
}

function clictracker(){
	echo design_top();
	include('pages/landingpage.php');
	echo design_bottom();	
}

function contentblock(){
	echo design_top();
	include('pages/contentblock.php');
	echo design_bottom();
}

function clicsetting(){
	echo design_top();
	include('pages/setting.php');
	echo design_bottom();
}

function clictraking(){
echo design_top();
echo '<h2>LinkTrackr Settings</h2>';
	include('pages/clictraking.php');
	echo design_bottom();
}

if(is_admin()){
	function clictraker_jquery_scripts(){
		wp_enqueue_script( 'clictraker_main', plugins_url('/js/jquery-ui.min.js', __FILE__));
	}
	
	function clictraker_jquery_pre_load(){
		wp_enqueue_script( 'clictraker_pre', plugins_url('/js/jquerycustom.js', __FILE__));
	}
	wp_register_style( 'prefix-style', plugins_url('assets/css/jquery-ui.css', __FILE__) );
}else{
	function clictraker_jquery_scripts(){
		wp_enqueue_script( 'clictraker_main', plugins_url('/js/jquery-1.7.2.min.js', __FILE__));
	}
	
	function clictraker_jquery_pre_load(){
		wp_enqueue_script( 'clictraker_pre', plugins_url('/js/jquery.ui.dialog.js', __FILE__));
	}
	
	wp_register_style( 'prefix-style', plugins_url('assets/css/jquery-ui-1.8.16.custom.css', __FILE__) );
}
wp_enqueue_style( 'prefix-style' );
add_action( 'wp_print_scripts', 'clictraker_jquery_scripts' );
add_action( 'wp_print_scripts', 'clictraker_jquery_pre_load');
add_action('admin_menu', 'registerfunction');
?>