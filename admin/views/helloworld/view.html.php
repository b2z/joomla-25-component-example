<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем библиотеку представления Joomla.
jimport('joomla.application.component.view');

/**
 * HTML представление редактирования сообщения.
 */
class HelloWorldViewHelloWorld extends JViewLegacy
{
	/**
	 * Сообщение.
	 *
	 * @var  object
	 */
	protected $item;

	/**
	 * Объект формы.
	 *
	 * @var  array
	 */
	protected $form;

	/**
	 * JavaScript файл валидации формы.
	 *
	 * @var  string
	 */
	protected $script;

	/**
	 * Отображает представление.
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
			$this->form = $this->get('Form');
			$this->item = $this->get('Item');
			$this->script = $this->get('Script');

			// Устанавливаем панель инструментов.
			$this->addToolBar();

			// Отображаем представление.
			parent::display($tpl);

			// Устанавливаем документ.
			$this->setDocument();
		}
		catch (Exception $e)
		{
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Устанавливает панель инструментов.
	 *
	 * @return  void
	 */
	protected function addToolBar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);
		$isNew = ($this->item->id == 0);

		JToolBarHelper::title($isNew ? JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW') : JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT'), 'helloworld');
		JToolBarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
		JToolBarHelper::save('helloworld.save');
		JToolBarHelper::cancel('helloworld.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}

	/**
	 * Метод для установки свойств документа.
	 *
	 * @return  void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::root() . $this->script);
		$document->addScript(
			JURI::root() . "administrator/components/com_helloworld/views/helloworld/submitbutton.js");
		JText::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
	}
}
