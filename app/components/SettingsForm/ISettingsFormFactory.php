<?php

namespace App\Components\SettingsForm;


interface ISettingsFormFactory
{

	/**
	 * @return SettingsForm
	 */
	public function create();
	
}
