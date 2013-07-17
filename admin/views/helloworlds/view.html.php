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
		JToolBarHelper::addNew('helloworld.add');
		JToolBarHelper::editList('helloworld.edit');
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'helloworlds.delete');
		JToolBarHelper::divider();
		JToolBarHelper::preferences('com_helloworld');
	}
}
