<?php

namespace BrunoGrosdidier\Blog\Model;

class Manager
{
    const DB_HOST = 'mysql:host=localhost;dbname=lemonologueduvosgien;charset=utf8';
    const DB_USER = 'lemonologueduvosgien';
    const DB_PASS = 'Vosgica88';

	protected function dbConnect()
	{
		$dbConnection = new \PDO(self::DB_HOST, self::DB_USER, self::DB_PASS);
		$dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $dbConnection;			
	}
}
