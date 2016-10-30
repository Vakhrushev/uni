<?php
namespace Uni\Prj;

use FastRoute;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Uni\Core\Route\Router;

class FastRouter extends Router {

	private $routeInfo;

	public function __construct() {
		$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
			// HOME
			$r->addRoute('GET', '/', '\Uni\Prj\Controllers\Home');
			$r->addRoute('GET', '/logout[/]', '\Uni\Prj\Controllers\Logout');

			$r->addRoute('GET', '/js/lists[/]', '\Uni\Prj\Controllers\Lists');
			$r->addRoute('GET', '/js/contact[/]', '\Uni\Prj\Controllers\Contact');
			$r->addRoute('GET', '/js/login[/]', '\Uni\Prj\Controllers\Login');
			$r->addRoute('POST', '/js/singup[/]', '\Uni\Prj\Controllers\SingUp');
		});
		$httpMethod = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];
		if (false !== $pos = strpos($uri, '?')) {
			$uri = substr($uri, 0, $pos);
		}
		$uri = rawurldecode($uri);

		$this->routeInfo = $dispatcher->dispatch($httpMethod, $uri);
	}

	public function getController() {
		$result = $this->getController404();
		if (is_array($this->routeInfo) && array_key_exists(0, $this->routeInfo)) {
			switch ($this->routeInfo[0]) {
				case Dispatcher::NOT_FOUND:
					$result = $this->getController404();
					break;
				case Dispatcher::METHOD_NOT_ALLOWED:
					$result = $this->getController405();
					break;
				case Dispatcher::FOUND:
					$result = $this->routeInfo[1];
					break;
			}
		}
		return $result;
	}

	public function getArgs() {
		$args = array();
		if (!empty($this->routeInfo[2])) {
			$args = $this->routeInfo[2];
		}
		return $args;
	}

	public function getController404() {
		return '\Uni\Prj\Controllers\E404';
	}

	public function getController405() {
		return '\Uni\Prj\Controllers\E405';
	}
}
