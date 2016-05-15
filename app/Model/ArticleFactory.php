<?php

namespace App\Model;

use Nette\Object;
use Dibi\Result;
use Dibi\Row;


class ArticleFactory extends Object
{

	const CATEGORIES_SEPARATOR = '~';


	/**
	 * @param Row $row
	 * @return Article
	 */
	public function createFromDb(Row $row)
	{
		$categories = explode(self::CATEGORIES_SEPARATOR, $row->categories);
		return new Article($row->id, $row->name, $categories);
	}

	/**
	 * @param Result $result
	 * @return Article[]
	 */
	public function createMultipleFromDb(Result $result)
	{
		$articles = [];
		foreach ($result as $row) {
			$articles[] = $this->createFromDb($row);
		}
		return $articles;
	}

}
