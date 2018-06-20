<?php

function myhome_child_enqueue_styles() {
	$options = get_option('myhome_redux');
	$dependency_parent = array();
	$dependency_child = array('myhome-style');
	if (!is_rtl()) {
		$parent_style = '/style.min.css';
	} else {
		$parent_style = '/style-rtl.min.css';
	}
	if (!isset($options['mh-performance_css']) || empty($options['mh-performance_css'])) {
		$dependency_parent[] = 'normalize';
		$dependency_child[] = 'normalize';
		if (!is_rtl()) {
			$parent_style = '/style.css';
		} else {
			$parent_style = '/style-rtl.css';
		}
	}

	wp_enqueue_style('myhome-style', get_template_directory_uri() . $parent_style, $dependency_parent, My_Home_Theme()->version);
	wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', $dependency_child, My_Home_Theme()->version);
}

add_action('wp_enqueue_scripts', 'myhome_child_enqueue_styles');

function myhome_lang_setup() {
	load_child_theme_textdomain('myhome', get_stylesheet_directory() . '/languages');
}

add_action('after_setup_theme', 'myhome_lang_setup');

// Remove WP Version From Styles
add_filter('style_loader_src', 'sdt_remove_ver_css_js', 9999);
// Remove WP Version From Scripts
add_filter('script_loader_src', 'sdt_remove_ver_css_js', 9999);

// Function to remove version numbers
function sdt_remove_ver_css_js($src) {
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}

	return $src;
}

/**
* Customizing the Login Form
* Change the Login Logo
* @author Jacktator
* @see https://codex.wordpress.org/Customizing_the_Login_Form
*/
function customize_login_logo() { ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url(https://andy.sk8tech.io/wp-content/uploads/2018/05/temp-logo-horizontal.png);
			height:50px;
			width:320px;
			background-size: 320px 50px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'customize_login_logo' );

function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Andi Shi';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );