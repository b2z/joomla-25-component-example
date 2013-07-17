<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление сообщения компонента HelloWorld.
 */
class HelloWorldViewHelloWorld extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var  string
	 */
	protected $item;

	/**
	 * Параметры.
	 *
	 * @var  object
	 */
	protected $params;

	/**
	 * Переопределяем метод display класса JViewLegacy.
	 *
	 * @param   string  $tpl  Имя файла шаблона.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		try
		{
			// Получаем сообщение из модели.
			$this->item = $this->get('Item');

			// Получаем параметры приложения.
			$app          = JFactory::getApplication();
			$this->params = $app->getParams();

			// Подготавливаем документ.
			$this->_prepareDocument();

			// Отображаем представление.
			parent::display($tpl);
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HELLOWORLD_ERROR_OCCURRED'), 'error');
			JLog::add($e->getMessage(), JLog::ERROR, 'com_helloworld');
		}
	}

	/**
	 * Подготавливает документ.
	 *
	 * @return  void
	 */
	protected function _prepareDocument()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Так как приложение устанавливает заголовок страницы по умолчанию,
		// мы получаем его из пункта меню.
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', JText::_('COM_HELLOWORLD_DEFAULT_PAGE_TITLE'));
		}

		// Получаем заголовок страницы в браузере из параметров.
		$title = $this->params->get('page_title', '');

		if (empty($title))
		{
			$title = $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}

		if (empty($title))
		{
			$title = $this->item;
		}

		// Устанавливаем заголовок страницы в браузере.
		$this->document->setTitle($title);

		// Добавляем поддержку метаданных из пункта меню.
		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
