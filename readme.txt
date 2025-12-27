=== Default Image Assistant ===
Contributors: sylvie9
Tags: featured image, default image, media, post types, automation
Requires at least: 6.3
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html

A lightweight tool that lets you assign default featured images for any post type using a simple media selector.

== Description ==

Default Image Assistant allows you to assign a default featured image for each public post type in WordPress.  
If a post has no featured image set, the plugin automatically loads the default image you assigned.

Perfect for:
* Blogs that require a fallback image
* Custom post type archives
* Editorial workflows
* Sites with large content teams

Features:
* Visual **Media Library selector** for each post type  
* Clean and modern **card-style admin UI**  
* One-click **remove default image**  
* No front-end bloat—only loads when needed  
* Works with all themes (including block themes)

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/default-image-assistant/`
2. Activate the plugin through the **Plugins** menu in WordPress
3. Go to **Settings → Default Image Assistant**
4. For each post type:
   - Click **Select Image**
   - Choose an image from the Media Library
   - Save your settings

Your default images will now be used automatically whenever a post does not have a featured image.

== Screenshots ==

1. Admin settings page listing all post types  
2. Image preview panel with Select / Remove buttons  
3. Default image applied automatically to posts without a featured image  

== Frequently Asked Questions ==

= Does this overwrite posts that already have featured images? =
No. If a post already has its own featured image, the plugin does nothing.

= Will this slow down my site? =
No. It only uses `wp_get_attachment_image()` and lightweight filters.  
No front-end scripts or styles are loaded.

= Can I assign different default images for custom post types? =
Yes. Any public post type registered via plugins or themes is supported.

= Does it support block themes (FSE)? =
Yes. It works regardless of theme type.

== Changelog ==

= 1.0 =
* Initial release
* Added media selector UI
* Added per-post-type default image storage
* Added front-end featured image fallback logic

== Upgrade Notice ==

= 1.0 =
Initial stable release.
