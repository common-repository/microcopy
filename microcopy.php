<?php
/**
 * @package MicroCopy
 */
/* 
Plugin Name: MicroCopy
Plugin URI: http://www.activemedia.pt/micro-copy-plugin
Description: Plugin to insert micro-copy into front-end html
Version: 1.1.0 
Author: @benjamim_alves - Active Media 
Author URI: http://www.activemedia.pt 
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
along with this program; if not, write to the Active Media.
Active Media Solutions
Av. João Crisóstomo, 69 - R/C Esq., 1050-128 Lisboa - Portugal
*/

class MicroCopy {
	public $action; 
	public $id; 
	public $page;
	public $baseurl;
	public $baseurlDetail;
	
	public function __construct() {
		$this->action			= $_GET['action']; 
		$this->id 				= $_GET['id']; 
		$this->page 			= $_GET['page'];
		$this->baseurl 			= admin_url( 'admin.php?page=microcopy/microcopy.php' );
		$this->baseurlDetail 	= admin_url( 'admin.php?page=microcopy/detail.php' );
		
		load_plugin_textdomain('microcopy', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		
		add_action('admin_menu', array( &$this,'Menu' ) );
		add_shortcode( 'am_mc', array( &$this,'Shortcode' ) );
		wp_enqueue_style( 'microcopy', plugins_url('/assets/css/microcopy.css', __FILE__) );
	}
	
	public function ShowTinyMCE() {
		wp_enqueue_script( 'common' );
		wp_enqueue_script( 'jquery-color' );
		wp_print_scripts('editor');
		if (function_exists('add_thickbox')) add_thickbox();
		wp_print_scripts('media-upload');
		if (function_exists('wp_tiny_mce')) wp_tiny_mce();
		wp_admin_css();
		wp_enqueue_script('utils');
		do_action("admin_print_styles-post-php");
		do_action('admin_print_styles');
	}
	
	public function Shortcode( $params = array() ) {
		$option_name = $params[0];
		$option = get_option( 'am_mc_' . $option_name);
		return stripslashes($option);
	}
	
	public function Menu( ) {
		add_menu_page('Microcopy', 'Microcopy', 8, __FILE__, array(&$this,'ListItem'), plugin_dir_url( __FILE__ ) . 'assets/img/icon.png');
		add_submenu_page(__FILE__, __('Add New', 'microcopy'), __('Add New', 'microcopy'), 8, 'microcopy/detail.php', array(&$this,'DetailItem'));
	}
	
	public function ListItem( ) {
		wp_enqueue_script( 'list', plugins_url('/assets/js/script-list.js', __FILE__), array('jquery') );
		include_once dirname(__FILE__) . '/list.php';
	}
	
	public function DetailItem( ) {
		add_filter('admin_head', array( &$this,'ShowTinyMCE' ) );
		wp_enqueue_script( 'detail', plugins_url('/assets/js/script-detail.js', __FILE__), array('jquery') );
		include_once dirname(__FILE__) . '/detail.php';
	}
	
	public function AddItem() {
		global $wpdb;
		add_option( $_POST['option_name'], $_POST['content'] );
		$option = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name = "' . $_POST['option_name'] . '"' ); 
		$optionID = $option->option_id;
		header( 'Location: ' . $this->baseurlDetail . '&action=edit&id=' . $optionID );
		exit();
	}
	
	public function UpdateItem() {
		global $wpdb;
		$optionID = $_POST['option_id'];
		$wpdb->update($wpdb->prefix . 'options', array( 'option_name'=> $_POST['option_name'], 'option_value'=> $_POST['content'] ), array('option_id'=>$optionID));
		header( 'Location: ' . $this->baseurlDetail . '&action=edit&id=' . $optionID );
		exit();
	}
	
	public function RemoveItem() {
		global $wpdb;
		$wpdb->query( 'DELETE FROM ' . $wpdb->prefix . 'options WHERE option_id = ' . strip_tags( $this->id ) );
		header( 'Location: ' . $this->baseurl );
		exit();
	}
}

$microcopy = new MicroCopy();
if ( is_admin() && $microcopy->page == 'microcopy/detail.php' && $_POST['micro-copy'] == 'true' ){
	if ( $_POST['option_id'] != null ) $microcopy->UpdateItem();
	else $microcopy->AddItem();
}

if ( is_admin() && $microcopy->page == 'microcopy/microcopy.php' && $microcopy->action == 'remove' && $microcopy->id > 0 ){
	$microcopy->RemoveItem();
}

?>