<?php
/**
 * MDS Twig functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package MDS_Twig
 */

if ( ! function_exists( 'mdstwig_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function mdstwig_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on MDS Twig, use a find and replace
		 * to change 'mdstwig' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'mdstwig', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'mdstwig' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'mdstwig_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'mdstwig_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mdstwig_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mdstwig_content_width', 640 );
}
add_action( 'after_setup_theme', 'mdstwig_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mdstwig_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'mdstwig' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'mdstwig' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mdstwig_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mdstwig_scripts() {
	wp_enqueue_style( 'mdstwig-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mdstwig-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mdstwig-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mdstwig_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
/*-----------------------------------------------------------------------------------*/
/* Cleanup the WP Head
/*-----------------------------------------------------------------------------------*/

function clear_head () {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    add_filter('the_generator', '__return_false');
    add_filter('show_admin_bar','__return_false');
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action('after_setup_theme', 'clear_head');

/*-----------------------------------------------------------------------------------*/
/* Timber Settings
/*-----------------------------------------------------------------------------------*/

add_filter('timber_context', 'add_to_context');
function add_to_context($data){

  $data['menu'] = new TimberMenu();
  $data['categories'] = Timber::get_terms('category', 'show_count=0&title_li=&hide_empty=0&exclude=1');
  return $data;
}
/*-----------------------------------------------------------------------------------*/
/* Register Navigation Menus
/*-----------------------------------------------------------------------------------*/
function navigation_menus() {
    
        $locations = array(
            'Header Menu' => __( 'Header Menu', 'text_domain' ),
            'Mobile Menu' => __( 'Mobile Menu', 'text_domain' ),
            'Footer Company Menu' => __( 'Footer Company Menu', 'text_domain' ),
            'Footer Support Menu' => __( 'Footer Support Menu', 'text_domain' ),
        );
        register_nav_menus( $locations );
    
    }
	add_action( 'init', 'navigation_menus' );
/*-----------------------------------------------------------------------------------*/
/* Required Plugins
/*-----------------------------------------------------------------------------------*/
add_action('admin_notices', 'theme_plugin_dependencies');
function theme_plugin_dependencies($checkonly = null) {
	$theme = wp_get_theme();
	$author = ($theme && $theme->exists() && $theme['author']) ? $theme['author'] : 'your Wordpress-theme developer';
	$format = '<div class="notice notice-error"><p>Theme-warning required plugin %s: %s</p></div>';

	$plugins = array(
		'advanced-custom-fields/acf.php' => array(
			'name' => '<a href="https://www.advancedcustomfields.com/" target="_blank">Advanced Custom Fields</a>',
			'slug' => 'advanced-custom-fields'
		),
		'contact-form-7/wp-contact-form-7.php' => array(
			'name' => '<a href="https://wordpress.org/plugins/contact-form-7/" target="_blank">Contact Form 7</a>',
			'slug' => 'contact-form-7'
        ),
		'wordpress-seo/wp-seo.php' => array(
			'name' => '<a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Yoast SEO</a>',
			'slug' => 'wordpress-seo'
		),
		'timber-library/timber.php' => array(
			'name' => '<a href="https://wordpress.org/plugins/timber-library/" target="_blank">Timber</a>',
			'slug' => 'timber-library'
		)
	);

	$out = '';
	foreach ($plugins as $plugin => $nfo) {
		if (is_wp_error(validate_plugin($plugin))) {
			if (!$nfo['slug']) {
				$out .= sprintf($format, $nfo['name'], "Please contact $author for installation instructions.");
			} else {
				$link = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $nfo['slug']), 'install-plugin_' . $nfo['slug']);
				$out .= sprintf($format, $nfo['name'], "Please <a href='$link'>install</a> this Plugin.");
			}
		} elseif (is_plugin_inactive($plugin)) {
			$link = wp_nonce_url('plugins.php?action=activate&amp;plugin=' . urlencode($plugin), 'activate-plugin_' . $plugin);
			$out .= sprintf($format, $nfo['name'], "Please <a href='$link'>activate</a> this Plugin.");
		}
	}
	if ($checkonly) return $out != '';
	echo $out;
}