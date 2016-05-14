<?php

namespace App\Components\Recommendations;

use App\Model\Recommender;
use Nette\Application\UI\Control;


class Recommendations extends Control
{

	/** @var Recommender */
	private $recommender;


	/**
	 * @param Recommender $recommender
	 */
	public function __construct(Recommender $recommender)
	{
		$this->recommender = $recommender;
	}

	/**
	 * @param int $article
	 * @param float $similarityWeight
	 * @param float $ratingWeight
	 * @param int $recommendationsCount
	 * @return void
	 */
	public function render($article, $similarityWeight, $ratingWeight, $recommendationsCount)
	{
		$this->template->recommendations = $this->recommender->getRecommendations(
			$article,
			$similarityWeight,
			$ratingWeight,
			$recommendationsCount
		);
		$this->template->setFile(__DIR__ . '/templates/default.latte');
		$this->template->render();
	}

}
