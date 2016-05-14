<?php

namespace App\Presenters;

use App\Components\Recommendations\IRecommendationsFactory;
use App\Components\Recommendations\Recommendations;
use App\Components\SettingsForm\ISettingsFormFactory;
use App\Components\SettingsForm\SettingsForm;
use Nette\Application\UI\Presenter;


class HomepagePresenter extends Presenter
{

	/** @var ISettingsFormFactory */
	private $settingsFormFactory;

	/** @var IRecommendationsFactory */
	private $recommendationsFactory;

	/** @var int|NULL */
	private $article;

	/** @var float|NULL */
	private $similarityWeight;

	/** @var float|NULL */
	private $ratingWeight;

	/** @var int */
	private $recommendationsCount;


	/**
	 * @param ISettingsFormFactory $settingsFormFactory
	 * @param IRecommendationsFactory $recommendationsFactory
	 */
	public function __construct(ISettingsFormFactory $settingsFormFactory, IRecommendationsFactory $recommendationsFactory)
	{
		$this->settingsFormFactory = $settingsFormFactory;
		$this->recommendationsFactory = $recommendationsFactory;
	}

	/**
	 * @return void
	 */
	public function renderDefault()
	{
		$this->template->article = $this->article;
		$this->template->similarityWeight = $this->similarityWeight;
		$this->template->ratingWeight = $this->ratingWeight;
		$this->template->recommendationsCount = $this->recommendationsCount;
	}

	/**
	 * @return SettingsForm
	 */
	protected function createComponentSettingsForm()
	{
		$form = $this->settingsFormFactory->create();
		$form->onFormSubmitted[] = function($article, $similarityWeight, $ratingWeight, $recommendationsCount) {
			$this->article = $article;
			$this->similarityWeight = $similarityWeight;
			$this->ratingWeight = $ratingWeight;
			$this->recommendationsCount = $recommendationsCount;
		};
		return $form;
	}

	/**
	 * @return Recommendations
	 */
	protected function createComponentRecommendations()
	{
		return $this->recommendationsFactory->create();
	}

}
