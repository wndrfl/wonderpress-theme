<?php
namespace Wonderpress\Partials;

abstract class AbstractPartial
{
	public function __construct()
	{
		
	}

	public function render()
	{
		echo "RENDER";
	}
}