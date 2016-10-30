<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;
use Uni\Prj\Models\User;

class Home extends Base {

	public function __construct() {
		parent::__construct();
		$userModel = new User();
		//var_dump($userModel->isNameExist('asdasd222'));
		$this->setTemplate('home');
	}
}