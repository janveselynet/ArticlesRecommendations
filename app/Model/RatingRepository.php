<?php

namespace App\Model;

use Dibi\Result;


class RatingRepository extends Repository
{

	/**
	 * @param Article $article
	 * @return Result
	 */
	public function findRatingsSumRelatedToArticle(Article $article)
	{
		$sqlIp = 'SELECT ip FROM rating WHERE article = %i';
		$sqlUser = 'SELECT user FROM rating WHERE user <> -10 AND article = %i';
		return $this->connection->query(
			'SELECT COUNT(id) as cnt, article FROM rating WHERE ip IN (',
			$sqlIp, $article->getId(),
			') OR user IN (',
			$sqlUser, $article->getId(),
			') GROUP BY article'
		);
	}

	/**
	 * @param Article $article
	 * @return int
	 */
	public function getCountOfRatingsOfArticle(Article $article)
	{
		$result = $this->connection->query('SELECT COUNT(*) as cnt FROM rating WHERE article = %i', $article->getId());
		return $result->fetch()->cnt;
	}
	
}
