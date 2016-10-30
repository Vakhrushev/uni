<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;
use Uni\Prj\Models\User;

class Lists extends Base {

	public function __construct() {
		parent::__construct();
		$this->actionList();
	}

	private function actionList() {
		$userModel = new User();
		$users = $userModel->getAll();
		$resonse = $this->getResponse();
		$resonse->set('data', $users);
	}
}