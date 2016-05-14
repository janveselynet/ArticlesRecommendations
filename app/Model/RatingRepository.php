<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;


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
		$sql = 'SELECT COUNT(id) as cnt, article FROM rating WHERE ip IN (' . $sqlIp . ') OR user IN (' . $sqlUser . ') GROUP BY article';
		return $this->connection->query($sql, $article->getId(), $article->getId());
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
