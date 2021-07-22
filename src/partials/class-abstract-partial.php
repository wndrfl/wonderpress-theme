<?php
/**
 * An abstract class for WonderPress Partials.
 *
 * @package Wonderpress Theme
 */

namespace Wonderpress\Partials;

use Wonderpress\Partials\Partial_Interface;

/**
 * Abstract_Partial
 * Wonderpress\Partials\Abstract_Partial
 */
abstract class Abstract_Partial implements Partial_Interface {

	/**
	 * All attributes for the template will be stored here.
	 *
	 * @var Array $_attrs
	 */
	protected $_attrs = array();

	/**
	 * A definition of all available properties.
	 *
	 * @var Array $_properties
	 */
	protected static $_properties = array();

	/**
	 * A magic method for how to handle var_dump() of this object.
	 */
	public function __debugInfo() {
		 return $this->_attrs;
	}

	/**
	 * A magic getter method.
	 *
	 * @param String $property The property to attempt to get.
	 * @throws \Exception If $property is not valid.
	 */
	public function __get( $property ) {
		if ( ! property_exists( get_called_class(), '_properties' ) || ! isset( static::$_properties[ $property ] ) ) {
			throw new \Exception( '\'' . $property . '\' is not an allowed property.' );
		}

		return isset( $this->_attrs[ $property ] ) ? $this->_attrs[ $property ] : null;
	}

	/**
	 * A magic setter method.
	 *
	 * @param String $property The property to attempt to set.
	 * @param Mixed  $value The value of the property to set.
	 * @throws \Exception If $property is not valid.
	 * @return void
	 */
	public function __set( $property, $value ) {
		if ( ! property_exists( get_called_class(), '_properties' ) || ! isset( static::$_properties[ $property ] ) ) {
			throw new \Exception( '\'' . $property . '\' is not an allowed property.' );
		}

		$attempted_type = gettype( $value );

		if ( ! $attempted_type ) {
			$_property = static::$_properties[ $property ];
			if ( isset( $_property['format'] ) ) {
				$allowed_formats = ( is_array( $_property['format'] ) ) ? $_property['format'] : explode( '|', $_property['format'] );
				if ( ! is_array( $allowed_formats ) ) {
					$allowed_formats = array( $allowed_formats );
				}

				if ( ! in_array( $attempted_type, $allowed_formats ) ) {
					throw new \Exception( 'Attempting to set a property with an invalid format: ' . $attempted_type );
				}
			}
		}

		$this->_attrs[ $property ] = $value;
	}

	/**
	 * A magic method to handle outputting this object as a string.
	 *
	 * @return Void
	 */
	public function __toString() {
		return $this->render( false );
	}

	/**
	 * Compress an HTML string to remove extra whitespaces.
	 *
	 * @param String $html An html string to compress.
	 * @return String
	 */
	public static function compress_html( $html ) {
		$html = preg_replace( '/[\n\t]+/S', '', $html );
		return $html;
	}

	/**
	 * Outputs an example code snippet for how to use this partial.
	 *
	 * @return void
	 */
	public static function example() {
		echo '<pre>';
		echo esc_html( htmlspecialchars( static::example_snippet() ) );
		echo '</pre>';
	}

	/**
	 * Outputs an explanation of each property available for this partial.
	 *
	 * @return void
	 */
	public static function explain() {
		echo '<pre>';
		var_dump( static::$_properties );
		echo '</pre>';
	}

	/**
	 * Gathers any properties that do not match configuration constraints.
	 *
	 * @return Array
	 */
	public function get_invalid_properties() {

		$invalid_properties = array();

		if ( ! isset( static::$_properties ) ) {
			return $invalid_properties;
		}

		foreach ( static::$_properties as $key => $config ) {
			if ( isset( $config['required'] ) && $config['required'] && is_null( $this->$key ) ) {
				$invalid_properties[ $key ] = $config;
				continue;
			}

			if ( ! is_null( $this->$key ) && isset( $config['format'] ) ) {
				$format_parts = explode( '|', $config['format'] );
				$is_valid = false;
				foreach ( $format_parts as $format ) {
					switch ( $format ) {
						case 'array':
							$is_valid = is_array( $this->$key );
							break;
						case 'bool':
						case 'boolean':
							$is_valid = is_bool( $this->$key );
							break;
						case 'string':
							$is_valid = is_string( $this->$key );
							break;
					}

					if ( $is_valid ) {
						break;
					}
				}

				if ( ! $is_valid ) {
					$invalid_properties[ $key ] = $config;
					continue;
				}
			}
		}

		return $invalid_properties;
	}

	/**
	 * Outputs the current contents of this partial's settings.
	 *
	 * @return void
	 */
	public function inspect() {

		$properties = array();

		foreach ( static::$_properties as $key => $config ) {
			$properties[ $key ] = ! is_null( $this->$key ) ? $this->$key : null;
		}

		echo '<pre>';
		var_dump( $properties );
		echo '</pre>';
	}

	/**
	 * Determines whether this instatiation is currently valid for output.
	 *
	 * @return Boolean
	 */
	public function is_valid() {
		return ( $this->get_invalid_properties() ) ? false : true;
	}

	/**
	 * Build and render the HTML for this partial.
	 *
	 * @param Boolean $echo Whether or not to echo the HTML or simply return it.
	 * @throws \Exception If the render_into_template method doesn't exist.
	 * @return String|Boolean
	 */
	public function render( $echo = true ) {
		if ( ! method_exists( $this, 'render_into_template' ) ) {
			throw new \Exception( 'No template provided for this partial.' );
		}

		$invalid_properties = $this->get_invalid_properties();
		if ( $invalid_properties ) {
			throw new \Exception( 'Partial is invalid, missing or invalid value for property: ' . array_key_first( $invalid_properties ) );
		}

		$html = '';
		ob_start();

		$this->render_into_template();

		$html = ob_get_contents();
		ob_end_clean();

		$html = static::compress_html( $html );

		$allowed_tags = array_merge(
			wp_kses_allowed_html( 'post' ),
			array(
				'picture' => array(),
				'source' => array(
					'media' => array(),
					'srcset' => array(),
				),
				'svg'   => array(
					'class' => array(),
					'aria-hidden' => array(),
					'aria-labelledby' => array(),
					'role' => array(),
					'xmlns' => array(),
					'width' => array(),
					'height' => array(),
					'viewbox' => array(), // <= Must be lower case!
				),
				'line'     => array(
					'x1' => array(),
					'y1' => array(),
					'x2' => array(),
					'y2' => array(),
					'stroke' => array(),
				),
				'g'     => array( 'fill' => array() ),
				'title' => array( 'title' => array() ),
				'path'  => array(
					'd' => array(),
					'fill' => array(),
					'stroke' => array(),
				),
			)
		);

		if ( ! $echo ) {
			return wp_kses( $html, $allowed_tags );
		}

		echo wp_kses( $html, $allowed_tags );

		return true;
	}
}
