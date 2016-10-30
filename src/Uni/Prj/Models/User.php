<?php
namespace Uni\Prj\Models;

use Uni\Core\Models\Base;

class User extends Base {

	public function getCurrent() {
		$sql = 'SELECT
		            id,
		            name
                FROM users
                WHERE session_id = :session_id;';
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(
			':session_id' => session_id()
		));
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

	public function getUserByName($name) {
		$sql = 'SELECT
		            id,
		            name,
		            password
                FROM users
                WHERE name = :name;';
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(
			':name' => $name
		));
		return $sth->fetch(\PDO::FETCH_ASSOC);
	}

	public function getAll() {
		$sql = 'SELECT
		            id,
		            name,
		            dt_create
                FROM users
                ORDER BY id DESC;';
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		return $sth->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function isNameExist($name) {
		$sql = 'SELECT COUNT(id) as count 
				FROM users 
				WHERE name = :name';
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array(':name' => $name));
		return (int)$sth->fetchColumn(0) > 0;
	}

	public function add($data) {
		$sql = 'INSERT INTO users (name, password, session_id)
				VALUES (:name,:password,:session_id);';
		$sth = $this->dbh->prepare($sql);
		$opitions = array(
			'cost' => 12
		);
		$result = $sth->execute(array(
			':name' => $data['name'],
			':password' => password_hash($data['pass'], PASSWORD_BCRYPT, $opitions),
			':session_id' => session_id(),
		));
		if ($result) {
			return $this->dbh->lastInsertId();
		} else {
			return 0;
		}
	}

	public function login($id) {
		$sql = 'UPDATE users  
				SET session_id = :session_id 
				WHERE id = :id;';
		$sth = $this->dbh->prepare($sql);
		return $sth->execute(array(
			':session_id' => session_id(),
			':id' => (int)$id,
		));
	}
	public function logout() {
		$current = $this->getCurrent();
		if ($current) {
			$sql = 'UPDATE users  
				SET session_id = :session_id 
				WHERE id = :id;';
			$sth = $this->dbh->prepare($sql);
			return $sth->execute(array(
				':session_id' => '',
				':id' => (int)$current['id'],
			));
		}
	}
}