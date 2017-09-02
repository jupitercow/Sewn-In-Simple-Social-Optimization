# Sewn In Simple Social Optimization

A very simple SEO interface to update Twitter and Facebook meta tags.


## Description

Adds a fast, simple interface for adding Social Media meta data to pages and posts. Designed to remove all of the extra stuff that you just won't use. It is made to be straight forward for users with no confusing extras and no annoying ads. So you can enjoy using it and feel comfortable putting it before a client.

This can be used on its own, but it is more powerful when used with the [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) plugin.

*	Choose which post types it is added to (public post types by default)
*	Integrates nicely with the [Sewn In Simple SEO](https://wordpress.org/plugins/sewn-in-simple-seo/) plugin, so they get merged into one panel for editing

Very simple, no cruft or extra features you won't use.


## Control what post types are added

```php
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
```
