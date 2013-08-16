<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку таблиц Joomla.
jimport('joomla.database.table');

/**
 * Класс таблицы HelloWorld.
 */
class HelloWorldTableHelloWorld extends JTable
{
	/**
	 * Конструктор.
	 *
	 * @param   JDatabase  &$db  Коннектор объекта базы данных.
	 */
	public function __construct(&$db)
	{
		parent::__construct('#__helloworld', 'id', $db);
	}

	/**
	 * Переопределяем bind метод JTable.
	 *
	 * @param   array  $array   Массив значений.
	 * @param   array  $ignore  Массив значений, которые должны быть игнорированы.
	 *
	 * @return  boolean  True если все прошло успешно, в противном случае false.
	 */
	public function bind($array, $ignore = array())
	{
		if (isset($array['params']) && is_array($array['params']))
		{
			// Конвертируем поле параметров в JSON строку.
			$parameter = new JRegistry;
			$parameter->loadArray($array['params']);
			$array['params'] = (string) $parameter;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Переопределяем load метод JTable.
	 *
	 * @param   int      $pk     Первичный ключ.
	 * @param   boolean  $reset  Сбрасывать данные перед загрузкой или нет.
	 *
	 * @return  boolean  True если все прошло успешно, в противном случае false.
	 */
	public function load($pk = null, $reset = true)
	{
		if (parent::load($pk, $reset))
		{
			// Конвертируем поле параметров в регистр.
			$params = new JRegistry;
			$params->loadString($this->params);
			$this->params = $params;

			return true;
		}
		else
		{
			return false;
		}
	}
}
