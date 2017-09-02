=== Sewn In Simple Social Optimization ===
Contributors: jcow, ekaj
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=jacobsnyder%40gmail%2ecom&lc=US&item_name=Jacob%20Snyder&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted
Tags: seo,search engine,meta data
Requires at least: 3.6.1
Tested up to: 4.8.1
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A very simple SEO interface to update Twitter and Facebook meta tags.


== Description ==

Adds a fast, simple interface for adding Social Media meta data to pages and posts. Designed to remove all of the extra stuff that you just won't use. It is made to be straight forward for users with no confusing extras and no annoying ads. So you can enjoy using it and feel comfortable putting it before a client.

This can be used on its own, but it is more poweful when used with the [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) plugin.

*	Choose which post types it is added to (public post types by default)
*	Integrates nicely with the [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) plugin, so they get merged into one panel for editing

Very simple, no cruft or extra features you won't use.

= Control what post types are added =

By default only pages and posts are added, but you can remove either of those and/or add more using this filter:

`
/**
 * Completely replace the post types in the XML sitemap and SEO edit functionality
 *
 * This will replace the default completely. Returns: array('news','event')
 *
 * The result is to remove 'post' and 'page' post types and to add 'news' and 
 * 'event' post types
 *
 * @param	array	$post_types	List of post types to be added to the XML Sitemap
 * @return	array	$post_types	Modified list of post types
 */
add_filter( 'sewn/seo/post_types', 'custom_sitemap_post_types' );
function custom_sitemap_post_types( $post_types ) {
	$post_types = array('news','event');
	return $post_types;
}
`


= Compatibility =

Works with the [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) plugin.


== Installation ==

*   Copy the folder into your plugins folder, or use the "Add New" plugin feature.
*   Activate the plugin via the Plugins admin page


== Frequently Asked Questions ==

= No questions yet. =


== Screenshots ==

1. The Social panel added to posts.
1. The Social panel with [Sewn In XML Sitemap](https://wordpress.org/plugins/sewn-in-xml-sitemap/) & [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) installed.


== Changelog ==

= 1.0.2 - 2017-09-02 =

*   Removed array short syntax, updated meta style.

= 1.0.1 - 2017-08-30 =

*   Added to WordPress.org Repo.

= 1.0.0 - 2017-02-29 =

*   Initial split off of the SEO plugin.

== Upgrade Notice ==

= 1.0.2 =
Removed array short syntax, so that we can now support WordPress PHP requirements (5.2.4).

= 1.0.1 =
This is the first version in the Wordpress repository.
