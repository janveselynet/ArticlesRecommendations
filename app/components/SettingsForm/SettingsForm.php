<?php

namespace App\Components\SettingsForm;

use App\Model\ArticleRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;


class SettingsForm extends Control
{

	/** @var ArticleRepository */
	private $articleRepository;

	/** @var array */
	public $onFormSubmitted = [];


	/**
	 * @param ArticleRepository $articleRepository
	 */
	public function __construct(ArticleRepository $articleRepository)
	{
		$this->articleRepository = $articleRepository;
	}

	/**
	 * @return void
	 */
	public function render()
	{
		$this->template->setFile(__DIR__ . '/templates/default.latte');
		$this->template->render();
	}

	/**
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = new Form();

		$form->addSelect('article', 'Choose article', $this->getArticlesForSelect())
			->setRequired();
		
		$form->addText('similarityWeight', 'Similarity weight')
			->setDefaultValue('0.5');

		$form->addText('ratingWeight', 'Rating weight')
			->setDefaultValue('0.5');

		$form->addSelect('recommendationsCount', 'Recomm. count', [
			5 => 5,
			10 => 10,
			25 => 25,
			50 => 50,
			100 => 100,
		])
			->setRequired()
			->setDefaultValue(10);

		$form->addSubmit('submit', 'Recommend');

		$form->onSuccess[] = function(Form $form) {
			$values = $form->values;
			$this->onFormSubmitted(
				$values->article,
				$values->similarityWeight,
				$values->ratingWeight,
				$values->recommendationsCount
			);
		};

		return $form;
	}

	/**
	 * @return array
	 */
	private function getArticlesForSelect()
	{
		$selectItems = [];
		foreach ($this->articleRepository->getAll() as $article) {
			$selectItems[$article->getId()] = $article->getTitle();
		}
		return $selectItems;
	}

}
