<?php
namespace Uni\Core\Route;

abstract class Router {

	abstract public function getController();

	abstract public function getArgs();

	public function getController404() {
		return '\Uni\Core\Controllers\E404';
	}
}