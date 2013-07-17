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
	 * @param   int  $id  Id сообщения.
	 *
	 * @return  string  Сообщение, которое отображается пользователю.
	 */
	public function getItem($id = null)
	{
		// Если id не установлено, то получаем его из состояния.
		$id = (!empty($id)) ? $id : (int) $this->getState('message.id');

		if (!isset($this->_item))
		{
			switch ($id)
			{
				case 2:
					$this->_item = 'Good bye World!';
					break;

				case 1:
				default:
					$this->_item = 'Hello World!';
					break;
			}
		}

		return $this->_item;
	}

	/**
	 * Метод для авто-заполнения состояния модели.
	 *
	 * Заметка. Вызов метода getState в этом методе приведет к рекурсии.
	 *
	 * @return  void
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Получаем Id сообщения из Запроса.
		$id = $app->input->getInt('id', 0);

		// Добавляем Id сообщения в состояние модели.
		$this->setState('message.id', $id);

		parent::populateState();
	}
}
