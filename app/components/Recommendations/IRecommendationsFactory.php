<?php

namespace App\Components\Recommendations;


interface IRecommendationsFactory
{

	/**
	 * @return Recommendations
	 */
	public function create();

}
