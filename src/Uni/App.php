<?php
namespace Uni;

use Uni\Core\Request;
use Uni\Prj\FastRouter;
use Uni\Prj\Models\User;
use Uni\Core\Config;

require_once __DIR__ . '/functions.php';

class App {

	public static $config;

	public function __construct(Config $config = null) {
		if (null === $config) {
			$config = Config::getInstance();
		}
		self::$config = $config;
	}

	public function start() {
		$request = new Request();
		$response = $request->route(new FastRouter())->process();

		$userModel = new User();
		$user = $userModel->getCurrent();
		$response->set('jsUser', $user);

		$response->output();
	}

	public function setConfig(Config $config = null) {
		if (null === $config) {
			$config = Config::getInstance();
		}
		return $config;
	}
}