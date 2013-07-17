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
	 * Возвращает ссылку на объект таблицы.
	 *
	 * @param   string  $type    Тип таблицы.
	 * @param   string  $prefix  Префикс имени класса таблицы. Необязателен.
	 * @param   array   $config  Конифгурационный массив для таблицы. Необязателен.
	 *
	 * @return  JTable  Объект таблицы.
	 */
	public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

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

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$id]))
		{
			// Получаем экземпляр класса TableHelloWorld.
			$table = $this->getTable();

			// Загружаем сообщение.
			$table->load($id);

			// Назначаем сообщение.
			$this->_item[$id] = $table->greeting;
		}

		return $this->_item[$id];
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
