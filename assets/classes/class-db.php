<?php

class db
{
  private $host    = 'mysql:host=localhost; db_name=';
  private $db_name = DB_NAME;
  private $db_user = DB_USER;
  private $db_pass = DB_PASSWORD;
  private $errors  = null;

  private static $instance;

	public function __construct()
	{
  	try
  	{
    	$pdo = new PDO( $this->host.$this->db_name , $this->db_user, $this->db_pass );
  	  $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  		$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

  		if( $pdo instanceOf PDO )
  	    $this->instance = $pdo;
  	}
  	catch ( PDOException $e )
  	{
      $this->errors = $e->getMessage();
  	}
	}

	private function __clone(){}

  private function __wakeup(){}
}