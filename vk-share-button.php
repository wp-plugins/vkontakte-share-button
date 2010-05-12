<?php

// pluginname VKontakte Share Button
// shortname VKShareButton
// dashname vk-share-button

/*
Plugin Name: VKontakte Share Button
Plugin URI: http://www.jackyfox.com/vk-share-button/
Description: The plugin implements the API function VKontakte social network that adds the link share button.
Author: Eugene Padlov
Version: 1.0.0.30
Author URI: http://www.jackyfox.com/
License: GPL2
*/

/*  Copyright 2010  Eugene Padlov  (email : fox.sawyer@gmail.com)

    This plugin is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This plugin is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this plugin; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('VKShareButton')) :

class VKShareButton
{
	var $plugin_url;
	var $plugin_domain = 'vk-share-button';
	
	function VKShareButton()
	{
		$this->plugin_url = trailingslashit(WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
		// Check version
		global $wp_version;
		
		// Load translation only on admin pages
		if (is_admin())
			$this->load_domain();

		$exit_msg = __('VKontakte share button plugin requires Wordpress 2.7 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>', $this->plugin_domain);

		if (version_compare($wp_version,"2.7","<"))
		{
			exit ($exit_msg);
		}
		// installation
		register_activation_hook(__FILE__, array(&$this, 'install'));
		// Register options settings
		add_action('admin_init', array(&$this, 'register_settings'));
		// Create custom plugin settings menu
		add_action('admin_menu', array(&$this, 'create_menu'));
		// add vk api scripts to head
		add_action('wp_print_scripts', array(&$this, 'script_include'));
		// Filter for processing button placing
		add_filter('the_content', array(&$this, 'place_button'));
	}
	
	function install()
	{
		//create options
		update_option('vk_share_button_type', 'round');
		update_option('vk_share_button_text', 'Save');
		update_option('vk_share_button_description', 'auto');
		update_option('vk_share_button_description_text', '');
		update_option('vk_share_button_thumbnail', '');
		update_option('vk_share_button_position', 'right');
		update_option('vk_share_button_vposition', 'top');
		update_option('vk_share_button_show_on_posts', TRUE);
		update_option('vk_share_button_show_on_pages', FALSE);
		update_option('vk_share_button_noparse', 'true');
	}
	
	function register_settings()
	{
		//register our settings
		register_setting( 'vksb-settings-group', 'vk_share_button_type' );
		register_setting( 'vksb-settings-group', 'vk_share_button_text' );
		register_setting( 'vksb-settings-group', 'vk_share_button_description' );
		register_setting( 'vksb-settings-group', 'vk_share_button_description_text' );
		register_setting( 'vksb-settings-group', 'vk_share_button_thumbnail' );
		register_setting( 'vksb-settings-group', 'vk_share_button_position' );
		register_setting( 'vksb-settings-group', 'vk_share_button_vposition' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_posts' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_pages' );
		register_setting( 'vksb-settings-group', 'vk_share_button_noparse' );
	}
	
	// Add options page
	function create_menu()
	{
		//create new menu in Settings section
		add_options_page(__('VKontakte Share Button Plugin Settings', $this->plugin_domain), __('VK Share Button', $this->plugin_domain), 'administrator', __FILE__, array(&$this, 'settings_page'));	
	}
	
	// Settings page
	function settings_page() {
		$vksb_type = get_option('vk_share_button_type');
		$vksb_text = get_option('vk_share_button_text');
		$vksb_desc = get_option('vk_share_button_description');
		$vksb_desc_text = get_option('vk_share_button_description_text');
		$vksb_thumb = get_option('vk_share_button_thumbnail');
		$vksb_pos = get_option('vk_share_button_position');
		$vksb_vpos = get_option('vk_share_button_vposition');
		$vksb_showpost = get_option('vk_share_button_show_on_posts');
		$vksb_showpage = get_option('vk_share_button_show_on_pages');
		$noparse = get_option('vk_share_button_noparse');
			
		include('vk-share-button-options.php');
	}
	
	// Add VK-API script to head of each page
	function script_include()
	{
		if (!is_admin())
		{
			echo '<link rel="stylesheet" href="'.$this->plugin_url.'vk-share-button.css" type="text/css" />';
			wp_enqueue_script('vk_share_button_api_script', 'http://vkontakte.ru/js/api/share.js?5');
		}
	}
	
	// Function returns the button code
	function the_button() {
		global $post;
		$link =  js_escape(get_permalink($post->ID));
		$title = js_escape($post->post_title);
		switch (get_option('vk_share_button_description')) {
			case 'auto':
				$descr = js_escape(substr(strip_tags($post->post_content), 0, 350));
				break;
			case 'global':
				$descr = js_escape(get_option('vk_share_button_description_text'));
				break;
			case 'none':
				$descr = '';
		}
		$thumb = js_escape(get_option('vk_share_button_thumbnail'));
		$type = js_escape(get_option('vk_share_button_type'));
		// If custom buttom type selected use unconverted text
		$text = $type != 'custom' ? 
			js_escape(get_option('vk_share_button_text')) : 
			get_option('vk_share_button_text');
		$noparse = get_option('vk_share_button_noparse');
			
		$button_code = "<!-- vkontakte share button -->\r\n<script type=\"text/javascript\">\r\n<!--\r\ndocument.write(VK.Share.button(\r\n{\r\n";
		$button_code .= "  url: '$link',\r\n";
		$button_code .= "  title: '$title',\r\n"; 
		$button_code .= $descr != '' ? "  description: '$descr',\r\n" : '';
		$button_code .= $thumb != '' ? "  image: '$thumb',\r\n" : '';
		$button_code .= $noparse == 'true' ? "  noparse: $noparse \r\n}, \r\n{\r\n" : "  \r\n}, \r\n{\r\n";
		$button_code .= "  type: '$type',\r\n";
		$button_code .= "  text: '$text'\r\n}));";
		$button_code .= "\r\n-->\r\n</script>\r\n<!-- / vkontakte share button -->";
		
		return ($button_code);
	}

	function place_button($content) {
		// Here we place button on the page
		$clear_button = $this->the_button();
		$pos = get_option('vk_share_button_position');
		$vpos = get_option('vk_share_button_vposition');
		$show_on_post = get_option('vk_share_button_show_on_posts');
		$show_on_page = get_option('vk_share_button_show_on_pages');
		
		if ($pos == 'right')
			// right alignment
			$the_button = "<div style=\"float: $pos; margin: 0 0 5px 10px; \" id=\"vk-button\">\r\n$clear_button\r\n</div>";
		else
			// left alignment
			$the_button = "<div style=\"float: $pos; margin: 0 10px 5px 0;\" id=\"vk-button\">\r\n$clear_button\r\n</div>";

		if (is_single() && $show_on_post || is_page() && $show_on_page) {
			if ($vpos == 'top')
				// place button before post
				return $the_button . $content;
			else
				// after post
				return $content . $the_button;
		}
		else
			return $content;
	}
	
	// Localization support
	function load_domain()
	{
		$mofile = dirname(__FILE__) . '/lang/vk-share-button-' . get_locale() . '.mo';
		
		load_textdomain($this->plugin_domain, $mofile);
	}
} // class VKShareButton

else :

	exit(__('Class VKShareButton already declared!', $this->plugin_domain));
	
endif;


if (class_exists('VKShareButton')) :
	
	$VKShareButton = new VKShareButton();

endif;

?>