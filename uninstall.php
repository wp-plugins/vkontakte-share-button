<?php
if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
	exit();
	
// Delete options
delete_option('vk_share_button_type');
delete_option('vk_share_button_text');
delete_option('vk_share_button_description');
delete_option('vk_share_button_description_text');
delete_option('vk_share_button_thumbnail');
delete_option('vk_share_button_position');
delete_option('vk_share_button_vposition');
delete_option('vk_share_button_show_on_posts');
delete_option('vk_share_button_show_on_pages');
delete_option('vk_share_button_show_on_home');
delete_option('vk_share_button_noparse');
delete_option('vk_share_button_exlude');
delete_option('vk_share_button_deslen');
?>