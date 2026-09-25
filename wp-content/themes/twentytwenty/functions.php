<?php
/**
 * Twenty Twenty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Table of Contents:
 * Theme Support
 * Required Files
 * Register Styles
 * Register Scripts
 * Register Menus
 * Custom Logo
 * WP Body Open
 * Register Sidebars
 * Enqueue Block Editor Assets
 * Enqueue Classic Editor Styles
 * Block Editor Settings
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Twenty 1.0
 *
 * @global int    $content_width Content width.
 * @global string $wp_version    The WordPress version string.
 */
function twentytwenty_theme_support()
{

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	// Custom background color.
	add_theme_support(
		'custom-background',
		array(
			'default-color' => 'f5efe0',
		)
	);

	// Set content-width.
	global $content_width;
	if (!isset($content_width)) {
		$content_width = 580;
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// Set post thumbnail size.
	set_post_thumbnail_size(1200, 9999);

	// Add custom image size used in Cover Template.
	add_image_size('twentytwenty-fullscreen', 1980, 9999);

	// Custom logo.
	$logo_width = 120;
	$logo_height = 90;

	// If the retina setting is active, double the recommended width and height.
	if (get_theme_mod('retina_logo', false)) {
		$logo_width = floor($logo_width * 2);
		$logo_height = floor($logo_height * 2);
	}

	add_theme_support(
		'custom-logo',
		array(
			'height' => $logo_height,
			'width' => $logo_width,
			'flex-height' => true,
			'flex-width' => true,
		)
	);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'script',
			'style',
			'navigation-widgets',
		)
	);

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	/*
	 * Adds starter content to highlight the theme on fresh sites.
	 * This is done conditionally to avoid loading the starter content on every
	 * page load, as it is a one-off operation only needed once in the customizer.
	 */
	if (is_customize_preview()) {
		require get_template_directory() . '/inc/starter-content.php';
		add_theme_support('starter-content', twentytwenty_get_starter_content());
	}

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/*
	 * Adds `async` and `defer` support for scripts registered or enqueued
	 * by the theme.
	 */
	$loader = new TwentyTwenty_Script_Loader();
	if (version_compare($GLOBALS['wp_version'], '6.3', '<')) {
		add_filter('script_loader_tag', array($loader, 'filter_script_loader_tag'), 10, 2);
	} else {
		add_filter('print_scripts_array', array($loader, 'migrate_legacy_strategy_script_data'), 100);
	}
}

add_action('after_setup_theme', 'twentytwenty_theme_support');

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle SVG icons.
require get_template_directory() . '/classes/class-twentytwenty-svg-icons.php';
require get_template_directory() . '/inc/svg-icons.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-twentytwenty-customize.php';

// Require Separator Control class.
require get_template_directory() . '/classes/class-twentytwenty-separator-control.php';

// Custom comment walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-comment.php';

// Custom page walker.
require get_template_directory() . '/classes/class-twentytwenty-walker-page.php';

// Custom script loader class.
require get_template_directory() . '/classes/class-twentytwenty-script-loader.php';

// Non-latin language handling.
require get_template_directory() . '/classes/class-twentytwenty-non-latin-languages.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Registers block patterns and pattern categories.
 *
 * @since Twenty Twenty 2.8
 */
function twentytwenty_register_block_patterns()
{
	require get_template_directory() . '/inc/block-patterns.php';
}

add_action('init', 'twentytwenty_register_block_patterns');

/**
 * Registers and Enqueues Styles.
 *
 * @since Twenty Twenty 1.0
 * @since Twenty Twenty 2.6 Enqueue the CSS file for the variable font.
 */
function twentytwenty_register_styles()
{

	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_style('twentytwenty-style', get_stylesheet_uri(), array(), $theme_version);
	wp_style_add_data('twentytwenty-style', 'rtl', 'replace');

	// Enqueue the CSS file for the variable font, Inter.
	wp_enqueue_style('twentytwenty-fonts', get_theme_file_uri('/assets/css/font-inter.css'), array(), $theme_version, 'all');

	// Add output of Customizer settings as inline style.
	$customizer_css = twentytwenty_get_customizer_css('front-end');
	if ($customizer_css) {
		wp_add_inline_style('twentytwenty-style', $customizer_css);
	}

	// Add print CSS.
	wp_enqueue_style('twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print');
}

add_action('wp_enqueue_scripts', 'twentytwenty_register_styles');

/**
 * Registers and Enqueues Scripts.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_register_scripts()
{

	$theme_version = wp_get_theme()->get('Version');

	if ((!is_admin()) && is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	/*
	 * This script is intentionally printed in the head because it involves the page header. The `defer` script loading
	 * strategy ensures that it does not block rendering; being in the head it will start loading earlier so that it
	 * will execute sooner once the DOM has loaded. The $args array is not used here to avoid unintentional footer
	 * placement in WP<6.3; the wp_script_add_data() call is used instead.
	 */
	wp_enqueue_script('twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version);
	wp_script_add_data('twentytwenty-js', 'strategy', 'defer');
}

add_action('wp_enqueue_scripts', 'twentytwenty_register_scripts');

/**
 * Fixes skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @since Twenty Twenty 1.0
 * @deprecated Twenty Twenty 2.3 Removed from wp_print_footer_scripts action.
 *
 * @link https://git.io/vWdr2
 */
function twentytwenty_skip_link_focus_fix()
{
	// The following is minified via `terser --compress --mangle -- assets/js/skip-link-focus-fix.js`.
	?>
	<script>
		/(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function () {var t, e = location.hash.substring(1); /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus())}, !1);
	</script>
	<?php
}

/**
 * Enqueues non-latin language styles.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_non_latin_languages()
{
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css('front-end');

	if ($custom_css) {
		wp_add_inline_style('twentytwenty-style', $custom_css);
	}
}

add_action('wp_enqueue_scripts', 'twentytwenty_non_latin_languages');

/**
 * Registers navigation menus.
 *
 * This theme uses wp_nav_menu() in five places.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_menus()
{

	$locations = array(
		'primary' => __('Desktop Horizontal Menu', 'twentytwenty'),
		'expanded' => __('Desktop Expanded Menu', 'twentytwenty'),
		'mobile' => __('Mobile Menu', 'twentytwenty'),
		'footer' => __('Footer Menu', 'twentytwenty'),
		'social' => __('Social Menu', 'twentytwenty'),
	);

	register_nav_menus($locations);
}

add_action('init', 'twentytwenty_menus');

/**
 * Gets the information about the logo.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $html The HTML output from get_custom_logo() (core function).
 * @return string Custom logo HTML with "retina" resolution applied if enabled.
 */
function twentytwenty_get_custom_logo($html)
{

	$logo_id = get_theme_mod('custom_logo');

	if (!$logo_id) {
		return $html;
	}

	$logo = wp_get_attachment_image_src($logo_id, 'full');

	if ($logo) {
		// For clarity.
		$logo_width = esc_attr($logo[1]);
		$logo_height = esc_attr($logo[2]);

		// If the retina logo setting is active, reduce the width/height by half.
		if (get_theme_mod('retina_logo', false)) {
			$logo_width = floor($logo_width / 2);
			$logo_height = floor($logo_height / 2);

			$search = array(
				'/width=\"\d+\"/iU',
				'/height=\"\d+\"/iU',
			);

			$replace = array(
				"width=\"{$logo_width}\"",
				"height=\"{$logo_height}\"",
			);

			// Add a style attribute with the height, or append the height to the style attribute if the style attribute already exists.
			if (false === strpos($html, ' style=')) {
				$search[] = '/(src=)/';
				$replace[] = "style=\"height: {$logo_height}px;\" src=";
			} else {
				$search[] = '/(style="[^"]*)/';
				$replace[] = "$1 height: {$logo_height}px;";
			}

			$html = preg_replace($search, $replace, $html);

		}
	}

	return $html;
}

add_filter('get_custom_logo', 'twentytwenty_get_custom_logo');

if (!function_exists('wp_body_open')) {

	/**
	 * Shim for wp_body_open(), ensuring backward compatibility with versions of WordPress older than 5.2.
	 *
	 * @since Twenty Twenty 1.0
	 */
	function wp_body_open()
	{
		/**
		 * Triggered after the opening <body> tag.
		 *
		 * @since Twenty Twenty 1.0
		 */
		do_action('wp_body_open');
	}
}

/**
 * Include a skip to content link at the top of the page so that users can bypass the menu.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_skip_link()
{
	echo '<a class="skip-link screen-reader-text" href="#site-content">' .
		/* translators: Hidden accessibility text. */
		__('Skip to the content', 'twentytwenty') .
		'</a>';
}

add_action('wp_body_open', 'twentytwenty_skip_link', 5);

/**
 * Registers widget areas.
 *
 * @since Twenty Twenty 1.0
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function twentytwenty_sidebar_registration()
{

	// Arguments used in all register_sidebar() calls.
	$shared_args = array(
		'before_title' => '<h2 class="widget-title subheading heading-size-3">',
		'after_title' => '</h2>',
		'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
		'after_widget' => '</div></div>',
	);

	// Footer #1.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name' => __('Footer #1', 'twentytwenty'),
				'id' => 'sidebar-1',
				'description' => __('Widgets in this area will be displayed in the first column in the footer.', 'twentytwenty'),
			)
		)
	);

	// Footer #2.
	register_sidebar(
		array_merge(
			$shared_args,
			array(
				'name' => __('Footer #2', 'twentytwenty'),
				'id' => 'sidebar-2',
				'description' => __('Widgets in this area will be displayed in the second column in the footer.', 'twentytwenty'),
			)
		)
	);
}

add_action('widgets_init', 'twentytwenty_sidebar_registration');

/**
 * Enqueues supplemental block editor styles.
 *
 * @since Twenty Twenty 1.0
 * @since Twenty Twenty 2.4 Removed a script related to the obsolete Squared style of Button blocks.
 * @since Twenty Twenty 2.6 Enqueue the CSS file for the variable font.
 */
function twentytwenty_block_editor_styles()
{

	$theme_version = wp_get_theme()->get('Version');

	// Enqueue the editor styles.
	wp_enqueue_style('twentytwenty-block-editor-styles', get_theme_file_uri('/assets/css/editor-style-block.css'), array(), $theme_version, 'all');
	wp_style_add_data('twentytwenty-block-editor-styles', 'rtl', 'replace');

	// Add inline style from the Customizer.
	$customizer_css = twentytwenty_get_customizer_css('block-editor');
	if ($customizer_css) {
		wp_add_inline_style('twentytwenty-block-editor-styles', $customizer_css);
	}

	// Enqueue the CSS file for the variable font, Inter.
	wp_enqueue_style('twentytwenty-fonts', get_theme_file_uri('/assets/css/font-inter.css'), array(), $theme_version, 'all');

	// Add inline style for non-latin fonts.
	$custom_css = TwentyTwenty_Non_Latin_Languages::get_non_latin_css('block-editor');
	if ($custom_css) {
		wp_add_inline_style('twentytwenty-block-editor-styles', $custom_css);
	}
}

/**
 * @global string $wp_version The WordPress version string.
 */
if (is_admin() && version_compare($GLOBALS['wp_version'], '6.3', '>=')) {
	add_action('enqueue_block_assets', 'twentytwenty_block_editor_styles', 1, 1);
} else {
	add_action('enqueue_block_editor_assets', 'twentytwenty_block_editor_styles', 1, 1);
}

/**
 * Enqueues classic editor styles.
 *
 * @since Twenty Twenty 1.0
 * @since Twenty Twenty 2.6 Enqueue the CSS file for the variable font.
 */
function twentytwenty_classic_editor_styles()
{

	$classic_editor_styles = array(
		'/assets/css/editor-style-classic.css',
		'/assets/css/font-inter.css',
	);

	add_editor_style($classic_editor_styles);
}

add_action('init', 'twentytwenty_classic_editor_styles');

/**
 * Output Customizer settings in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @since Twenty Twenty 1.0
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_customizer_styles($mce_init)
{

	$styles = twentytwenty_get_customizer_css('classic-editor');

	if (!$styles) {
		return $mce_init;
	}

	if (!isset($mce_init['content_style'])) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;
}

add_filter('tiny_mce_before_init', 'twentytwenty_add_classic_editor_customizer_styles');

/**
 * Output non-latin font styles in the classic editor.
 * Adds styles to the head of the TinyMCE iframe. Kudos to @Otto42 for the original solution.
 *
 * @param array $mce_init TinyMCE styles.
 * @return array TinyMCE styles.
 */
function twentytwenty_add_classic_editor_non_latin_styles($mce_init)
{

	$styles = TwentyTwenty_Non_Latin_Languages::get_non_latin_css('classic-editor');

	// Return if there are no styles to add.
	if (!$styles) {
		return $mce_init;
	}

	if (!isset($mce_init['content_style'])) {
		$mce_init['content_style'] = $styles . ' ';
	} else {
		$mce_init['content_style'] .= ' ' . $styles . ' ';
	}

	return $mce_init;
}

add_filter('tiny_mce_before_init', 'twentytwenty_add_classic_editor_non_latin_styles');

/**
 * Block Editor Settings.
 * Adds custom colors and font sizes to the block editor.
 *
 * @since Twenty Twenty 1.0
 */
function twentytwenty_block_editor_settings()
{

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name' => __('Accent Color', 'twentytwenty'),
			'slug' => 'accent',
			'color' => twentytwenty_get_color_for_area('content', 'accent'),
		),
		array(
			'name' => _x('Primary', 'color', 'twentytwenty'),
			'slug' => 'primary',
			'color' => twentytwenty_get_color_for_area('content', 'text'),
		),
		array(
			'name' => _x('Secondary', 'color', 'twentytwenty'),
			'slug' => 'secondary',
			'color' => twentytwenty_get_color_for_area('content', 'secondary'),
		),
		array(
			'name' => __('Subtle Background', 'twentytwenty'),
			'slug' => 'subtle-background',
			'color' => twentytwenty_get_color_for_area('content', 'borders'),
		),
	);

	// Add the background option.
	$background_color = get_theme_mod('background_color');
	if (!$background_color) {
		$background_color_arr = get_theme_support('custom-background');
		$background_color = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name' => __('Background Color', 'twentytwenty'),
		'slug' => 'background',
		'color' => '#' . $background_color,
	);

	// If we have accent colors, add them to the block editor palette.
	if ($editor_color_palette) {
		add_theme_support('editor-color-palette', $editor_color_palette);
	}

	// Block Editor Font Sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name' => _x('Small', 'Name of the small font size in the block editor', 'twentytwenty'),
				'shortName' => _x('S', 'Short name of the small font size in the block editor.', 'twentytwenty'),
				'size' => 18,
				'slug' => 'small',
			),
			array(
				'name' => _x('Regular', 'Name of the regular font size in the block editor', 'twentytwenty'),
				'shortName' => _x('M', 'Short name of the regular font size in the block editor.', 'twentytwenty'),
				'size' => 21,
				'slug' => 'normal',
			),
			array(
				'name' => _x('Large', 'Name of the large font size in the block editor', 'twentytwenty'),
				'shortName' => _x('L', 'Short name of the large font size in the block editor.', 'twentytwenty'),
				'size' => 26.25,
				'slug' => 'large',
			),
			array(
				'name' => _x('Larger', 'Name of the larger font size in the block editor', 'twentytwenty'),
				'shortName' => _x('XL', 'Short name of the larger font size in the block editor.', 'twentytwenty'),
				'size' => 32,
				'slug' => 'larger',
			),
		)
	);

	add_theme_support('editor-styles');

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ('#ffffff' === strtolower(twentytwenty_get_color_for_area('content', 'text'))) {
		add_theme_support('dark-editor-style');
	}
}

add_action('after_setup_theme', 'twentytwenty_block_editor_settings');

/**
 * Overwrite default more tag with styling and screen reader markup.
 *
 * @param string $html The default output HTML for the more tag.
 * @return string Read More link element, wrapped in a `div`.
 */
function twentytwenty_read_more_tag($html)
{
	return preg_replace('/<a(.*)>(.*)<\/a>/iU', sprintf('<div class="read-more-button-wrap"><a$1><span class="faux-button">$2</span> <span class="screen-reader-text">"%1$s"</span></a></div>', get_the_title(get_the_ID())), $html);
}

add_filter('the_content_more_link', 'twentytwenty_read_more_tag');

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_controls_enqueue_scripts()
{
	$theme_version = wp_get_theme()->get('Version');

	// Add main customizer js file.
	wp_enqueue_script('twentytwenty-customize', get_template_directory_uri() . '/assets/js/customize.js', array('jquery'), $theme_version);

	// Add script for color calculations.
	wp_enqueue_script('twentytwenty-color-calculations', get_template_directory_uri() . '/assets/js/color-calculations.js', array('wp-color-picker'), $theme_version);

	// Add script for controls.
	wp_enqueue_script('twentytwenty-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array('twentytwenty-color-calculations', 'customize-controls', 'underscore', 'jquery'), $theme_version);
	wp_localize_script('twentytwenty-customize-controls', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars());
}

add_action('customize_controls_enqueue_scripts', 'twentytwenty_customize_controls_enqueue_scripts');

/**
 * Enqueues scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function twentytwenty_customize_preview_init()
{
	$theme_version = wp_get_theme()->get('Version');

	wp_enqueue_script('twentytwenty-customize-preview', get_theme_file_uri('/assets/js/customize-preview.js'), array('customize-preview', 'customize-selective-refresh', 'jquery'), $theme_version, array('in_footer' => true));
	wp_localize_script('twentytwenty-customize-preview', 'twentyTwentyBgColors', twentytwenty_get_customizer_color_vars());
	wp_localize_script('twentytwenty-customize-preview', 'twentyTwentyPreviewEls', twentytwenty_get_elements_array());

	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode('cover_opacity', JSON_HEX_TAG | JSON_UNESCAPED_SLASHES),
			wp_json_encode(twentytwenty_customize_opacity_range(), JSON_HEX_TAG | JSON_UNESCAPED_SLASHES)
		)
	);
}

add_action('customize_preview_init', 'twentytwenty_customize_preview_init');

/**
 * Gets accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area    The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function twentytwenty_get_color_for_area($area = 'content', $context = 'text')
{

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content' => array(
				'text' => '#000000',
				'accent' => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders' => '#dcd7ca',
			),
			'header-footer' => array(
				'text' => '#000000',
				'accent' => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders' => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if (isset($settings[$area]) && isset($settings[$area][$context])) {
		return $settings[$area][$context];
	}

	// Return false if the option doesn't exist.
	return false;
}

/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array Customizer color variables for the preview.
 */
function twentytwenty_get_customizer_color_vars()
{
	$colors = array(
		'content' => array(
			'setting' => 'background_color',
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Gets an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array Elements to apply custom colors to.
 */
function twentytwenty_get_elements_array()
{

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content' => array(
			'accent' => array(
				'color' => array('.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a'),
				'border-color' => array('blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus'),
				'background-color' => array('button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link'),
				'fill' => array('.fill-children-accent', '.fill-children-accent *'),
			),
			'background' => array(
				'color' => array(':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)'),
				'background-color' => array(':root .has-background-background-color'),
			),
			'text' => array(
				'color' => array('body', '.entry-title a', ':root .has-primary-color'),
				'background-color' => array(':root .has-primary-background-color'),
			),
			'secondary' => array(
				'color' => array('cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color'),
				'background-color' => array(':root .has-secondary-background-color'),
			),
			'borders' => array(
				'border-color' => array('pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr'),
				'background-color' => array('caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color'),
				'border-bottom-color' => array('.wp-block-table.is-style-stripes'),
				'border-top-color' => array('.wp-block-latest-posts.is-grid li'),
				'color' => array(':root .has-subtle-background-color'),
			),
		),
		'header-footer' => array(
			'accent' => array(
				'color' => array('body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a:where(:not(.wp-block-button__link))', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover'),
				'background-color' => array('.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]'),
			),
			'background' => array(
				'color' => array('.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]'),
				'background-color' => array('#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before'),
			),
			'text' => array(
				'color' => array('.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle'),
				'background-color' => array('body:not(.overlay-header) .primary-menu ul'),
				'border-bottom-color' => array('body:not(.overlay-header) .primary-menu > li > ul:after'),
				'border-left-color' => array('body:not(.overlay-header) .primary-menu ul ul:after'),
			),
			'secondary' => array(
				'color' => array('.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.footer-credits .privacy-policy', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a'),
			),
			'borders' => array(
				'border-color' => array('.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top'),
				'background-color' => array('.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before'),
			),
		),
	);

	/**
	 * Filters Twenty Twenty theme elements.
	 *
	 * @since Twenty Twenty 1.0
	 *
	 * @param array $elements Array of elements.
	 */
	return apply_filters('twentytwenty_get_elements_array', $elements);
}
function twentytwenty_custom_comment_reply_script()
{

	if (
		is_singular()
		&& comments_open()
		&& get_option('thread_comments')
	) {
		wp_enqueue_script('comment-reply');
	}

}

add_action(
	'wp_enqueue_scripts',
	'twentytwenty_custom_comment_reply_script'
);
/**
 * Nhúng CSS Bootstrap 4 cho giao diện form comment Module 8
 */
function add_bootstrap_to_theme() {
    wp_enqueue_style( 'bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
}
add_action( 'wp_enqueue_scripts', 'add_bootstrap_to_theme' );
// --- BẮT ĐẦU: BỘ ĐẾM LƯỢT XEM (POST VIEWS) ĐỂ CHỨNG MINH BÀI VIẾT "ĐỌC NHIỀU" ---
function set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = rand(50, 150); // Khởi tạo số lượt xem ban đầu ngẫu nhiên
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, (string)$count);
    } else {
        $count = (int)$count + 1;
        update_post_meta($postID, $count_key, (string)$count);
    }
}

function get_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        return 0;
    }
    return (int)$count;
}

// Tự động đếm lượt xem khi người dùng xem bài viết chi tiết
function track_post_views($post_id) {
    if ( ! is_single() ) return;
    if ( empty($post_id) ) {
        global $post;
        $post_id = isset($post->ID) ? $post->ID : 0;
    }
    if ($post_id > 0) {
        set_post_views($post_id);
    }
}
add_action( 'wp_head', 'track_post_views' );

// 2. Thêm cột "Lượt xem" trực tiếp vào trang quản trị WP-Admin -> Bài viết (Posts)
function add_post_views_column( $columns ) {
    $columns['post_views'] = '👁️ Lượt xem';
    return $columns;
}
add_filter( 'manage_posts_columns', 'add_post_views_column' );

function show_post_views_column_data( $column, $post_id ) {
    if ( $column === 'post_views' ) {
        $views = get_post_views( $post_id );
        echo '<span style="color:#0284c7; font-weight:700;">' . number_format($views) . '</span> lượt đọc';
    }
}
add_action( 'manage_posts_custom_column', 'show_post_views_column_data', 10, 2 );

function make_post_views_column_sortable( $columns ) {
    $columns['post_views'] = 'post_views';
    return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'make_post_views_column_sortable' );

// --- TẠO WIDGET_TEST_4 CHO BÀI TẬP CMS ---
class Widget_Test_4 extends WP_Widget {
    function __construct() {
        parent::__construct(
            'widget_test_4', // ID định danh của widget
            'Widget Test 4 (Bài tập CMS)', // Tên hiển thị khi kéo thả trong Admin
            array( 'description' => __( 'Widget Tin mới / Đọc nhiều hiển thị phía trên footer - Random nội dung', 'text_domain' ) )
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        
        $unique_id = 'widget_test_4_' . uniqid();
        
        // 1. Tab "Tin mới": Lấy theo ngày đăng mới nhất (date DESC)
        $recent_db_posts = get_posts( array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'orderby'        => 'date',
            'order'          => 'DESC'
        ) );

        // 2. Tab "Đọc nhiều": Lấy theo số lượt đọc cao nhất (post_views_count DESC) và số bình luận
        // Đảm bảo các bài viết trong DB đều có trường lượt đọc để chứng minh
        if ( ! empty( $recent_db_posts ) ) {
            foreach ( $recent_db_posts as $p ) {
                $v = get_post_meta($p->ID, 'post_views_count', true);
                if ($v == '') {
                    update_post_meta($p->ID, 'post_views_count', (string)rand(30, 250));
                }
            }
        }

        $popular_db_posts = get_posts( array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 10,
            'meta_key'       => 'post_views_count',
            'orderby'        => 'meta_value_num comment_count',
            'order'          => 'DESC'
        ) );

        $news_list_1 = array(); // Tab "Tin mới"
        $news_list_2 = array(); // Tab "Đọc nhiều"

        if ( ! empty( $recent_db_posts ) ) {
            foreach ( $recent_db_posts as $p ) {
                $views = get_post_views( $p->ID );
                $news_list_1[] = array(
                    'title' => $p->post_title,
                    'link'  => get_permalink( $p->ID ),
                    'views' => $views,
                );
            }
        }

        if ( ! empty( $popular_db_posts ) ) {
            foreach ( $popular_db_posts as $p ) {
                $views = get_post_views( $p->ID );
                $news_list_2[] = array(
                    'title' => $p->post_title,
                    'link'  => get_permalink( $p->ID ),
                    'views' => $views,
                );
            }
        }

        // Dữ liệu mẫu bổ sung để danh sách luôn đầy đặn (6-8 tin) và có thanh cuộn cuộn được chuẩn theo ảnh mẫu
        $fallback_titles = array(
            'Việt Nam nhất quán coi trọng quan hệ với Canada',
            'Siết an toàn thực phẩm, bảo vệ sức khỏe người dân',
            'Lãnh đạo Đảng, Nhà nước, MTTQ tặng quà trẻ em dịp tết Trung thu',
            'Tin tức đặc biệt trên báo in Thanh Niên ' . date('d.m.Y'),
            'Nghi phạm Ukraine đâm dao tại tu viện ở Ba Lan, một linh mục thiệt mạng',
            'Việt Nam - Canada xây dựng hình mẫu hợp tác đôi bờ Thái Bình Dương',
            'Thúc đẩy tăng trưởng kinh tế số và chuyển đổi xanh bền vững',
            'Dự kiến trình Chính phủ quy định hỗ trợ người lao động cuối năm',
            'Khám phá công nghệ AI mới và giải pháp bảo mật dữ liệu',
            'Thị trường công nghệ sôi động những tháng cuối năm'
        );

        // Bổ sung vào danh sách 1 (Tin mới) nếu ít bài
        if ( count( $news_list_1 ) < 6 ) {
            foreach ( $fallback_titles as $fb_title ) {
                $news_list_1[] = array(
                    'title' => $fb_title,
                    'link'  => home_url( '/' )
                );
            }
        }

        // Bổ sung vào danh sách 2 (Đọc nhiều) nếu ít bài - giữ nguyên thứ tự bài đọc nhiều nhất (post_views_count DESC) ở trên cùng
        if ( count( $news_list_2 ) < 6 ) {
            foreach ( $fallback_titles as $fb_title ) {
                $news_list_2[] = array(
                    'title' => $fb_title,
                    'link'  => home_url( '/' )
                );
            }
        }
        ?>

        <style>
            /* Khung tổng thể Widget Test 4 */
            .widget-test-4-container {
                max-width: 440px;
                margin: 0 auto;
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 6px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
                overflow: hidden;
            }

            /* Thanh Tab: "Tin mới" | "Đọc nhiều" */
            .widget-test-4-tabs {
                display: flex;
                border-bottom: 1px solid #e5e7eb;
                background-color: #ffffff;
            }

            .widget-test-4-tab-btn {
                flex: 1;
                padding: 13px 10px;
                text-align: center;
                font-size: 15px;
                font-weight: 700;
                color: #64748b;
                cursor: pointer;
                border-bottom: 2.5px solid transparent;
                margin-bottom: -1px;
                transition: all 0.2s ease;
                user-select: none;
                background: none;
                border-top: none;
                border-left: none;
                border-right: none;
            }

            .widget-test-4-tab-btn.active {
                color: #0f172a;
                border-bottom-color: #0088cc; /* Gạch chân màu xanh dương đậm chuẩn ảnh */
            }

            .widget-test-4-tab-btn:hover:not(.active) {
                color: #334155;
                background-color: #f8fafc;
            }

            /* Khung nội dung danh sách có thanh cuộn */
            .widget-test-4-body {
                position: relative;
            }

            .widget-test-4-list {
                display: none;
                max-height: 310px;
                overflow-y: scroll;
                padding: 4px 0;
                margin: 0;
                list-style: none;
            }

            .widget-test-4-list.active {
                display: block;
            }

            /* Tùy chỉnh thanh cuộn màu xám giống ảnh mẫu */
            .widget-test-4-list::-webkit-scrollbar {
                width: 6px;
            }

            .widget-test-4-list::-webkit-scrollbar-track {
                background: #f8fafc;
            }

            .widget-test-4-list::-webkit-scrollbar-thumb {
                background: #94a3b8;
                border-radius: 3px;
            }

            .widget-test-4-list::-webkit-scrollbar-thumb:hover {
                background: #64748b;
            }

            /* Mỗi hàng bài viết */
            .widget-test-4-item {
                display: flex;
                align-items: flex-start;
                padding: 13px 18px;
                border-bottom: 1px solid #f1f5f9;
                transition: background-color 0.15s ease;
            }

            .widget-test-4-item:last-child {
                border-bottom: none;
            }

            .widget-test-4-item:hover {
                background-color: #f8fafc;
            }

            /* Icon hạt tròn nhỏ rỗng phía trước theo ảnh mẫu */
            .widget-test-4-bullet {
                display: inline-block;
                width: 6px;
                height: 6px;
                min-width: 6px;
                border: 1.5px solid #94a3b8;
                border-radius: 50%;
                margin-right: 12px;
                margin-top: 6px;
                flex-shrink: 0;
            }

            .widget-test-4-title {
                flex: 1;
                font-size: 14px;
                line-height: 1.45;
                color: #1e293b;
                text-decoration: none;
                font-weight: 400;
                transition: color 0.15s ease;
            }

            .widget-test-4-title:hover {
                color: #0088cc;
            }

            /* Nút "Xem thêm" ở chân widget */
            .widget-test-4-footer {
                padding: 10px 14px 14px 14px;
                border-top: 1px solid #f1f5f9;
                background-color: #ffffff;
            }

            .widget-test-4-btn-more {
                display: block;
                width: 100%;
                padding: 9px 0;
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 5px;
                color: #64748b;
                font-size: 13.5px;
                font-weight: 600;
                text-align: center;
                text-decoration: none;
                transition: all 0.2s ease;
                box-sizing: border-box;
            }

            .widget-test-4-btn-more:hover {
                background-color: #f1f5f9;
                color: #1e293b;
                border-color: #cbd5e1;
            }
        </style>

        <div class="widget-test-4-container" id="<?php echo esc_attr( $unique_id ); ?>">
            <!-- Thanh 2 Tabs: Tin mới | Đọc nhiều -->
            <div class="widget-test-4-tabs">
                <button type="button" class="widget-test-4-tab-btn active" data-tab="tin-moi">Tin mới</button>
                <button type="button" class="widget-test-4-tab-btn" data-tab="doc-nhieu">Đọc nhiều</button>
            </div>

            <!-- Khung danh sách bài viết -->
            <div class="widget-test-4-body">
                <!-- Tab 1: Tin mới -->
                <ul class="widget-test-4-list active" id="<?php echo esc_attr( $unique_id ); ?>_tin_moi">
                    <?php foreach ( $news_list_1 as $item ) : ?>
                        <li class="widget-test-4-item">
                            <span class="widget-test-4-bullet"></span>
                            <a href="<?php echo esc_url( $item['link'] ); ?>" class="widget-test-4-title">
                                <?php echo esc_html( $item['title'] ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Tab 2: Đọc nhiều (Random không SV nào giống nhau) -->
                <ul class="widget-test-4-list" id="<?php echo esc_attr( $unique_id ); ?>_doc_nhieu">
                    <?php foreach ( $news_list_2 as $item ) : ?>
                        <li class="widget-test-4-item">
                            <span class="widget-test-4-bullet"></span>
                            <a href="<?php echo esc_url( $item['link'] ); ?>" class="widget-test-4-title">
                                <?php echo esc_html( $item['title'] ); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Nút Xem thêm -->
            <div class="widget-test-4-footer">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="widget-test-4-btn-more">
                    Xem thêm
                </a>
            </div>
        </div>

        <script>
        (function() {
            var container = document.getElementById('<?php echo esc_js( $unique_id ); ?>');
            if (!container) return;

            var tabBtns = container.querySelectorAll('.widget-test-4-tab-btn');
            var listTinMoi = document.getElementById('<?php echo esc_js( $unique_id ); ?>_tin_moi');
            var listDocNhieu = document.getElementById('<?php echo esc_js( $unique_id ); ?>_doc_nhieu');

            tabBtns.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    tabBtns.forEach(function(b) { b.classList.remove('active'); });
                    btn.classList.add('active');

                    var tabType = btn.getAttribute('data-tab');
                    if (tabType === 'tin-moi') {
                        if (listTinMoi) listTinMoi.classList.add('active');
                        if (listDocNhieu) listDocNhieu.classList.remove('active');
                    } else {
                        if (listDocNhieu) listDocNhieu.classList.add('active');
                        if (listTinMoi) listTinMoi.classList.remove('active');
                    }
                });
            });
        })();
        </script>

        <?php
        echo $args['after_widget'];
    }
}

// Đăng ký widget với hệ thống WordPress
function register_widget_test_4() {
    register_widget( 'Widget_Test_4' );
}
add_action( 'widgets_init', 'register_widget_test_4' );
// --- KẾT THÚC CODE WIDGET ---