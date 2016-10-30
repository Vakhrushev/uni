<?php
namespace Uni\Core\Controllers;

class E404 extends Base {

	public function __construct() {
		parent::__construct();
		$this->setTemplate('show');
		$tpl = $this->getResponse();
		$tpl->set('title', 'Page not found 404');
	}
}