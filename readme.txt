=== VKontakte Share Button ===

Contributors: jackyfox
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=NRYHZVJNPGGA6
Tags: vkontakte, share, social, Post, plugin, links, page, social bookmarks, social bookmarking, bookmarking, bookmarks, bookmark
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 1.0.1

Plugin allows you to add fully customizable share button of VKontakte social network.

== Description ==

VKontakte Share Button plugin brings powerful way to add VKontakte share button for you posts and pages.

It supports all functions of VKontakte API and easy customizable:

*  You can choose one of seven button appearance types include **custom**
*  Place button on posts, pages and frontpage at will
*  Select location of button: before or after content, on the left or right
*  Exclude pages and posts by ID which should stay without buttons
*  Choose description of content: forepart of post/page or global description for all site
*  Can be used description from meta tag `description`
*  Use your own site logo image specifying link or with meta tag `image-src`

You can use the shortcode `[vk-share-button]`.

Also can be used PHP code in your template:

`<?php if (class_exists('VKShareButton'))
		  if(!isset($VKShareButton)
		      $VKShareButton = new VKShareButton();
          echo $VKShareButton->the_button() ?>`


== Installation ==

1. Upload `vkontakte-share-button.zip` to the `/wp-content/plugins/` directory
2. Unzip it
3. Activate the plugin through the *Plugins* menu in WordPress
4. Use the *Settings->VK Share Button* page to change your plugin options.

== Frequently Asked Questions ==

= How can I use custom button type? =

Just select custom button type and write html code in `Text on button` field.

= Can I translate plugin to my language =

Sure! Remember to send `.mo` and `.po` files to me through [Contact Form](http://www.jackyfox.com/vk-share-button/ "Upload form in the bottom of page")

= How can I request that you improve or add a feature? =

Visit [plugin page](http://www.jackyfox.com/vk-share-button/ "Contact form at the bottom of page") on my site and use contact form or post a comment.

= How to find page or post ID? =

At Dashboard go to Pages or Posts. Mouse over the link of any post/page and look at URL. 

*.../wp-admin/post.php?**post=3**&action=edit*

ID of this post is 3

= I am using shortcode but button looks strange =

VKontakte share button are formed as a table, so sometimes CSS of your current theme can adds paddings or borders between parts of button.
To fix this you should cover `[vk-share-button]` shortcode with `div` or `span` and use special class style `vk-button`, eg

`<div class="vk-button"> [vk-share-button] </div>`

= How to resolve the positional conflict with the TweetMeme plugin =

Simple. Add `clear: right;` property to TweetMeme CSS.

== Screenshots ==

1. Settings page
2. Settings page in Russian
3. Button types examples
4. Share Button in action

== Changelog ==
= 1.0.1 =
* Пофиксен баг при выполнении javascript'a кнопки, возникающий из-за «лишней» запятой.

= 1.0.0.43 =
* Устанен баг «expected identifier string or number», возникающий в IE при разрешении дополнительного API-запроса. [Николай](http://education.ua/), спасибо!

= 1.0.0.42 =
* Перевод страницы настроек плагина на украинский выполнен [Юрком Червоным](http://skinik.name/)

= 1.0.0.41 =
* Теперь кнопку можно размещать на страницах архивов категорий, меток, авторов и страницы поиска

= 1.0.0.38 =
* Custom CSS

= 1.0.0.36 =
* Now you can enable the buttons on the frontpage
* Auto description length is customizable

= 1.0.0.35 =
* Fixed bug with three dots instead of the description in Auto mode.

= 1.0.0.34 =
* Now you can use shorcode [vk-share-button]

= 1.0.0.31 =
* Excluding pages and posts by ID
* Three dots at the end of long auto descriprion

= 1.0.0.30 =
* CSS fix for button structure
* Tested on WP 3.0-beta2-14576

= 1.0.0.28 =
* First public release

== Upgrade Notice ==
= 1.0.1 =
Рекомендую обновить плагин, так как старая версия при определенной настройке приводит к ошибке в javascript, формирующем кнопку.
Извините =)

= 1.0.0.43 =
Если вас беспокоит сообщение об ошибке «expected identifier string or number» в Internet Explorer, обновитесь.

= 1.0.0.42 =
Доступен перевод страницы настроек на украинский язык.

= 1.0.0.38 =
If you were dissatisfied with the standard settings, now you can use your own CSS.

= 1.0.0.36 =
If you want see the buttons on the frontpage and change the length of auto description you should upgrade.

= 1.0.0.35 =
Upgrade if you get "..." instead of the description in Auto mode.

= 1.0.0.31 =
New features. See changelog

= 1.0.0.30 =
If you have problem with spaces between parts of the button you should upgrade
