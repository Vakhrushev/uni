<?php
namespace Uni\Prj\Controllers;

use Uni\Core\Controllers\Base;

class Contact extends Base {

	public function __construct() {
		parent::__construct();
		$resonse = $this->getResponse();
		$resonse->set('title', 'Contacts');
		$resonse->set('data', array(
			'fio' => 'Vakhrushev Vladislav',
			'email' => 'postfor@mail.ru',
			'phone' => '+79528041879',
			'city' => 'Tomsk',
			'address' => 'st. Ivanovskogo 20',
		));
	}
}