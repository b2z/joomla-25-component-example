<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку modellist Joomla.
jimport('joomla.application.component.modellist');

/**
 * Модель списка сообщений компонента HelloWorld.
 */
class HelloWorldModelHelloWorlds extends JModelList
{
	/**
	 * Конструктор.
	 *
	 * @param   array  $config  Массив с конфигурационными параметрами.
	 */
	public function __construct($config = array())
	{
		// Добавляем валидные поля для фильтров и сортировки.
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'id',
				'greeting', 'greeting',
				'state', 'state',
				'ordering', 'ordering',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Метод для построения SQL запроса для загрузки списка данных.
	 *
	 * @return  string  SQL запрос.
	 */
	protected function getListQuery()
	{
		// Создаем новый query объект.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Выбераем поля.
		$query->select('id, greeting, state, ordering');

		// Из таблицы helloworld.
		$query->from('#__helloworld');

		// Добавляем сортировку.
		$orderCol  = $this->state->get('list.ordering', 'id');
		$orderDirn = $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Метод для авто-заполнения состояния модели.
	 *
	 * @param   string  $ordering   Поле сортировки.
	 * @param   string  $direction  Направление сортировки (asc|desc).
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('id', 'desc');
	}
}
