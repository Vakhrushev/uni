<?php
namespace Uni\Core;

class Config {

	private static $instance;

	protected function __construct() { }

	public static function getInstance() {
		if (null === self::$instance) {
			include_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'constants.php';
			self::$instance = new Config();
		}
		return self::$instance;
	}

	public function setRoot($path) {
		self::$instance->set(CINDX_ROOT, $path);
		$codeRoot = realpath($path . DU . CODE_ROOT);
		self::$instance->set(CINDX_CODE_ROOT, $codeRoot);
	}

	public function get($property) {
		if (property_exists($this, $property)) {
			return $this->$property;
		}
	}

	public function set($property, $value) {
		$this->$property = $value;
		return $this;
	}

	public function isExist($property) {
		return property_exists($this, $property);
	}
}