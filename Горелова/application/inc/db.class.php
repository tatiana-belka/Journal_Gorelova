<?php

class dbConnection
{
    public $dbHost = 'localhost1';
    public $dbName = 'trollfred_gbook';
    public $dbPort = '3306';
    public $dbUser = 'root';
	public $dbPass = '';
	public $dbType = 'mysql'; //mysql | sqlite | pgsql | mssql
	public $connection;

	private static $sortOrders = array('0'=>'DESC',
		'1'=>'ASC',);
	private static $sortElems = array('0' => 'postdate',
		'1' => 'username',
		'2' => 'email');
	

	public function __construct() 
	{
			$this->connection= new PDO("$this->dbType:host=$this->dbHost;port=$this->dbPort;dbname=$this->dbName",
									$this->dbUser, $this->dbPass);
			$this->connection->error = true;
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function get_page_records($page_num=0, $length=25, $sort_order=1, $sort_elem=0) {
		$sortType = "postdate";
		$sortOrd = "DESC";
		$start_record = $length * $page_num;

		if (isset(dbConnection::$sortOrders[$sort_order]) ) {
			$sortOrd = dbConnection::$sortOrders[$sort_order];
		}

		if (isset(dbConnection::$sortElems[$sort_elem]) ) {
			$sortType = dbConnection::$sortElems[$sort_elem];
		}

		$query_statement = $this->connection->prepare(
			"SELECT `username`, `postdate`, `email`,
		    INET_NTOA(ip) as ip, `message`, `useragent`,
		    `homepage`, `msgid` FROM `guest_book`
		    ORDER BY $sortType $sortOrd LIMIT $start_record, $length");

		$query_statement->execute();
		$records = $query_statement->fetchAll();
		return $records;
	}

	public function count_all_records() {
		$query_statement = $this->connection->prepare(
			"SELECT COUNT(*) AS size FROM `guest_book`;");
		$query_statement->execute();
		$result_obj = $query_statement->fetch();
		$result = $result_obj['size'];
		return $result;
	}

	public function add_record($name='LL', $mail='ldld', $ip='127.0.0.1', $home="vk.com", $msg='lol', $ua='ldf') {
		$query_statement = $this->connection->prepare(
			"INSERT INTO guest_book (msgid,username,postdate,email,ip,homepage,message, useragent)
			VALUES (NULL, :name, CURRENT_TIMESTAMP,	:mail, INET_ATON('$ip'), :home, :msg, :ua) ;"
		);

		$query_statement->bindValue(':name', $name);
		$query_statement->bindValue(':mail', $mail);
		$query_statement->bindValue(':home', $home);
		$query_statement->bindValue(':msg', $msg);
		$query_statement->bindValue(':ua', $ua);
		if ($home == '')
			$query_statement->bindValue(':home', null, PDO::PARAM_INT);
		if ($ua == '')
			$query_statement->bindValue(':ua', null, PDO::PARAM_INT);

		$query_statement->execute();
		return $this->connection->lastInsertId();
	}
}