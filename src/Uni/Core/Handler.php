<?php
namespace Uni\Core;

use Uni\Core\Controllers\Base;

class Handler {

	private $controller;

	public function __construct(Base $controller) {
		$this->controller = $controller;
	}

	public function process() {
		return $this->controller->getResponse();
	}
}