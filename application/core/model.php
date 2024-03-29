<?php
class Model{
	protected $db;

	public function __construct(){
		$host = 'host';
		$db   = 'db_name';
		$user = 'user_name';
		$pass = '***';
		$charset = 'utf8';

		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];

		$this->db = new PDO($dsn, $user, $pass, $opt);
	}
}
?>
