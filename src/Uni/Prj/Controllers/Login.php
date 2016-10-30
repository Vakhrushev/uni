<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;
use Uni\Prj\Models\User;

class Login extends Base {

	public function __construct() {
		parent::__construct();
		$this->actionLogin();
	}

	private function actionLogin() {
		$resonse = $this->getResponse();
		$userModel = new User();
		$result = array();
		$user = $userModel->getUserByName($_GET['name']);
		if ($user) {
			if (password_verify($_GET['pass'], $user['password'])) {
				$userModel->login($user['id']);
				$result = array(
					'id' =>$user['id'],
					'name' =>$user['name'],
				);
			}
		}
		$resonse->set('user', $result);
	}
}