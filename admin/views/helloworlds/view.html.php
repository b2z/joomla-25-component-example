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

			// Отображаем представление.
			parent::display($tpl);
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}
}
