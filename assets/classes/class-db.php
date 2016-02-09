<?php

class DB
{
  private $errors  = null;
  public  $instance;

	public function __construct()
	{
  	try
  	{
    	$pdo = new PDO( 'mysql:host=localhost; db_name='.DB_NAME , DB_USER, DB_PASSWORD );
  	  $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
  		$pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
  		$pdo->setAttribute( PDO::ATTR_STRINGIFY_FETCHES, false );
  		$pdo->exec('USE '. DB_NAME.';');

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