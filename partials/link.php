<?php
/**
 * A reusable template for a link
 *
 * This template should be used in 1 of 2 ways. See below;
 *
 * OPTION 1 (manual entry). Pass all attributes required to generate the image, like so:
 * 
 * 	wonder_include_template_file(
 * 		'partials/link.php',
 * 		array(
 * 			'accessibility_title' => <string>,
 * 			'attributes' => <associative_array>,
 * 			'class' => <string|array>,
 * 			'link_type' => <string:'email'>,
 * 			'open_in_new_tab' => <boolean>,
 * 			'text' => <string>,
 * 			'url' => <string>,
 * 		)
 * 	);
 * 
 * OPTION 2 (ACF only): If the template is utilizing ACF, you may simply pass in an
 * ACF image field, and the template will apply sane defaults:
 * 
 * 	wonder_include_template_file(
 * 		'partials/link.php',
 * 		array(
 * 			'acf' => get_field('acf_component-name'),
 * 		)
 * 	);
 * 
 * @package Wonderpress Theme
**/

// Check to see if an image object was passed (optional)
$acf = ( class_exists( 'ACF' ) && isset( $acf ) ) ? $acf : null;

// Get the url
$url = ( isset( $url ) ) ? $url : null;
if ( ! $url && isset( $acf ) ) {
	$url = ( isset( $acf['url'] ) ) ? $acf['url'] : $url;
}

// If the type is "email", then prepend mailto:
if (
	( isset( $link_type ) && 'email' == $link_type ) ||
	( isset( $acf ) && $acf && isset( $acf['link_type'] ) && 'email' == $acf['link_type'] )
) {
	$url = 'mailto:' . $url;
}

// Check to see if the $url is a Page ID
if ( is_numeric( $url ) ) {
	$url = get_permalink( $url );
}

// Determine class attribute structure.
$class = ( isset( $class ) ) ? $class : null;
if ( ! $class && isset( $acf ) ) {
	$class = ( isset( $acf['class'] ) ) ? $acf['class'] : $class;
}
$class = ( is_array( $class ) ) ? implode( ' ', $class ) : $class;

// Set arbitrary attributes for the button (such as data attributes).
// Note: this is not currently available in the CMS.
$attributes = ( isset( $attributes ) && is_array( $attributes ) ) ? $attributes : array();

// Determine whether or not this link should open in a new tab
$open_in_new_tab = ( isset( $open_in_new_tab ) ) ? (bool) $open_in_new_tab : false;
if ( ! $open_in_new_tab && isset( $acf ) && $acf ) {
	$open_in_new_tab = ( isset( $acf['open_in_new_tab'] ) ) ? $acf['open_in_new_tab'] : $open_in_new_tab;
}

// Get the content to display in this link
$content = ( isset( $content ) ) ? $content : null;
if ( ! $content && $acf ) {
	$content = ( isset( $acf['content'] ) ) ? $acf['content'] : $content;
}

// Get the title to use for this link
$accessibility_title = ( isset( $accessibility_title ) ) ? $accessibility_title : null;
if ( ! $accessibility_title && isset( $acf ) && $acf ) {
	$accessibility_title = ( isset( $acf['accessibility_title'] ) ) ? $acf['accessibility_title'] : strip_tags($content);
}
$accessibility_title = ( $accessibility_title ) ? $accessibility_title : $content;
?>
<a href="<?php echo esc_url( $url ); ?>"
	<?php
	if ( $class ) {
		?>
		 class="<?php echo esc_attr( $class ); ?>"<?php } ?>
	<?php
	if ( $accessibility_title ) {
		?>
		 aria-label="<?php echo esc_attr( $accessibility_title ); ?>"<?php } ?>
	<?php
	if ( $accessibility_title ) {
		?>
		 title="<?php echo esc_attr( $accessibility_title ); ?>"<?php } ?>
	<?php if ( $open_in_new_tab ) { ?>
		target="_blank"
	<?php } ?>
	<?php foreach ( $attributes as $attribute => $value ) { ?>
		<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
	<?php } ?>
   role="link"
>
	<?php
	echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	?>
</a>