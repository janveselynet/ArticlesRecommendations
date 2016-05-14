<?php

namespace App\Model;

use Nette\Object;


class Recommender extends Object
{

	/** @var ArticleRepository */
	private $articleRepository;

	/** @var RatingRepository */
	private $ratingRepository;


	/**
	 * @param ArticleRepository $articleRepository
	 * @param RatingRepository $ratingRepository
	 */
	public function __construct(ArticleRepository $articleRepository, RatingRepository $ratingRepository)
	{
		$this->articleRepository = $articleRepository;
		$this->ratingRepository = $ratingRepository;
	}

	/**
	 * @param int $articleId
	 * @param float $similarityWeight
	 * @param float $ratingWeight
	 * @param int $count
	 * @return RecommendationCandidate[]
	 */
	public function getRecommendations($articleId, $similarityWeight, $ratingWeight, $count)
	{
		$similarityWeight = $this->normalizeWeight($similarityWeight);
		$ratingWeight = $this->normalizeWeight($ratingWeight);
		$article = $this->articleRepository->getById($articleId);
		$candidates = $this->getCandidates($article);
		usort($candidates, function(RecommendationCandidate $candidate1, RecommendationCandidate $candidate2)
			use($similarityWeight, $ratingWeight) {
				$score1 = $candidate1->getScore($similarityWeight, $ratingWeight);
				$score2 = $candidate2->getScore($similarityWeight, $ratingWeight);
				if ($score1 === $score2) {
					return 0;
				}
				return $score2 < $score1 ? -1 : 1;
			});
		return array_slice($candidates, 0, $count);
	}

	/**
	 * @param Article $articleToRecommendFor
	 * @return RecommendationCandidate[]
	 */
	private function getCandidates(Article $articleToRecommendFor)
	{
		$articles = $this->articleRepository->findAll();
		$ratings = $this->loadRatings($articleToRecommendFor);
		$candidates = [];
		foreach ($articles as $article) {
			if ($article->getId() !== $articleToRecommendFor->getId()) {
				$candidate = new RecommendationCandidate($article);
				$candidate->computeSimilarity($articleToRecommendFor);
				$candidate->setRatingScore(isset($ratings[$article->getId()]) ? $ratings[$article->getId()] : 0);
				$candidates[] = $candidate;
			}
		}
		return $candidates;
	}

	/**
	 * @param float $weight
	 * @return float
	 */
	private function normalizeWeight($weight)
	{
		return max(0, min(1, (float) $weight));
	}

	/**
	 * @param Article $articleToRecommendFor
	 * @return array
	 */
	private function loadRatings(Article $articleToRecommendFor)
	{
		$result = $this->ratingRepository->findRatingsSumRelatedToArticle($articleToRecommendFor);
		$ratings = [];
		foreach ($result as $row) {
			$ratings[$row->article] = $row->cnt;
		}
		$normalizer = $this->ratingRepository->getCountOfRatingsOfArticle($articleToRecommendFor);
		foreach ($ratings as $article => $rating) {
			$ratings[$article] = $rating / $normalizer;
		}
		return $ratings;
	}

}
