<?php
namespace Uni\Core\Controllers;

use Uni\App;
use Uni\Core\Response;

class Base {

	private $args = array();
	private $response;

	public function __construct() {
		$this->response = new Response();
		$this->response->set('title', 'UNI APP');
	}

	public function setArgs(array $args) {
		$this->args = $args;
	}

	public function getArgs() {
		return $this->args;
	}

	public function setTemplate($templateName) {
		$templatePath = App::$config->get(CINDX_CODE_ROOT) . DS;
		$reflection = new \ReflectionClass($this);
		$templatePath .= str_replace('\\', DS, $reflection->getNamespaceName());
		$templatePath .= DU . 'Views' . DS . $reflection->getShortName() . DS;
		$templatePath .= $templateName . '.php';
		$templatePath = realpath($templatePath);
		$this->response->setTemplate($templatePath);
	}

	public function getResponse() {
		return $this->response;
	}
}