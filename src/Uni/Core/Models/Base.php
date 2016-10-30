<?php
namespace Uni\Core\Models;

use Uni\App;

class Base {

	protected $dbh;

	public function __construct() {
		$type = App::$config->get(DB_TYPE);
		$name = App::$config->get(DB_NAME);
		$host = App::$config->get(DB_HOST);
		$user = App::$config->get(DB_USER);
		$pass = App::$config->get(DB_PASS);

		$this->dbh = new \PDO($type . ':host=' . $host . ';dbname=' . $name, $user, $pass);
	}

	public function __destruct() {
		$this->dbh = null;
	}
}