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
				'id', 'h.id',
				'greeting', 'h.greeting',
				'category_title',
				'state', 'h.state',
				'ordering', 'h.ordering',
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
		$query->select('h.id, h.greeting, h.state, h.ordering');

		// Из таблицы helloworld.
		$query->from('#__helloworld AS h');

		// Присоединяем таблицу категорий.
		$query->select('c.title AS category_title');
		$query->leftJoin('#__categories AS c ON c.id = h.catid');

		// Фильтруем по состоянию.
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('h.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(h.state = 0 OR h.state = 1)');
		}

		// Фильтруем по категории.
		$categoryId = $this->getState('filter.category_id');

		if (is_numeric($categoryId))
		{
			$categoryTable = JTable::getInstance('Category', 'JTable');
			$categoryTable->load($categoryId);
			$rgt = $categoryTable->rgt;
			$lft = $categoryTable->lft;
			$query->where('c.lft >= ' . (int) $lft);
			$query->where('c.rgt <= ' . (int) $rgt);
		}

		// Фильтруем по поиску в тексте сообщения.
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			$search = $db->quote('%' . $db->escape($search, true) . '%');
			$query->where('h.greeting LIKE ' . $search);
		}

		// Добавляем сортировку.
		$orderCol  = $this->state->get('list.ordering', 'h.id');
		$orderDirn = $this->state->get('list.direction', 'desc');
		$query->order($db->escape($orderCol . ' ' . $orderDirn));

		return $query;
	}

	/**
	 * Метод для получения store id, которое основывается на состоянии модели.
	 *
	 * @param   string  $id  Идентификационная строка для генерации store id.
	 *
	 * @return  string  Store id.
	 */
	protected function getStoreId($id = '')
	{
		// Компилируем store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.category_id');

		return parent::getStoreId($id);
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
		// Получаем и устанавливаем значение фильтра состояния.
		$published = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $published);

		// Получаем и устанавливаем значение фильтра категории.
		$categoryId = $this->getUserStateFromRequest($this->context . '.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		// Получаем и устанавливаем значение фильтра поиска по тексту сообщения.
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		parent::populateState('h.id', 'desc');
	}
}
