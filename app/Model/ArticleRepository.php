<?php

namespace App\Model;

use Dibi\Connection;


class ArticleRepository extends Repository
{

	/** @var ArticleFactory */
	private $articleFactory;

	/** @var array */
	private $articlesCache;


	/**
	 * @param ArticleFactory $articleFactory
	 * @param Connection $connection
	 */
	public function __construct(ArticleFactory $articleFactory, Connection $connection)
	{
		parent::__construct($connection);
		$this->articleFactory = $articleFactory;
	}

	/**
	 * @return Article[]
	 */
	public function findAll()
	{
		if ($this->articlesCache === NULL) {
			$result = $this->connection->query('SELECT * FROM articles WHERE published = 1 ORDER BY name');
			$this->articlesCache = $this->articleFactory->createMultipleFromDb($result);
		}
		return $this->articlesCache;
	}

	/**
	 * @param int $articleId
	 * @return Article|NULL
	 */
	public function getById($articleId)
	{
		$sql = 'SELECT * FROM articles WHERE published = 1 AND id = %i LIMIT 0, 1';
		$result = $this->connection->query($sql, $articleId);
		$row = $result->fetch();
		return $row === NULL ? NULL : $this->articleFactory->createFromDb($row);
	}

}
