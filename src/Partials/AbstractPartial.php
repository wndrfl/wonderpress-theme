<?php
namespace Wonderpress\Partials;

use Wonderpress\Partials\PartialInterface;

abstract class AbstractPartial implements PartialInterface
{
	protected
		$_attrs = [],
		$_properties = [];

	public function __debugInfo()
	{
		return $this->_attrs;
	}

    public function __get($property) {
        if (!property_exists($this, '_properties') || !isset($this->_properties[$property])) {
        	throw new \Exception('\'' . $property . '\' is not an allowed property.');
        }

        return $this->_attrs[$property];
    }

    public function __set($property, $value) {
        if (!property_exists($this, '_properties') || !isset($this->_properties[$property])) {
        	throw new \Exception('\'' . $property . '\' is not an allowed property.');
        }

    	$attempted_type = gettype($value);

    	if(!$attempted_type) {
	        $_property = $this->_properties[$property];
	        if(isset($_property['format'])) {
	        	$allowed_formats = (is_array($_property['format'])) ? $_property['format'] : explode('|',$_property['format']);
	        	if(!is_array($allowed_formats)) {
	        		$allowed_formats = [$allowed_formats];
	        	}

	        	if(!in_array($attempted_type, $allowed_formats)) {
	        		throw new \Exception('Attempting to set a property with an invalid format: ' . $attempted_type);
	        	}
	        }
	    }

        $this->_attrs[$property] = $value;
    }

	public function __toString()
	{
		return $this->render(false);
	}

	public function explain()
	{
		echo '<pre>';
		var_dump($this->_properties);
		echo '</pre>';
	}

	public function is_valid()
	{
		if(!isset($this->_properties)) {
			return true;
		}

		foreach($this->_properties as $key => $config) {
			if(isset($config['required']) && $config['required'] && is_null($this->$key)) {
				return false;
			}
		}

		return true;
	}

	public function render($echo = true)
	{
		if(!method_exists($this, 'render_into_template')) {
			throw new \Exception('No template provided for this partial.');
		}

		if(!$this->is_valid()) {
			throw new \Exception('Partial is invalid, missing value for property.');
		}

		if ( !$echo ) {
			$html = '';
			ob_start();
		}

		echo $this->render_into_template();

		if ( !$echo ) {
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}

		return true;
	}
}