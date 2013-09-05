<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление списка сообщений компонента HelloWorld.
 */
class HelloWorldViewHelloWorlds extends JViewLegacy
{
	/**
	 * Сообщения.
	 *
	 * @var  array
	 */
	protected $items;

	/**
	 * Постраничная навигация.
	 *
	 * @var  object
	 */
	protected $pagination;

	/**
	 * Состояние модели.
	 *
	 * @var  object
	 */
	protected $state;

	/**
	 * Доступы пользователя.
	 *
	 * @var  object
	 */
	protected $canDo;

	/**
	 * Отображаем список сообщений.
	 *
	 * @param   string  $tpl  Имя файла шаблона.
	 *
	 * @return  void
	 *
	 * @throws  Exception
	 */
	public function display($tpl = null)
	{
		try
		{
			// Получаем данные из модели.
			$this->items = $this->get('Items');

			// Получаем объект постраничной навигации.
			$this->pagination = $this->get('Pagination');

			// Получаем объект состояния модели.
			$this->state = $this->get('State');

			// Получаем доступы пользователя.
			$this->canDo = HelloWorldHelper::getActions();

			// Устанавливаем панель инструментов.
			$this->addToolBar();

			// Отображаем представление.
			parent::display($tpl);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return void
	 */
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS'), 'helloworld');

		if ($this->canDo->get('core.create'))
		{
			JToolBarHelper::addNew('helloworld.add');
		}

		if ($this->canDo->get('core.edit'))
		{
			JToolBarHelper::editList('helloworld.edit');
		}

		if ($this->canDo->get('core.edit.state'))
		{
			JToolBarHelper::divider();
			JToolbarHelper::publish('helloworlds.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('helloworlds.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}

		if ($this->canDo->get('core.delete'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::deleteList('', 'helloworlds.delete');
		}

		if ($this->canDo->get('core.admin'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_helloworld');
		}
	}
}
