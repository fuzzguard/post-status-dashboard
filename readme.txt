=== Post Status Dashboard ===
Contributors: fuzzguard
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=G8SPGAVH8RTBU
tags: post, status, dashboard, type, widget, dash, admin, panel, front
Requires at least: 3.9
Tested up to: 4.8
Stable tag: 1.4.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
This plugin allows you to show posts on the dashboard based on a POST STATUS.  This can be the default post status from wordpress such as:
Publish
Future
Draft
Pending
Private
Trash
Auto-draft
Inherit

This plugin will also allow you to view posts based on any post status that is registered with wordpress.  Such as POST types created by a plugin.

You can also add multiple widgets to the dashboard.  This allows you to monitor multiple post types in different widgets.

== Installation ==

1. Upload the `plugin` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' area in WordPress
1. Go to the Dashboard
1. Hover over the title bar of the 'Post Status Dashboard' widget and click 'Configure'
1. Edit the dashboard widget to display the post type you want.
1. Save the changes to the widget.
1. Click 'Add' link to add more 'Post Status Dashboard' widgets

== Frequently Asked Questions ==


= How do I configure the widget? =
You can configure the widget by hovering over the title bar of the widget in the dashboard and selecting "configure"

= Can I have more than one Post Status Dashboard widget for a different post status? =
Yes!!  This option has now been added in.  You can add more widgets by clicking on the 'Add' link on any Post Status Dashboard widget

= Can I remove Post Status Dashboard widgets?
Yes you can.  Click the 'Remove' link on any Post Status Dashboard widget to remove that widget.
NOTE:  You cannot remove the Initial Post Status Dashboard widget.  You must deactivate the plugin to remove this widget.

== Screenshots ==

1. Widget on the DashBoard
2. Configuring the Widget
3. Multiple Widgets

== Changelog ==

= 1.4.1 =
* Added in 'Confirm' function for 'Remove' PSD widget
* Added in 'Confirm function for 'Add' PSD widget

= 1.4 =
* Added in ability to add multiple widgets with different 'Status' and 'Category'.  Greatly expands use of the plugin for monitoring multiple types of posts
* Added new option "$this->postStatusOption.'_additionWidgets'"
* Added uninstall for option "$this->postStatusOption.'_additionWidgets'"
* Updated .pot files
* Updated screenshots for plugin directory
* Next version will include ability to change Dashboard Widget titles

= 1.3 =
* Added 'All Categories' to category selection
* Hide 'Categories' field on widget if no categories have been assigned to any posts.
* Fixed post status now loading all custom and default types registered with 'get_post_stati()'
* Fixed loading 'All' status'

= 1.2.1 =
* Tested with version 4.6 of WordPress

= 1.2 =
* Removed TGM Plugin Activation code from this Plugin.  No relevant plugins to recommend

= 1.1 =
* Tested with version 4.5 of WordPress
* Added TGM Plugin Activation code to recommend FuzzGuards other useful plugins
* Added uninstall file to remove all options from DB if plugin is removed.
* Added "lang" folder for localization files
* Added French, German, Spanish and Chinese translations
* Added .pot file for localization by others.  Located in "lang" folder

= 1.0 =
* Gold release

== Upgrade Notice ==
= 1.4 =
Extra options added for user to add more than one widget