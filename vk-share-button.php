<?php

// pluginname VKontakte Share Button
// shortname VKShareButton
// dashname vk-share-button

/*
Plugin Name: VKontakte Share Button
Plugin URI: http://www.jackyfox.com/vk-share-button/
Description: The plugin implements the API function VKontakte social network that adds the link share button.
Author: Eugene Padlov
Version: 1.0.1
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
	var $exclude; // IDs of excluding pages and posts
	var $deslen;  // length of auto description
	
	var	$show_on_post;
	var	$show_on_page;
	var $show_on_home; // bool for display buttons on front page
	var $show_on_cats; // show button on category archives
	var $show_on_tags; // show butoon on tag listing
	var $show_on_date; // show button on date-based archives
	var $show_on_auth; // show button on author archives
	var $show_on_srch; // show button on search results pages
	
	var $use_own_css;
	var $own_css;  // Using own css style for wrap div
	
	function VKShareButton()
	{
		$this->plugin_url = trailingslashit(WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));
		// Check version
		global $wp_version;
		
		// Load translation only on admin pages
		if (is_admin())
			$this->load_domain();

		$exit_msg = __('VKontakte share button plugin requires Wordpress 2.8 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>', $this->plugin_domain);

		if (version_compare($wp_version,"2.8","<"))
		{
			exit ($exit_msg);
		}
		// Installation
		register_activation_hook(__FILE__, array(&$this, 'install'));
		// Register options settings
		add_action('admin_init', array(&$this, 'register_settings'));
		// Create custom plugin settings menu
		add_action('admin_menu', array(&$this, 'create_menu'));
		// add vk api scripts to head
		add_action('wp_print_scripts', array(&$this, 'add_head'));
		// Filter for processing button placing
		add_filter('the_content', array(&$this, 'place_button'));
		// Shortcode
		add_shortcode('vk-share-button', array(&$this, 'the_button'));
		
		$this->exclude = get_option('vk_share_button_exlude');
		$this->deslen = get_option('vk_share_button_deslen');
		
		$this->show_on_post = get_option('vk_share_button_show_on_posts');
		$this->show_on_page = get_option('vk_share_button_show_on_pages');
		$this->show_on_home = get_option('vk_share_button_show_on_home');
		$this->show_on_cats = get_option('vk_share_button_show_on_cats');
		$this->show_on_tags = get_option('vk_share_button_show_on_tags');
		$this->show_on_date = get_option('vk_share_button_show_on_date');
		$this->show_on_auth = get_option('vk_share_button_show_on_auth');
		$this->show_on_srch = get_option('vk_share_button_show_on_srch');
		
		$this->use_own_css = get_option('vk_share_button_use_owncss');
		$this->own_css = get_option('vk_share_button_owncss');
	}
	
	function install()
	{
		//create options
		add_option('vk_share_button_type', 'round');
		add_option('vk_share_button_text', 'Save');
		add_option('vk_share_button_description', 'auto');
		add_option('vk_share_button_description_text', '');
		add_option('vk_share_button_thumbnail', '');
		add_option('vk_share_button_position', 'right');
		add_option('vk_share_button_vposition', 'top');
		
		add_option('vk_share_button_show_on_posts', TRUE);
		add_option('vk_share_button_show_on_pages', FALSE);
		add_option('vk_share_button_show_on_home', FALSE);
		add_option('vk_share_button_show_on_cats', FALSE);
		add_option('vk_share_button_show_on_tags', FALSE);
		add_option('vk_share_button_show_on_date', FALSE);
		add_option('vk_share_button_show_on_auth', FALSE);
		add_option('vk_share_button_show_on_srch', FALSE);
		
		add_option('vk_share_button_noparse', 'true');
		add_option('vk_share_button_exlude', '');
		add_option('vk_share_button_deslen', '350');
		add_option('vk_share_button_use_owncss', FALSE);
		add_option('vk_share_button_owncss', '');
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
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_home' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_cats' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_tags' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_date' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_auth' );
		register_setting( 'vksb-settings-group', 'vk_share_button_show_on_srch' );
		
		register_setting( 'vksb-settings-group', 'vk_share_button_noparse' );
		register_setting( 'vksb-settings-group', 'vk_share_button_exlude' );
		register_setting( 'vksb-settings-group', 'vk_share_button_deslen' );
		register_setting( 'vksb-settings-group', 'vk_share_button_use_owncss' );
		register_setting( 'vksb-settings-group', 'vk_share_button_owncss' );
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
		$noparse = get_option('vk_share_button_noparse');
			
		include('vk-share-button-options.php');
	}
	
	// Add VK-API script to head of each page
	function add_head()
	{
		if (!is_admin())
		{
			echo '<link rel="stylesheet" href="'.$this->plugin_url.'vk-share-button.css" type="text/css" />';
			wp_enqueue_script('vk_share_button_api_script', 'http://vkontakte.ru/js/api/share.js?5');
			//wp_enqueue_script('vk_share_button_api_script', $this->plugin_url.'vk-share-api.js');
		}
	}
	
	// Function returns the button code
	function the_button() {
		global $post;
		$link =  esc_js(get_permalink($post->ID));
		$title = esc_js($post->post_title);
		switch (get_option('vk_share_button_description')) {
			case 'auto':
				$temp = substr(strip_shortcodes(strip_tags($post->post_content)), 0, $this->deslen);
				// Sometimes substr() returns substring with strange symbol in the end which crashes esc_js()
				while (esc_js($temp) == '' && $temp != '')
					$temp = substr($temp, 0, strlen($temp)-1);
				
				$descr = esc_js($temp);
				
				if (strlen($post->post_content) > $this->deslen && $descr != '')
					$descr .= '...';
				break;
			case 'global':
				$descr = esc_js(get_option('vk_share_button_description_text'));
				break;
			case 'none':
				$descr = '';
		}
		$thumb = esc_js(get_option('vk_share_button_thumbnail'));
		$type = esc_js(get_option('vk_share_button_type'));
		// If custom buttom type selected use unconverted text
		$text = $type != 'custom' ? 
			esc_js(get_option('vk_share_button_text')) : 
			get_option('vk_share_button_text');
		$noparse = get_option('vk_share_button_noparse');
			
		$button_code = "<!-- vkontakte share button -->\r\n<script type=\"text/javascript\">\r\n<!--\r\ndocument.write(VK.Share.button(\r\n{\r\n";
		$button_code .= "  url: '$link',\r\n";
		$button_code .= "  title: '$title'"; 
		$button_code .= $descr != '' ? ",\r\n  description: '$descr'" : '';
		$button_code .= $thumb != '' ? ",\r\n  image: '$thumb'" : '';
		$button_code .= $noparse == 'true' ? ",\r\n  noparse: $noparse \r\n}, \r\n{\r\n" : "  \r\n}, \r\n{\r\n";
		$button_code .= "  type: '$type',\r\n";
		$button_code .= "  text: '$text'\r\n}));";
		$button_code .= "\r\n-->\r\n</script>\r\n<!-- / vkontakte share button -->";
		
		return $button_code;
	}

	function place_button($content) {
		// Here we place button on the page
		global $post;
		$exclude_ids = explode(",", $this->exclude);
		
		// Looking for exclusion
		foreach($exclude_ids as $id) 
			if ($post->ID == $id)
				return $content;
				
		$clear_button = $this->the_button();
		$pos = get_option('vk_share_button_position');
		$vpos = get_option('vk_share_button_vposition');
		
		if ($this->use_own_css)
			// User defined CSS
			$the_button = "<div style=\" $this->own_css \" class=\"vk-button\">\r\n$clear_button\r\n</div>";
		else
			if ($pos == 'right')
				// right alignment
				$the_button = "<div style=\"float: $pos; margin: 0 0 5px 10px; \" class=\"vk-button\">\r\n$clear_button\r\n</div>";
			else
				// left alignment
				$the_button = "<div style=\"float: $pos; margin: 0 10px 5px 0;\" class=\"vk-button\">\r\n$clear_button\r\n</div>";

		if (is_single()   && $this->show_on_post || 
			is_page() 	  && $this->show_on_page || 
			is_home() 	  && $this->show_on_home ||
			is_category() && $this->show_on_cats ||
			is_tag() 	  && $this->show_on_tags ||
			is_date()     && $this->show_on_date ||
			is_author()   && $this->show_on_auth ||
			is_search()   && $this->show_on_srch) {
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
		$mofile = dirname(__FILE__) . '/lang/' . $this->plugin_domain . '-' . get_locale() . '.mo';
		
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