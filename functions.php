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
	wp_enqueue_style('app', get_stylesheet_directory_uri() . '/assets/scss/app.css', false, $cacheBuster);
	wp_enqueue_script('app', get_stylesheet_directory_uri() . '/assets/js/app.js', [], $cacheBuster, true);
/* 
	wp_enqueue_script( 'mdstwig-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'mdstwig-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	} */
}
add_action( 'wp_enqueue_scripts', 'mdstwig_scripts' );

/*-----------------------------------------------------------------------------------*/
/* Load WooCommerce compatibility file.
/*-----------------------------------------------------------------------------------*/
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

/*-----------------------------------------------------------------------------------*/
/* ACF Upgrade to Version 5+
/*-----------------------------------------------------------------------------------*/
define('ACF_EARLY_ACCESS', '5');

/*-----------------------------------------------------------------------------------*/
/* Includes
/*-----------------------------------------------------------------------------------*/

require get_template_directory() . '/inc/headcleanup.php';
require get_template_directory() . '/inc/theme-plugins.php';
require get_template_directory() . '/inc/registered-menus.php';
require get_template_directory() . '/inc/timber.php';