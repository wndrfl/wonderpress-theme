<?php
/**
 * An Image partial class.
 *
 * @package Wonderpress Theme
 */

namespace Wonderpress\Partials;

use Wonderpress\Partials\Abstract_Partial;

/**
 * Image
 * Wonderpress\Partials\Image
 */
class Image extends Abstract_Partial {

	/**
	 * A definition of all available properties.
	 *
	 * @var Array $_properties
	 */
	protected static $_properties = array(
		'classes' => array(
			'description' => 'The classes for the image element',
			'format' => 'string|array',
			'required' => false,
		),
		'alt' => array(
			'description' => 'Alternative text for the image',
			'format' => 'string',
			'required' => false,
		),
		'height' => array(
			'description' => 'The height of the raw image (used for setting height=)',
			'format' => 'integer',
			'required' => false,
		),
		'size' => array(
			'description' => 'The default WP Image size',
			'format' => 'string',
			'required' => false,
		),
		'src' => array(
			'description' => 'The image src attribute',
			'format' => 'string',
			'required' => true,
		),
		'srcset' => array(
			'description' => 'A srcset for a <picture> element',
			'format' => 'array',
			'required' => false,
		),
		'width' => array(
			'description' => 'The width of the raw image (used for setting width=)',
			'format' => 'integer',
			'required' => false,
		),
		'attributes' => array(
			'description' => 'An array of arbitrary attributes for the DOM element',
			'format' => 'array',
			'required' => false,
		),
	);

	/**
	 * Constructor
	 *
	 * @param Array $params An array of values to populate the partial snippet.
	 * @return void
	 */
	public function __construct( array $params = array() ) {

		// Check to see if a preferred size was passed.
		$this->size = ( isset( $params['size'] ) ) ? $params['size'] : 'large';

		// Check for an acf convenience array
		if ( isset( $params['acf'] ) && is_array( $params['acf'] ) ) {

			$this->alt = isset( $params['acf']['alt'] ) ? $params['acf']['alt'] : null;

			$this->width = isset( $params['acf']['width'] ) ? $params['acf']['width'] : null;
			$this->height = isset( $params['acf']['height'] ) ? $params['acf']['height'] : null;

			switch ( $this->size ) {
				case 'banner':
					$this->src = isset( $params['acf']['sizes']['banner'] ) ? $params['acf']['sizes']['banner'] : null;
					$this->srcset = array(
						'1024' => isset( $params['acf']['sizes']['banner'] ) ? $params['acf']['sizes']['banner'] : $this->src,
						'768' => isset( $params['acf']['sizes']['banner'] ) ? $params['acf']['sizes']['banner'] : $this->src,
						'120' => isset( $params['acf']['sizes']['large'] ) ? $params['acf']['sizes']['large'] : $this->src,
						'0' => isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : $this->src,
					);
					break;
				case 'medium':
					$this->src = isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : null;
					$this->srcset = array(
						'1024' => isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : $this->src,
						'768' => isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : $this->src,
						'120' => isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : $this->src,
						'0' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
					);
					break;
				case 'small':
					$this->src = isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : null;
					$this->srcset = array(
						'1024' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
						'768' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
						'120' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
						'0' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
					);
					break;
				case 'large':
				default:
					$this->src = isset( $params['acf']['sizes']['large'] ) ? $params['acf']['sizes']['large'] : null;
					$this->srcset = array(
						'1024' => isset( $params['acf']['sizes']['large'] ) ? $params['acf']['sizes']['large'] : $this->src,
						'768' => isset( $params['acf']['sizes']['large'] ) ? $params['acf']['sizes']['large'] : $this->src,
						'120' => isset( $params['acf']['sizes']['medium'] ) ? $params['acf']['sizes']['medium'] : $this->src,
						'0' => isset( $params['acf']['sizes']['small'] ) ? $params['acf']['sizes']['small'] : $this->src,
					);
					break;
			}
		}

		// Check to see if a preferred size was passed.
		$classes = ( isset( $params['classes'] ) ) ? $params['classes'] : array();
		$this->classes = ( is_array( $classes ) ) ? implode( ' ', $classes ) : $classes;

		// Check for and generate a srcset
		$this->srcset = ( isset( $params['srcset'] ) ) ? $params['srcset'] : $this->srcset;

		// Check for an alt tag.
		$this->alt = ( isset( $params['alt'] ) ) ? $params['alt'] : $this->alt;

		// Check for a src (this will not be used if $srcs exists).
		$this->src = ( isset( $params['src'] ) ) ? $params['src'] : $this->src;

		// Set arbitrary attributes for the element (such as data attributes).
		$this->attributes = ( isset( $params['attributes'] ) && is_array( $params['attributes'] ) ) ? $params['attributes'] : array();

		// Set the width
		$this->width = isset( $params['width'] ) ? $params['width'] : $this->width;

		// Set the height
		$this->height = isset( $params['height'] ) ? $params['height'] : $this->height;
	}

	/**
	 * Outputs an example code snippet for how to use this partial.
	 *
	 * @return String
	 */
	public static function example_snippet() {
		$snippet = <<<EOD
		<?php
		wonder_image(array(
			'alt' => 'This is an example image',
			'src' => 'https://via.placeholder.com/150',
		), true);
		?>
		EOD;

		return $snippet;
	}

	/**
	 * An internal process to merge the property values and HTML bits into a
	 * usable HTML snippet.
	 *
	 * @return void
	 */
	public function render_into_template() {
		// If there are multiple sources, use the <picture> element.
		if ( $this->srcset ) {
			?>
		<picture>
			<?php foreach ( $this->srcset as $min => $src ) { ?>
			<source media="(min-width:<?php echo esc_attr( $min ); ?>px)" srcset="<?php echo esc_url( $src ); ?>">
			<?php } ?>
			<?php
			$srcset = $this->srcset;
			$display_image = reset( $srcset );
			?>
			<img src="<?php echo esc_url( $display_image ); ?>" class="<?php echo esc_attr( ( $this->classes ) ? $this->classes : '' ); ?>" 
				 alt="<?php echo esc_attr( $this->alt ); ?>" loading="lazy"
				<?php foreach ( $this->attributes as $attribute => $value ) { ?>
					<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
				<?php } ?>
				<?php if ( $this->width ) { ?>
					 width="<?php echo esc_attr( $this->width ); ?>"
				<?php } ?>
				<?php if ( $this->height ) { ?>
					 height="<?php echo esc_attr( $this->height ); ?>"
				<?php } ?>
				/>
		</picture>
			<?php
			// If we only have a single src, use a traditional <img> element.
		} else {
			?>
		<img src="<?php echo esc_url( $this->src ); ?>"
			 class="<?php echo esc_attr( ( $this->classes ) ? $this->classes : '' ); ?>"
			 alt="<?php echo esc_attr( $this->alt ); ?>" loading="lazy"
			<?php foreach ( $this->attributes as $attribute => $value ) { ?>
				<?php echo ' ' . esc_attr( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
			<?php } ?>
			<?php if ( $this->width ) { ?>
				 width="<?php echo esc_attr( $this->width ); ?>"
			<?php } ?>
			<?php if ( $this->height ) { ?>
				 height="<?php echo esc_attr( $this->height ); ?>"
			<?php } ?>
			/>
			<?php
		}
	}
}
