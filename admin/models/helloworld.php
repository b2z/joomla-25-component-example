<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modeladmin Joomla.
jimport('joomla.application.component.modeladmin');

/**
 * Модель HelloWorld.
 */
class HelloWorldModelHelloWorld extends JModelAdmin
{
	/**
	 * Возвращает ссылку на объект таблицы, всегда его создавая.
	 *
	 * @param   string  $type    Тип таблицы для подключения.
	 * @param   string  $prefix  Префикс класса таблицы. Необязателен.
	 * @param   array   $config  Конфигурационный массив. Необязателен.
	 *
	 * @return  JTable  Объект JTable.
	 */
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Метод для получения формы.
	 *
	 * @param   array    $data      Данные для формы.
	 * @param   boolean  $loadData  True, если форма загружает свои данные (по умолчанию), false если нет.
	 *
	 * @return  mixed  Объект JForm в случае успеха, в противном случае false.
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Получаем форму.
		$form = $this->loadForm(
			$this->option . '.helloworld', 'helloworld', array('control' => 'jform', 'load_data' => $loadData)
		);

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Метод для получения скрипта, который будет включен в форму.
	 *
	 * @return  string  Файл скрипта.
	 */
	public function getScript()
	{
		return 'administrator/components/' . $this->option . '/models/forms/helloworld.js';
	}

	/**
	 * Метод для получения данных, которые должны быть загружены в форму.
	 *
	 * @return  mixed  Данные для формы.
	 */
	protected function loadFormData()
	{
		// Проверка сессии на наличие ранее введеных в форму данных.
		$data = JFactory::getApplication()->getUserState($this->option . '.edit.helloworld.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Метод для проверки, может ли пользователь удалять существующую запись.
	 *
	 * @param   object  $record  Объект записи.
	 *
	 * @return  boolean  True, если разрешено удалять запись.
	 */
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			return JFactory::getUser()->authorise('core.delete', $this->option . '.message.' . (int) $record->id);
		}
		else
		{
			return parent::canDelete($record);
		}
	}
}
