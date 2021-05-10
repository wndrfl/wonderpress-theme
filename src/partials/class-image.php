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
		$classes = ( isset( $params['classes'] ) ) ? $params['classes'] : array();
		$this->classes = ( is_array( $classes ) ) ? implode( ' ', $classes ) : $classes;

		// Check to see if a preferred size was passed.
		$this->size = ( isset( $params['size'] ) ) ? $params['size'] : 'large';

		// Check for and generate a srcset
		$this->srcset = ( isset( $params['srcset'] ) ) ? $params['srcset'] : array();

		// Check for an alt tag.
		$this->alt = ( isset( $params['alt'] ) ) ? $params['alt'] : null;

		// Check for a src (this will not be used if $srcs exists).
		$this->src = ( isset( $params['src'] ) ) ? $params['src'] : null;

		// Set arbitrary attributes for the element (such as data attributes).
		$this->attributes = ( isset( $params['attributes'] ) && is_array( $params['attributes'] ) ) ? $params['attributes'] : array();
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
			<img src="<?php echo esc_url( reset( $srcs ) ); ?>" class="<?php echo esc_attr( ( isset( $this->classes ) ) ? $this->classes : '' ); ?>"
				alt="<?php echo esc_attr( $this->alt ); ?>" loading="lazy"
				<?php foreach ( $this->attributes as $attribute => $value ) { ?>
					<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
				<?php } ?>
				/>
		</picture>
			<?php
			// If we only have a single src, use a traditional <img> element.
		} else {
			?>
		<img src="<?php echo esc_url( $this->src ); ?>"
			class="<?php echo esc_attr( ( isset( $this->classes ) ) ? $this->classes : '' ); ?>"
			alt="<?php echo esc_attr( $this->alt ); ?>" loading="lazy"
			<?php foreach ( $this->attributes as $attribute => $value ) { ?>
				<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
			<?php } ?>
			/>
			<?php
		}
	}
}
