<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace FormsModule;

use Venne;

/**
 * @author	 Josef Kříž
 */
class Container extends \Nette\Forms\Container
{



	/**
	 * Adds naming container to the form.
	 *
	 * @param  string  name
	 * @return \Nella\NetteAddons\Forms\Container
	 */
	public function addContainer($name)
	{
		$class = get_called_class();
		$control = new $class;
		$control->currentGroup = $this->currentGroup;
		return $this[$name] = $control;
	}



	/**
	 * Add dynamic container to the form.
	 * 
	 * @param type $name
	 * @param type $factory
	 * @param type $createDefault
	 * @return type 
	 */
	public function addDynamic($name, $factory, $createDefault = 0)
	{
		return $this[$name] = new Containers\Replicator($factory, $createDefault);
	}



	/**
	 * Add tags input to the form.
	 * 
	 * @param type $name
	 * @param type $label
	 * @param callable	suggest callback ($filter, $payloadLimit)
	 * @return type 
	 */
	public function addTag($name, $label, $suggestCallback = NULL)
	{
		$control = $this[$name] = new Controls\TagsInput($label);
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
	public function addDate($name, $label = NULL)
	{
		return $this[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_DATE);
	}



	/**
	 * Add DateTime input to the form.
	 * 
	 * @param type $name
	 * @param type $label
	 * @return type 
	 */
	public function addDateTime($name, $label = NULL)
	{
		return $this[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_DATETIME);
	}



	/**
	 * Add Time input to the form.
	 * 
	 * @param type $name
	 * @param type $label
	 * @return type 
	 */
	public function addTime($name, $label = NULL)
	{
		return $this[$name] = new Controls\DateInput($label, Controls\DateInput::TYPE_TIME);
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
	public function addDependentSelectBox($name, $label, $parents, $dataCallback)
	{
		return $this[$name] = new Controls\DependentSelectBox($label, $parents, $dataCallback);
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
	public function addEditor($name, $label = NULL, $cols = 40, $rows = 10)
	{
		$item = $this->addTextArea($label, $cols, $rows);
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
	public function addCheckboxList($name, $label, array $items = NULL)
	{
		return $this[$name] = new Controls\CheckboxList($label, $items);
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
	public function addTextWithSelect($name, $label, $cols = NULL, $maxLength = NULL)
	{
		return $this[$name] = new Controls\TextWithSelect($label, $cols, $maxLength);
	}

}
