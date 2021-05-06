<?php
/**
 * A reusable template for an SEO-friendly and accessibility-friendly image.
 *
 * This template should be used in 1 of 2 ways. See below;
 *
 * OPTION 1 (manual entry). Pass all attributes required to generate the image, like so:
 *
 *  wonder_include_template_file(
 *      'partials/image.php',
 *      array(
 *          'alt' => <string>,
 *          'attributes' => <associative_array>,
 *          'size' => <string>,
 *          'src' => <string>,
 *          'srcset' => <associative_array>,
 *      )
 *  );
 *
 * TEMPLATE USAGE:
 *
 * OPTION 2 (ACF only): If the template is utilizing ACF, you may simply pass in an
 * ACF image field, and the template will apply sane defaults:
 *
 *  wonder_include_template_file(
 *      'partials/image.php',
 *      array(
 *          'acf' => <acf_field>,
 *      )
 *  );
 *
 *
 * OPTION 3 (ACF + manual entry): You may also want to combine the attributes
 * that are provided by ACF with manually enterred attributes. For example,
 * the below snippet would override the alt text provided by ACF:
 *
 *  wonder_include_template_file(
 *      'partials/image.php',
 *      array(
 *          'acf' => <acf_field>,
 *          'alt' => 'Use this string as the alt text, instead of the text provided by ACF'
 *      )
 *  );
 *
 * @package Wonderpress Theme
 **/

// Check to see if an image object was passed (optional)
$acf = ( class_exists( 'ACF' ) && isset( $acf ) ) ? $acf : null;

// Check to see if a preferred size was passed.
$size = ( isset( $size ) ) ? $size : 'large';

// Check for and generate a srcset
// If we can't find one, we will use $src
if ( $acf && isset( $acf['sizes'] ) ) {

	$srcset = array();

	$acf_src_sizes = array(
		'medium' => array(
			'320' => 'medium',
		),
		'large' => array(
			'320' => 'medium',
			'768' => 'large',
		),
	);

	// Automatically map ACF sizes to predefined srcsets
	if ( isset( $acf_src_sizes[ $size ] ) ) {
		foreach ( $acf_src_sizes[ $size ] as $min_breakpoint => $size_name ) {
			if ( isset( $srcset[ $size_name ] ) ) {
				$srcs[ $min_breakpoint ] = $acf['sizes'][ $size_name ];
			}
		}
	}

	// ACF isn't being used. Let's look to see if $srcset was passed in
} else {
	$srcset = ( isset( $srcset ) ) ? $srcset : array();
}

// Check for an alt tag.
$alt = ( isset( $alt ) ) ? $alt : null;
if ( ! $alt && $acf && isset( $acf['alt'] ) ) {
	$alt = $acf['alt'];
}

// Check for a src (this will not be used if $srcs exists).
$src = ( isset( $src ) ) ? $src : null;
if ( ! $src && $acf && isset( $acf['sizes'][ $size ] ) ) {
	$src = $acf['sizes'][ $size ];
}

// Set arbitrary attributes for the button (such as data attributes).
$attributes = ( isset( $attributes ) && is_array( $attributes ) ) ? $attributes : array();

// If there are multiple sources, use the <picture> element.
if ( $srcset ) {
	?>
<picture>
	<?php foreach ( $srcset as $min => $src ) { ?>
	<source media="(min-width:<?php echo esc_attr( $min ); ?>px)" srcset="<?php echo esc_url( $src ); ?>">
	<?php } ?>
	<img src="<?php echo esc_url( reset( $srcs ) ); ?>" class="<?php echo esc_attr( ( isset( $class ) ) ? $class : '' ); ?>"
		alt="<?php echo esc_attr( $alt ); ?>" loading="lazy"
		<?php foreach ( $attributes as $attribute => $value ) { ?>
			<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
		<?php } ?>
		/>
</picture>
	<?php
	// If we only have a single src, use a traditional <img> element.
} else {
	?>
<img src="<?php echo esc_url( $src ); ?>"
	class="<?php echo esc_attr( ( isset( $class ) ) ? $class : '' ); ?>"
	alt="<?php echo esc_attr( $alt ); ?>" loading="lazy"
	<?php foreach ( $attributes as $attribute => $value ) { ?>
		<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
	<?php } ?>
	/>
<?php } ?>
