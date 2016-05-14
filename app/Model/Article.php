<?php

namespace App\Model;

use Nette\Object;


class Article extends Object
{

	/** @var int */
	private $id;

	/** @var string */
	private $title;

	/** @var int[] */
	private $categories;


	/**
	 * @param int $id
	 * @param string $title
	 * @param int[] $categories
	 */
	public function __construct($id, $title, array $categories)
	{
		$this->id = $id;
		$this->title = $title;
		$this->categories = $categories;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return int[]
	 */
	public function getCategories()
	{
		return $this->categories;
	}

}
