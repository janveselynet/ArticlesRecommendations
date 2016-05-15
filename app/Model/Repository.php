<?php

namespace App\Model;

use Nette\Object;
use Dibi\Connection;


class Repository extends Object
{

	/** @var Connection */
	protected $connection;


	/**
	 * @param Connection $connection
	 */
	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}
	
}
