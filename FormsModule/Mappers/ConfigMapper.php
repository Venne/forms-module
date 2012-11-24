<?php

/**
 * This file is part of the Venne:CMS (https://github.com/Venne)
 *
 * Copyright (c) 2011, 2012 Josef Kříž (http://www.josef-kriz.cz)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace FormsModule\Mappers;

use Venne;
use Venne\Forms\IMapper;
use Venne\Forms\Form;
use Nette\Forms\Container;
use Nette\Utils\Strings;
use Nette\Config\Adapters\NeonAdapter;
use Nette\ComponentModel\IComponent;

/**
 * @author     Josef Kříž
 */
class ConfigMapper extends \Nette\Object implements IMapper
{


	/** @var string */
	protected $fileName;

	/** @var Nette\Config\Adapters\NeonAdapter */
	protected $adapter;

	/** @var string */
	protected $root;

	/** @var array */
	protected $data;

	/** @var Container */
	protected $container;


	/**
	 * @param string $fileName
	 * @param string $root
	 */
	public function __construct($fileName, $root = '')
	{
		$this->fileName = $fileName;
		$this->root = explode('.', $root);
		$this->adapter = new NeonAdapter;
	}


	public function getRoot()
	{
		return implode(".", $this->root);
	}


	public function setRoot($root)
	{
		$root = str_replace('\.', '\\', $root);
		$this->root = $this->root = $root ? explode(".", $root) : array();
		foreach ($this->root as $key => $item) {
			$this->root[$key] = str_replace('\\', '.', $item);
		}
	}


	public function setForm(Form $container)
	{
		$this->container = $container;
		$this->container->onSuccess[] = $this->saveConfig;
	}


	public function assign($data, IComponent $container)
	{

	}


	protected function loadConfig()
	{
		$this->data = $this->adapter->load($this->fileName);
		$data = $this->data;

		foreach ($this->root as $item) {
			$data = isset($data[$item]) ? $data[$item] : array();
		}

		return $data;
	}


	public function saveConfig()
	{
		$values = $this->data;
		$this->loadConfig();
		$data = & $this->data;

		foreach ($this->root as $item) {
			$data = & $data[$item];
		}

		$data = $data ? : array();
		$data = ($values + $data);

		file_put_contents($this->fileName, $this->adapter->dump($this->data));
	}


	/**
	 * @return array
	 */
	public function save($container = NULL, $rec = false, $values = NULL)
	{
		$container = $container ? : $this->container;

		if (!$rec) {
			$values = $this->loadConfig();
		} else {
			if (!isset($values[$rec])) {
				$values[$rec] = array();
			}
			$values = $values[$rec];
		}

		foreach ($container->getComponents() as $key => $control) {
			if (!Strings::startsWith($key, "_")) {
				if ($control instanceof \Nette\Forms\Container) {
					$values[$key] = $this->save($control, $key, $values);
				} else if ($control instanceof \Nette\Forms\IControl) {
					$values[$key] = $control->value;
				}
			}
		}

		if (!$rec) {
			$this->data = $values;
		} else {
			return $values;
		}
	}


	/**
	 * @return array
	 */
	public function load($container = NULL, $rec = false, $values = NULL)
	{
		$container = $container ? : $this->container;

		if (!$rec) {
			$values = $this->loadConfig();
		}

		foreach ($container->getComponents() as $key => $control) {
			if (!Strings::startsWith($key, "_")) {
				if ($control instanceof \Nette\Forms\Container) {
					$this->load($control, true, isset($values[$key]) ? $values[$key] : "");
				} else if ($control instanceof \Nette\Forms\IControl) {
					$control->value = isset($values[$key]) ? $values[$key] : "";
				}
			}
		}
	}
}
