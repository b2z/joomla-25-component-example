<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку controllerform Joomla.
jimport('joomla.application.component.controllerform');

/**
 * HelloWorld контроллер.
 */
class HelloWorldControllerHelloWorld extends JControllerForm
{
	/**
	 * Переопределение метода для проверки,
	 * может ли пользователь редактировать существующую запись.
	 *
	 * @param   array   $data  Массив данных.
	 * @param   string  $key   Имя первичного ключа.
	 *
	 * @return  boolean  True, если разрешено редактировать запись.
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;

		if ($recordId)
		{
			// Проверка редактирования на уровне записи.
			return JFactory::getUser()->authorise('core.edit', 'com_helloworld.message.' . $recordId);
		}
		else
		{
			// Проверка редактирования на уровне компонента.
			return parent::allowEdit($data, $key);
		}
	}
}
