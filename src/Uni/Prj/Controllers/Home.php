<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;

class Home extends Base {

	public function __construct() {
		parent::__construct();
		$this->setTemplate('home');
	}
}