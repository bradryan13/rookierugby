<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...

	<?php if ( get_header_image() ) : ?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
		<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="">
	</a>
	<?php endif; // End header image check. ?>

 *
 * @package rookierugby
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses rookierugby_header_style()
 * @uses rookierugby_admin_header_style()
 * @uses rookierugby_admin_header_image()
 *
 * @package rookierugby
 */
function rookierugby_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'rookierugby_custom_header_args', array(
		'default-image'          => '',
		'default-text-color'     => '000',
		'width'                  => 1000,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'rookierugby_header_style',
		'admin-head-callback'    => 'rookierugby_admin_header_style',
		'admin-preview-callback' => 'rookierugby_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'rookierugby_custom_header_setup' );

if ( ! function_exists( 'rookierugby_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see rookierugby_custom_header_setup().
 */
function rookierugby_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color )
		return;

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo $header_text_color; ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // rookierugby_header_style

if ( ! function_exists( 'rookierugby_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see rookierugby_custom_header_setup().
 */
function rookierugby_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // rookierugby_admin_header_style

if ( ! function_exists( 'rookierugby_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see rookierugby_custom_header_setup().
 */
function rookierugby_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // rookierugby_admin_header_image