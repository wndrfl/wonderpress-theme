<?php
namespace Wonderpress\Partials;

use Wonderpress\Partials\AbstractPartial;

class Image extends AbstractPartial
{
	protected
		$_properties = [
			'class' => [
				'description' => 'The class for the image element',
				'format' => 'string|array',
				'required' => false,
			],
			'alt' => [
				'description' => 'Alternative text for the image',
				'format' => 'string',
				'required' => false,
			],
			'size' => [
				'description' =>  'The default WP Image size',
				'format' => 'string',
				'required' => false,
			],
			'src' => [
				'description' =>  'The image src attribute',
				'format' => 'string',
				'required' => true,
			],
			'srcset' => [
				'description' =>  'A srcset for a <picture> element',
				'format' => 'array',
				'required' => false,
			],
			'attributes' =>  [
				'description' => 'An array of arbitrary attributes for the DOM element',
				'format' => 'array',
				'required' => false,
			]
		];

	public function __construct(array $params=[])
	{
		// Check to see if a preferred size was passed.
		$class = ( isset( $params['class'] ) ) ? $params['class'] : [];
		$this->class = (is_array($class)) ? implode(' ', $class) : [];

		// Check to see if a preferred size was passed.
		$this->size = ( isset( $params['size'] ) ) ? $params['size'] : 'large';

		// Check for and generate a srcset
		$this->srcset = ( isset( $params['srcset'] ) ) ? $params['srcset'] : array();

		// Check for an alt tag.
		$this->alt = ( isset( $params['alt'] ) ) ? $params['alt'] : null;

		// Check for a src (this will not be used if $srcs exists).
		$this->src = ( isset( $params['src'] ) ) ? $params['src'] : null;

		// Set arbitrary attributes for the button (such as data attributes).
		$this->attributes = ( isset( $params['attributes'] ) && is_array( $params['attributes'] ) ) ? $params['attributes'] : array();
	}

	public function render_into_template()
	{
		// If there are multiple sources, use the <picture> element.
		if ( $this->srcset ) {
		?>
		<picture>
			<?php foreach ( $this->srcset as $min => $src ) { ?>
			<source media="(min-width:<?php echo esc_attr( $min ); ?>px)" srcset="<?php echo esc_url( $src ); ?>">
			<?php } ?>
			<img src="<?php echo esc_url( reset( $srcs ) ); ?>" class="<?php echo esc_attr( ( isset( $this->class ) ) ? $this->class : '' ); ?>"
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
			class="<?php echo esc_attr( ( isset( $this->class ) ) ? $this->class : '' ); ?>"
			alt="<?php echo esc_attr( $this->alt ); ?>" loading="lazy"
			<?php foreach ( $this->attributes as $attribute => $value ) { ?>
				<?php echo esc_html( $attribute ); ?>="<?php echo esc_attr( $value ); ?>"
			<?php } ?>
			/>
		<?php }
	}
}