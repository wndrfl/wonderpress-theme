<?php
namespace Wonderpress\Partials;

interface PartialInterface {
	public function explain();
	public function is_valid();
	public function render($echo=true);
	public function render_into_template();
}