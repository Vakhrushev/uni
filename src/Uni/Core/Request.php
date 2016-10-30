<?php
namespace Uni\Core;

use Uni\Core\Route\Router;

class Request {

	public function route(Router $router) {
		$controllerClassName = $router->getController();

		if (!is_subclass_of($controllerClassName, '\Uni\Core\Controllers\Base', true)) {
			$controllerClassName = $router->getController404();
		}
		$controlletClass = new $controllerClassName;
		$controlletClass->setArgs($router->getArgs());
		return new Handler($controlletClass);
	}
}