<?php
namespace Uni\Prj\Controllers;

class E404 extends \Uni\Core\Controllers\E404 {

	public function __construct() {
		parent::__construct();
		$resonse = $this->getResponse();
		$resonse->set('title', '404');
	}
}