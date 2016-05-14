<?php

namespace App\Model;

use Nette\Object;


class Recommender extends Object
{

	/** @var ArticleRepository */
	private $articleRepository;


	/**
	 * @param ArticleRepository $articleRepository
	 */
	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}

	/**
	 * @param int $article
	 * @param float $similarityWeight
	 * @param float $ratingWeight
	 * @param int $count
	 * @return Article[]
	 */
	public function getRecommendations($article, $similarityWeight, $ratingWeight, $count)
	{
		$similarityWeight = $this->normalizeWeight($similarityWeight);
		$ratingWeight = $this->normalizeWeight($ratingWeight);
		$articles = $this->articleRepository->getAll();
		shuffle($articles);
		return array_slice($articles, 0, $count);
	}

	/**
	 * @param float $weight
	 * @return float
	 */
	private function normalizeWeight($weight)
	{
		return max(0, min(1, (float) $weight));
	}

}
