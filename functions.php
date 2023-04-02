<?php
/**
 * GeneratePress.
 *
 * Please do not make any edits to this file. All edits should be done in a child theme.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Set our theme version.
define( 'GENERATE_VERSION', '3.2.4' );

if ( ! function_exists( 'generate_setup' ) ) {
	add_action( 'after_setup_theme', 'generate_setup' );
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since 0.1
	 */
	function generate_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'generatepress' );

		// Add theme support for various features.
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'status' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );

		$color_palette = generate_get_editor_color_palette();

		if ( ! empty( $color_palette ) ) {
			add_theme_support( 'editor-color-palette', $color_palette );
		}

		add_theme_support(
			'custom-logo',
			array(
				'height' => 70,
				'width' => 350,
				'flex-height' => true,
				'flex-width' => true,
			)
		);

		// Register primary menu.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'generatepress' ),
			)
		);

		/**
		 * Set the content width to something large
		 * We set a more accurate width in generate_smart_content_width()
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1200; /* pixels */
		}

		// Add editor styles to the block editor.
		add_theme_support( 'editor-styles' );

		$editor_styles = apply_filters(
			'generate_editor_styles',
			array(
				'assets/css/admin/block-editor.css',
			)
		);

		add_editor_style( $editor_styles );
	}
}

/**
 * Get all necessary theme files
 */
$theme_dir = get_template_directory();

require $theme_dir . '/inc/theme-functions.php';
require $theme_dir . '/inc/defaults.php';
require $theme_dir . '/inc/class-css.php';
require $theme_dir . '/inc/css-output.php';
require $theme_dir . '/inc/general.php';
require $theme_dir . '/inc/customizer.php';
require $theme_dir . '/inc/markup.php';
require $theme_dir . '/inc/typography.php';
require $theme_dir . '/inc/plugin-compat.php';
require $theme_dir . '/inc/block-editor.php';
require $theme_dir . '/inc/class-typography.php';
require $theme_dir . '/inc/class-typography-migration.php';
require $theme_dir . '/inc/class-html-attributes.php';
require $theme_dir . '/inc/class-theme-update.php';
require $theme_dir . '/inc/class-rest.php';
require $theme_dir . '/inc/deprecated.php';

if ( is_admin() ) {
	require $theme_dir . '/inc/meta-box.php';
	require $theme_dir . '/inc/class-dashboard.php';
}

/**
 * Load our theme structure
 */
require $theme_dir . '/inc/structure/archives.php';
require $theme_dir . '/inc/structure/comments.php';
require $theme_dir . '/inc/structure/featured-images.php';
require $theme_dir . '/inc/structure/footer.php';
require $theme_dir . '/inc/structure/header.php';
require $theme_dir . '/inc/structure/navigation.php';
require $theme_dir . '/inc/structure/post-meta.php';
require $theme_dir . '/inc/structure/sidebars.php';



function remove_plugin_updates($value) {
  return null;
}
add_filter('site_transient_update_plugins', 'remove_plugin_updates');

function remove_theme_updates($value) {
  return null;
}
add_filter('site_transient_update_themes', 'remove_theme_updates');


add_action( 'admin_menu', 'true_top_menu_page', 25 );
function true_top_menu_page(){

	add_menu_page(
		'Настройки конструктора', // тайтл страницы
		'Настройки конструктора', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'ug_ideal_admin', // ярлык страницы
		'ug_ideal_admin', // функция, которая выводит содержимое страницы
		'dashicons-admin-generic', // иконка, в данном случае из Dashicons
		7 // позиция в меню
	);

	add_submenu_page(
		'ug_ideal_admin',
		'Модульные - размеры', // тайтл страницы
		'Модульные - размеры', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'admin-modular-template-size', // ярлык страницы
		'admin_modular_template_size' // функция, которая выводит содержимое страницы
	);

	add_submenu_page(
		'ug_ideal_admin',
		'Модульные - материалы', // тайтл страницы
		'Модульные - материалы', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'admin-modular-template-mat', // ярлык страницы
		'admin_modular_template_mat' // функция, которая выводит содержимое страницы
	);

	add_submenu_page(
		'ug_ideal_admin',
		'Модульные - цены', // тайтл страницы
		'Модульные - цены', // текст ссылки в меню
		'manage_options', // права пользователя, необходимые для доступа к странице
		'admin-modular-template-price', // ярлык страницы
		'admin_modular_template_price' // функция, которая выводит содержимое страницы
	);

  // add_submenu_page(
  //   'ug_ideal_admin',
  //   'Модульные - скидки', // тайтл страницы
  //   'Модульные - скидки', // текст ссылки в меню
  //   'manage_options', // права пользователя, необходимые для доступа к странице
  //   'admin-modular-discount', // ярлык страницы
  //   'admin_modular_discount' // функция, которая выводит содержимое страницы
  // );
  add_submenu_page(
    'ug_ideal_admin',
    'Модульные - категории', // тайтл страницы
    'Модульные - категории', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-modular-categories', // ярлык страницы
    'admin_modular_categories' // функция, которая выводит содержимое страницы
  );

  add_submenu_page(
    'ug_ideal_admin',
    'Фотообои - ширина рулонов', // тайтл страницы
    'Фотообои - ширина рулонов', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-wallpaper-roll-size', // ярлык страницы
    'admin_wallpaper_roll_size' // функция, которая выводит содержимое страницы
  );

  add_submenu_page(
    'ug_ideal_admin',
    'Фотообои - фактуры и цены', // тайтл страницы
    'Фотообои - фактуры и цены', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-wallpaper-textures', // ярлык страницы
    'admin_wallpaper_textures' // функция, которая выводит содержимое страницы
  );

  add_submenu_page(
    'ug_ideal_admin',
    'Фотообои - категории', // тайтл страницы
    'Фотообои - категории', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-wallpaper-categories', // ярлык страницы
    'admin_wallpaper_categories' // функция, которая выводит содержимое страницы
  );

  add_submenu_page(
    'ug_ideal_admin',
    'Фотокаталог - слайдер', // тайтл страницы
    'Фотокаталог - слайдер', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-catalog-slider', // ярлык страницы
    'admin_catalog_slider' // функция, которая выводит содержимое страницы
  );

  add_submenu_page(
    'ug_ideal_admin',
    'Компания, контакты', // тайтл страницы
    'Компания, контакты', // текст ссылки в меню
    'manage_options', // права пользователя, необходимые для доступа к странице
    'admin-company-contacts', // ярлык страницы
    'admin_company_contacts' // функция, которая выводит содержимое страницы
  );


} 

function ug_ideal_admin () {
	include_once 'ug_ideal-includes/admin.php';
}

function admin_modular_template_size(){
	include_once 'ug_ideal-includes/admin-modular-template-size.php';
}

function admin_modular_template_mat () {
	include_once 'ug_ideal-includes/admin-modular-template-mat.php';
}

function admin_modular_template_price () {
	include_once 'ug_ideal-includes/admin-modular-template-price.php';
}

function admin_modular_discount () {
  include_once 'ug_ideal-includes/admin-modular-discount.php';
}

function admin_modular_categories () {
  include_once 'ug_ideal-includes/admin-modular-categories.php';
}

function admin_wallpaper_roll_size () {
  include_once 'ug_ideal-includes/admin-wallpaper-roll-size.php';
}

function admin_wallpaper_textures () {
  include_once 'ug_ideal-includes/admin-wallpaper-textures.php';
}

function admin_wallpaper_categories () {
  include_once 'ug_ideal-includes/admin-wallpaper-categories.php';
}

function admin_catalog_slider () {
  include_once 'ug_ideal-includes/admin-catalog-slider.php';
}

function admin_company_contacts () {
  include_once 'ug_ideal-includes/admin-company-contacts.php';
}

