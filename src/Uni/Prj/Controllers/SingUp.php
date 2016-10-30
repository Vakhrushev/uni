<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;
use Uni\Prj\Models\User;

class SingUp extends Base {

	public function __construct() {
		parent::__construct();
		$this->actionSingUp();
	}

	private function actionSingUp() {
		$resonse = $this->getResponse();
		$data = $_POST;
		$userModel = new User();

		if (empty($data['name'])) {
			$result['errors']['name'] = 'empty';
		} else {
			if ($userModel->isNameExist($data['name'])) {
				$result['errors']['name'] = 'exist';
			}
		}
		if (empty($data['pass'])) {
			$result['errors']['pass'] = 'empty';
		}

		if (empty($result['errors'])) {
			$id = $userModel->add($data);
			if ($id) {
				$result['user_id'] = $id;
				$result['status'] = true;
			}
		}

		$resonse->set('data', $result);
	}
}