<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;
use Uni\Prj\Models\User;

class Logout extends Base {

	public function __construct() {
		parent::__construct();
		$this->actionLogout();
	}

	private function actionLogout() {
		$userModel = new User();
		$userModel->logout();
		header('Location: /');
		exit;
	}
}