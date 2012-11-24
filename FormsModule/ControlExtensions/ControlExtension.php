<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace FormsModule\ControlExtensions;

use Venne;
use Nette\Object;
use Venne\Forms\IControlExtension;
use Venne\Forms\Form;
use FormsModule\Containers;
use FormsModule\Controls;


/**
 * @author     Josef Kříž
 */
class ControlExtension extends Object implements IControlExtension
{

	/**
	 * @return array
	 */
	public function getControls(Form $form)
	{
		return array(
			'tags', 'dynamic', 'date', 'dateTime', 'time', 'textWithSelect', 'editor', 'dependentSelectBox', 'checkboxList'
		);
	}


	/**
	 * Add dynamic container to the form.
	 *
	 * @param type $name
	 * @param type $factory
	 * @param type $createDefault
	 * @return type
	 */
	public function addDynamic($form, $name, $factory, $createDefault = 0)
	{
		\Kdyby\Extension\Forms\Replicator\Replicator::register();

		$form[$name] = $control = new \Kdyby\Extension\Forms\Replicator\Replicator($factory, $createDefault);
		$control->containerClass = 'Venne\Forms\Container';
		return $control;
	}



	/**
	 * Add tags input to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @param callable	suggest callback ($filter, $payloadLimit)
	 * @return type
	 */
	public function addTags($form, $name, $label, $suggestCallback = NULL)
	{
		$control = $form[$name] = new Controls\TagsInput($label);
		if ($suggestCallback) {
			$control->setSuggestCallback($suggestCallback);
		}
		return $control;
	}



	/**
	 * Add Date input to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @return type
	 */
	public function addDate($form, $name, $label = NULL)
	{
		return $form[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_DATE);
	}



	/**
	 * Add DateTime input to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @return type
	 */
	public function addDateTime($form, $name, $label = NULL)
	{
		return $form[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_DATETIME);
	}



	/**
	 * Add Time input to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @return type
	 */
	public function addTime($form, $name, $label = NULL)
	{
		return $form[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_TIME);
	}



	/**
	 * Add DependentSelectBox to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @param type $parents
	 * @param type $dataCallback
	 * @return type
	 */
	public function addDependentSelectBox($form, $name, $label, $parents, $dataCallback)
	{
		//$this->assetManager->addJavascript("@FormsModule/dependentSelectBox/dependentSelectBox.js");

		return $form[$name] = new Controls\DependentSelectBox($label, $parents, $dataCallback);
	}



	/**
	 * Add Editor to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @param type $cols
	 * @param type $rows
	 * @return type
	 */
	public function addEditor($form, $name, $label = NULL, $cols = 40, $rows = 10)
	{
		$item = $form->addTextArea($name, $label, $cols, $rows);
		$item->setAttribute('venne-form-editor', true);
		return $item;
	}



	/**
	 * Add CheckboxList to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @param array $items
	 * @return type
	 */
	public function addCheckboxList($form, $name, $label, array $items = NULL)
	{
		return $form[$name] = new Controls\CheckboxList($label, $items);
	}



	/**
	 * Add TextWithSelect to the form.
	 *
	 * @param type $name
	 * @param type $label
	 * @param type $cols
	 * @param type $maxLength
	 * @return type
	 */
	public function addTextWithSelect($form, $name, $label, $cols = NULL, $maxLength = NULL)
	{
		//$this->assetManager->addJavascript("@FormsModule/textWithSelect/textWithSelect.js");

		return $form[$name] = new Controls\TextWithSelect($label, $cols, $maxLength);
	}
}
