<?php

/**
 * @link              https://github.com/jupitercow/sewn-in-simple-social
 * @since             1.0.0
 * @package           Sewn_Social
 *
 * @wordpress-plugin
 * Plugin Name:       Sewn In Simple Social Optimization
 * Plugin URI:        https://wordpress.org/plugins/sewn-in-simple-social/
 * Description:       Adds a very simple, clean interface for controlling sharing of website content on social media sites. Currently through Facebook Open Graph and Twitter APIs.
 * Version:           1.0.2
 * Author:            Jupitercow
 * Author URI:        http://Jupitercow.com/
 * Contributor:       Jake Snyder
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sewn-seo
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$class_name = 'Sewn_Social';
if ( ! class_exists($class_name) ) :

class Sewn_Social
{
	/**
	 * The unique prefix for Sewn In.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $prefix         The string used to uniquely prefix for Sewn In.
	 */
	protected $prefix;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $settings       The array used for settings.
	 */
	protected $settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct()
	{
		$this->prefix      = 'sewn';
		$this->plugin_name = strtolower(__CLASS__);
		$this->version     = '1.0.2';
		$this->settings    = array(
			'add_frontend'      => true,
			'add_fields'        => true,
			'post_types'        => array(''),
			'field_groups'      => array(
				array(
					'id'              => $this->plugin_name,
					'title'           => __( 'Social', $this->plugin_name ),
					'fields'          => array(
						array(
							'label'         => __( 'Facebook', $this->plugin_name ),
							'name'          => 'facebook',
							'type'          => 'tab',
							'placement'     => 'top',
						),
						array(
							'label'         => __( 'Facebook Title', $this->plugin_name ),
							'name'          => 'meta_og_title',
							'type'          => 'text',
							'instructions'  => __( 'Override default SEO title for Facebook', $this->plugin_name ),
						),
						array(
							'label'         => __( 'Facebook Description', $this->plugin_name ),
							'name'          => 'meta_og_description',
							'type'          => 'textarea',
							'instructions'  => __( 'Override default SEO description for Facebook', $this->plugin_name ),
						),
						array(
							'label'         => __( 'Facebook Image', $this->plugin_name ),
							'name'          => 'meta_og_image',
							'type'          => 'file',
							'instructions'  => __( 'Override the Featured Image for Facebook. Upload / choose an image or add the URL here. Recommended size: 1200 by 630 pixels.', $this->plugin_name ),
						),
						array(
							'label'         => __( 'Twitter', $this->plugin_name ),
							'name'          => 'twitter',
							'type'          => 'tab',
							'placement'     => 'top',
						),
						array(
							'label'         => __( 'Twitter Title', $this->plugin_name ),
							'name'          => 'meta_tw_title',
							'type'          => 'text',
							'instructions'  => __( 'Override default SEO title for Facebook', $this->plugin_name ),
						),
						array(
							'label'         => __( 'Twitter Description', $this->plugin_name ),
							'name'          => 'meta_tw_description',
							'type'          => 'textarea',
							'instructions'  => __( 'Override default SEO description for Facebook', $this->plugin_name ),
						),
						array(
							'label'         => __( 'Twitter Image', $this->plugin_name ),
							'name'          => 'meta_tw_image',
							'type'          => 'file',
							'instructions'  => __( 'Override the Featured Image for Twitter. Upload / choose an image or add the URL here. Recommended size: 1024 by 512 pixels.', $this->plugin_name ),
						),
					),
					'post_types'      => array(),
					'menu_order'      => 0,
					'context'         => 'normal',
					'priority'        => 'low',
					'label_placement' => 'top',
				),
			),
		);
		$this->settings = apply_filters( "{$this->prefix}/social/settings", $this->settings );
	}

	/**
	 * Load the plugin.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function run()
	{
		add_action( 'plugins_loaded',                 array( $this, 'plugins_loaded' ) );
		add_action( 'init',                           array( $this, 'init' ) );
		add_action( 'wp_loaded',                      array( $this, 'register_field_groups' ) );
		add_filter( "{$this->prefix}/social/fields",  array( $this, 'get_fields' ) );
	}

	/**
	 * On plugins_loaded test if Sewn Im XML Sitemap should be combined in and load the meta box class.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function plugins_loaded()
	{
		if ( class_exists('Sewn_Seo') ) {
			$this->settings['add_frontend'] = false;
			$this->settings['add_fields']   = false;
		} else {
			// Load the Meta Box/Fields generator
			if ( ! class_exists('Sewn_Meta') ) {
				require_once plugin_dir_path( __FILE__ ) . 'includes/sewn-meta/sewn-meta.php';
			}

			// Load Frontend Base
			if ( ! class_exists('Sewn_Seo_Frontend') ) {
				require_once plugin_dir_path( __FILE__ ) . 'includes/class-frontend.php';
			}

			// Load Frontend Classes
			$frontend_classes = array(
				'social' => 'Sewn_Seo_Frontend_Social',
			);
			foreach ( $frontend_classes as $key => $classname ) {
				if ( ! class_exists($classname) ) {
					require_once plugin_dir_path( __FILE__ ) . "includes/class-frontend-$key.php";
					$this->frontend[$classname] = new $classname;
				}
			}
		}
	}

	/**
	 * Initialize the plugin once during run.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function init()
	{
		if ( $this->settings['add_frontend'] ) {
			/* WordPress head */
			add_action( 'wp_head',                                array( $this, 'wp_head' ), 1 );

			if ( $this->frontend ) {
				foreach( $this->frontend as $class ) {
					$class->init();
				}
			}
		}
	}

	/**
	 * wp_head
	 *
	 * If automate is turned on (default), automate the header fields.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function wp_head()
	{
		if ( apply_filters( "{$this->prefix}/social/automate_head", true ) ) {
			global $wp_query;
			$old_wp_query = null;

			if ( ! $wp_query->is_main_query() ) {
				$old_wp_query = $wp_query;
				wp_reset_query();
			}

			do_action( "{$this->prefix}/seo/head" );

			if ( ! empty( $old_wp_query ) ) {
				$GLOBALS['wp_query'] = $old_wp_query;
				unset( $old_wp_query );
			}
			return;
		}
	}

	/**
	 * Get post types.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function post_types()
	{
		$this->settings['post_types'] = get_post_types( array(
			'public' => true,
		));
		unset($this->settings['post_types']['attachment']);

		return apply_filters( "{$this->prefix}/seo/post_types", apply_filters( "{$this->prefix}_seo/post_types", $this->settings['post_types'] ) );
	}

	/**
	 * Add the meta box.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function register_field_groups()
	{
		if ( $this->settings['add_fields'] ) {
			// locations for this field group
			if ( $post_types = $this->post_types() ) {
				foreach ( $post_types as $post_type ) {
					$this->settings['field_groups'][0]['post_types'][] = $post_type;
				}
			}

			foreach ( $this->settings['field_groups'] as $field_group ) {
				do_action( "{$this->prefix}/meta/register_field_group", $field_group );
			}
		}
	}

	/**
	 * Get the fields.
	 *
	 * @since	1.0.0
	 * @return	void
	 */
	public function get_fields()
	{
		return $this->settings['field_groups'][0]['fields'];
	}
}

$$class_name = new $class_name;
$$class_name->run();
unset($class_name);

endif;
