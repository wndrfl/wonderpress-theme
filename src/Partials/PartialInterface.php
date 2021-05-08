<?php
namespace Wonderpress\Partials;

interface PartialInterface {
	public static function example();
	public static function explain();
	public function is_valid();
	public function render($echo=true);
	public function render_into_template();
}