<?php

namespace App\Model;


use Nextras\Dbal\Connection;


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
	public function getAll()
	{
		if ($this->articlesCache === NULL) {
			$result = $this->connection->query('SELECT * FROM articles WHERE published = 1 ORDER BY name');
			$this->articlesCache = $this->articleFactory->createMultipleFromDb($result);
		}
		return $this->articlesCache;
	}

}
