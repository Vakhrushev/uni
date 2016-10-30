<?php
namespace Uni\Core;

class Response {

	private $templatePath;
	private $vars = array();

	public function setTemplate($path) {
		$this->templatePath = $path;
	}

	public function get($index) {
		$result = null;
		if (array_key_exists($index, $this->vars)) {
			$result = $this->vars[$index];
		}
		return $result;
	}

	public function set($index, $value) {
		$this->vars[$index] = $value;
		return $this;
	}

	public function isExist($index) {
		return array_key_exists($index, $this->vars);
	}

	public function output() {
		if (!empty($this->templatePath)) {
			extract($this->vars, null);
			ob_start();
			$oldErrorReporting = error_reporting(-1);
			require_once $this->templatePath;
			error_reporting($oldErrorReporting);
			$content = ob_get_clean();
			echo $content;
		} else {
			echo json_encode($this->vars);
		}
	}
}