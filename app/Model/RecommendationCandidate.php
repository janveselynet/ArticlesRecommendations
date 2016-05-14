<?php

namespace App\Model;

use Nette\Object;


class RecommendationCandidate extends Object
{

	/** @var Article */
	private $article;

	/** @var float */
	private $similarity = 0;

	/** @var float */
	private $ratingScore = 0;


	/**
	 * @param Article $article
	 */
	public function __construct(Article $article)
	{
		$this->article = $article;
	}

	/**
	 * @return Article
	 */
	public function getArticle()
	{
		return $this->article;
	}

	/**
	 * @param Article $article
	 * @return void
	 */
	public function computeSimilarity(Article $article)
	{
		$categories1 = $this->article->getCategories();
		$categories2 = $article->getCategories();
		$intersection = array_intersect($categories1, $categories2);
		$union = array_unique(array_merge($categories1, $categories2));
		$this->similarity = count($intersection) / count($union);
	}

	/**
	 * @param float $ratingScore
	 * @return void
	 */
	public function setRatingScore($ratingScore)
	{
		$this->ratingScore = (float) $ratingScore;
	}

	/**
	 * @param float $similarityWeight
	 * @param float $ratingWeight
	 * @return float
	 */
	public function getScore($similarityWeight, $ratingWeight)
	{
		return $this->similarity * $similarityWeight + $this->ratingScore * $ratingWeight;
	}

}
