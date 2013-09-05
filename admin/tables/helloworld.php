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

		// Правила.
		if (isset($array['rules']) && is_array($array['rules']))
		{
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
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

	/**
	 * Метод для изменения состояния сообщения.
	 *
	 * @param   mixed    $pks     Необязательный массив первичных ключей.
	 * @param   integer  $state   Код состояния.
	 * @param   integer  $userId  Id пользователя, который производит операцию.
	 *
	 * @return  boolean  True если состояние успешно установлено.
	 *
	 * @throws  RuntimeException
	 */
	public function publish($pks = null, $state = 1, $userId = 0)
	{
		$k = $this->_tbl_key;

		// Очищаем входные параметры.
		JArrayHelper::toInteger($pks);
		$state = (int) $state;

		// Если первичные ключи не установлены, то проверяем ключ в текущем объекте.
		if (empty($pks))
		{
			if ($this->$k)
			{
				$pks = array($this->$k);
			}
			else
			{
				throw new RuntimeException(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'), 500);
			}
		}

		// Устанавливаем состояние для всех первичных ключей.
		foreach ($pks as $pk)
		{
			// Загружаем сообщение.
			if (!$this->load($pk))
			{
				throw new RuntimeException(JText::_('COM_HELLOWORLD_TABLE_ERROR_RECORD_LOAD'), 500);
			}

			$this->state = $state;

			// Сохраняем сообщение.
			if (!$this->store())
			{
				throw new RuntimeException(JText::_('COM_HELLOWORLD_TABLE_ERROR_RECORD_STORE'), 500);
			}
		}

		return true;
	}

	/**
	 * Метод для вычисления уникального имени ассета.
	 *
	 * @return  string  Имя ассета.
	 */
	protected function _getAssetName()
	{
		$k = $this->_tbl_key;

		return 'com_helloworld.message.' . (int) $this->$k;
	}

	/**
	 * Метод для получения названия ассета.
	 *
	 * @return  string  Название ассета.
	 */
	protected function _getAssetTitle()
	{
		return $this->greeting;
	}

	/**
	 * Метод для получения id родителя записи.
	 *
	 * @param   JTable  $table  Объект JTable родителя ассета.
	 * @param   int     $id     Искомый Id.
	 *
	 * @return  int  Id родителя записи.
	 */
	protected function _getAssetParentId($table = null, $id = null)
	{
		// Получаем таблицу ассетов.
		$assetParent = JTable::getInstance('Asset');

		// По умолчанию: если родительский ассет не найден, то берем глобальный.
		$assetParentId = $assetParent->getRootId();

		// Ищем родительский ассет.
		if (($this->catid) && !empty($this->catid))
		{
			// В качестве родительского ассета записи выступает категория.
			$assetParent->loadByName('com_helloworld.category.' . (int) $this->catid);
		}
		else
		{
			// В качестве родительского ассета записи выступает компонент.
			$assetParent->loadByName('com_helloworld');
		}

		// Возвращаем найденный id родителя записи.
		if ($assetParent->id)
		{
			$assetParentId = $assetParent->id;
		}

		return $assetParentId;
	}
}
