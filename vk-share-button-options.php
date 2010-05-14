<script>
//<![CDATA[
jQuery(document).ready(function($){
	$("select[name='vk_share_button_description']").change(function(){
		if ($(this).val() == 'global')
			$("textarea[name='vk_share_button_description_text']").parents("tr").fadeIn("slow");
		else 
			$("textarea[name='vk_share_button_description_text']").parents("tr").fadeOut("slow");
	});
});
//]]>
</script>
<div class="wrap">

<div style="width: 100%; float: left; margin-right: -160px;">
<div style="margin-right: 160px;">
<h2><?php _e('VKontakte Share Button Settings', $this->plugin_domain) ?></h2>

<form method="post" action="options.php">

<?php settings_fields( 'vksb-settings-group' ); ?>

<table class="form-table">
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_type"><?php _e('Button type', $this->plugin_domain) ?></label></th>
	<td><select name="vk_share_button_type" id="vk_share_button_type" value="<?php echo $vksb_type; ?>">
		<option <?php if($vksb_type == 'round') echo("selected=\"selected\""); ?> value="round"><?php _e('Rounded corners with counter', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'round_nocount') echo("selected=\"selected\""); ?> value="round_nocount"><?php _e('Rounded corners without counter', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'button') echo("selected=\"selected\""); ?> value="button"><?php _e('Sharp corners with counter', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'button_nocount') echo("selected=\"selected\""); ?> value="button_nocount"><?php _e('Sharp corners without counter', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'link') echo("selected=\"selected\""); ?> value="link"><?php _e('Text link with icon', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'link_noicon') echo("selected=\"selected\""); ?> value="link_noicon"><?php _e('Text link without icon', $this->plugin_domain) ?></option>
		<option <?php if($vksb_type == 'custom') echo("selected=\"selected\""); ?> value="custom"><?php _e('Custom', $this->plugin_domain) ?></option>
	</select>
	<span class="description"><?php _e('Choose appearance of the button', $this->plugin_domain) ?></span>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_position"><?php _e('Button horizontal position', $this->plugin_domain) ?></label></th>
	<td><select name="vk_share_button_position" id="vk_share_button_position" value="<?php echo $vksb_pos; ?>">
		<option <?php if($vksb_pos == 'right') echo("selected=\"selected\""); ?> value="right"><?php _e('Right', $this->plugin_domain) ?></option>
		<option <?php if($vksb_pos == 'left') echo("selected=\"selected\""); ?> value="left"><?php _e('Left', $this->plugin_domain) ?></option>
	</select>
	<span class="description"><?php _e('Select which side you want to display the button: right or left', $this->plugin_domain) ?></p></span>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_vposition"><?php _e('Button vertical position', $this->plugin_domain) ?></label></th>
	<td><select name="vk_share_button_vposition" id="vk_share_button_vposition" value="<?php echo $vksb_vpos; ?>">
		<option <?php if($vksb_vpos == 'top') echo("selected=\"selected\""); ?> value="top"><?php _e('On top of post', $this->plugin_domain) ?></option>
		<option <?php if($vksb_vpos == 'bottom') echo("selected=\"selected\""); ?> value="bottom"><?php _e('On bottom of post', $this->plugin_domain) ?></option>
	</select>
	<span class="description"><?php _e('Sets up before or after post/page button are shown', $this->plugin_domain) ?></p></span>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><?php _e('The Button displays on', $this->plugin_domain) ?></th>
	<td> <fieldset><legend class="screen-reader-text"><span><?php _e('The Button displays on', $this->plugin_domain) ?></span></legend><label for="vk_share_button_show_on_posts">
	<input name="vk_share_button_show_on_posts" type="checkbox" id="vk_share_button_show_on_posts" value="1" <?php checked(TRUE, $vksb_showpost); ?> />
	<?php _e('Posts', $this->plugin_domain) ?></label>
	<legend class="screen-reader-text"><span>Button are shown on</span></legend><label for="vk_share_button_show_on_pages">
	<input name="vk_share_button_show_on_pages" type="checkbox" id="vk_share_button_show_on_pages" value="1" <?php checked(TRUE, $vksb_showpage); ?> />
	<?php _e('Pages', $this->plugin_domain) ?></label>
	</fieldset></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_exlude"><?php _e('Exclude pages and posts with IDs', $this->plugin_domain) ?></label></th>
	<td><input type="text" name="vk_share_button_exlude" value="<?php echo esc_attr($this->exclude); ?>" class="regular-text" />
	<span class="description"><?php _e('Specify IDs of pages and posts which should stay without buttons (separated by commas, eg <code>4, 8, 15, 16, 23, 42</code>)', $this->plugin_domain) ?></span></td>
	</tr>

	<tr valign="top">
	<th scope="row"><label for="vk_share_button_text"><?php _e('Text on button', $this->plugin_domain) ?></label></th>
	<td><input type="text" name="vk_share_button_text" value="<?php echo esc_attr($vksb_text); ?>" class="regular-text" />
	<span class="description"><?php _e('Text are displayed on the button or html code for custom button type', $this->plugin_domain) ?></span></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_description"><?php _e('Description', $this->plugin_domain) ?></label></th>
	<td><select name="vk_share_button_description" id="vk_share_button_description" value="<?php echo $vksb_desc; ?>">
		<option <?php if($vksb_desc == 'auto') echo("selected=\"selected\""); ?> value="auto"><?php _e('Auto', $this->plugin_domain) ?></option>
		<option <?php if($vksb_desc == 'global') echo("selected=\"selected\""); ?> value="global"><?php _e('Global', $this->plugin_domain) ?></option>
		<option <?php if($vksb_desc == 'none') echo("selected=\"selected\""); ?> value="none"><?php _e('None', $this->plugin_domain) ?></option>
	</select>
	<span class="description"><?php _e('Page description. Auto - first 350 characters of post. Global - your own custom description (the same for each page). None - no description (good if you use meta tag <code>description</code>)', $this->plugin_domain) ?></span>
	</td>
	</tr>
	
	<tr valign="top" <?php if ($vksb_desc != 'global') echo("style=\"display: none;\"")?>>
	<th scope="row"><?php _e('Custom description text', $this->plugin_domain) ?></th>
	<td><p><label for="vk_share_button_description_text"><?php _e('Type global site description below', $this->plugin_domain) ?></label></p>
	<p><textarea name="vk_share_button_description_text" rows="5" cols="50" id="vk_share_button_description_text" class="large-text"><?php echo esc_attr($vksb_desc_text); ?></textarea>
	</p>
	</td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_thumbnail"><?php _e('Logo link', $this->plugin_domain) ?></label></th>
	<td><input type="text" name="vk_share_button_thumbnail" value="<?php echo esc_attr($vksb_thumb); ?>" class="regular-text" />
	<span class="description"><?php _e('Link to thumbnail logo image, e.g. <code>http://your.site/vk.png</code>', $this->plugin_domain) ?></span></td>
	</tr>
	
	<tr valign="top">
	<th scope="row"><label for="vk_share_button_noparse"><?php _e('Additional API parsing request', $this->plugin_domain) ?></label></th>
	<td><select name="vk_share_button_noparse" id="vk_share_button_noparse" value="<?php echo $noparse; ?>">
		<option <?php if($noparse == 'false') echo("selected=\"selected\""); ?> value="false"><?php _e('Enable', $this->plugin_domain) ?></option>
		<option <?php if($noparse == 'true') echo("selected=\"selected\""); ?> value="true"><?php _e('Disable', $this->plugin_domain) ?></option>
	</select>
	<span class="description"><?php _e('Allow VKontakte to send request for empty share button parameters. Useful if you use meta tag <code>description</code> or <code>&lt;link rel="image_src" href="http://mysite.com/mypic.jpg" /&gt;</code> for logo image', $this->plugin_domain) ?></p></span>
	</td>
	</tr>
</table>

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes', $this->plugin_domain) ?>" />
</p>

</form>
</div>
</div>

<div style="width: 140px; float: right; height: 260px;" id="this-donate">
	<h3><?php _e('Support', $this->plugin_domain) ?></h3>
	<!-- PayPal Donate -->
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="NRYHZVJNPGGA6">
	<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>

	<!-- Yandex Donate -->
	<table cellpadding="0" cellspacing="0" border="0" style="font: 0.8em Arial, sans-serif;"><tr><td width="116" height="77" style="border: 0; background:url(https://img.yandex.net/i/money/top-hand-blue.gif) repeat-y; text-align:center; padding: 0;" align="center" valign="bottom"><form style="margin: 0; padding: 0 0 2px;" action="https://money.yandex.ru/donate.xml" method="post"><input type="hidden" name="to" value="41001198774354"/><input type="hidden" name="s5" value="hand"/><input type="submit" value="Так держать!"/></form></td></tr><tr><td width="116" height="38" style="font-size:13px; color:black;padding: 0; border: 0; background:url(https://img.yandex.net/i/money/bg-blue.gif) repeat-y; text-align:center; padding: 5px 0;" align="center" valign="top"><b>VK Share Button</b></td></tr><tr><td style="padding: 0; border:0;"><img src="https://img.yandex.net/i/money/bottom-blue.gif" width="116" height="40" alt="" usemap="#button" border="0" /><map name="button"><area alt="Яндекс" coords="38,2,49,21" href="http://www.yandex.ru"><area alt="Яндекс.Деньги" coords="52,1,84,28" href="https://money.yandex.ru"><area alt="Хочу такую же кнопку" coords="17,29,100,40" href="https://money.yandex.ru/choose-banner.xml"></map></td></tr></table>
</div>
</div>
