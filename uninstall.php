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
delete_option('vk_share_button_show_on_cats');
delete_option('vk_share_button_show_on_tags');
delete_option('vk_share_button_show_on_date');
delete_option('vk_share_button_show_on_auth');
delete_option('vk_share_button_show_on_srch');

delete_option('vk_share_button_noparse');
delete_option('vk_share_button_exlude');
delete_option('vk_share_button_deslen');
delete_option('vk_share_button_use_owncss');
delete_option('vk_share_button_owncss');
?>