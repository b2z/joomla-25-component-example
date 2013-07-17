<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modelitem Joomla.
jimport('joomla.application.component.modelitem');

/**
 * Модель сообщения компонента HelloWorld.
 */
class HelloWorldModelHelloWorld extends JModelItem
{
	/**
	 * Получаем сообщение.
	 *
	 * @return  string  Сообщение, которое отображается пользователю.
	 */
	public function getItem()
	{
		if (!isset($this->_item))
		{
			$this->_item = 'Hello World!';
		}

		return $$this->_item;
	}
}
