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
	 * @var  object
	 */
	protected $form;

	/**
	 * JavaScript файл валидации формы.
	 *
	 * @var  string
	 */
	protected $script;

	/**
	 * Доступы пользователя.
	 *
	 * @var  object
	 */
	protected $canDo;

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

			// Получаем доступы пользователя.
			$this->canDo = HelloWorldHelper::getActions($this->item->catid, $this->item->id);

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

		// Устанавливаем действия для новых и существующих записей.
		if ($isNew)
		{
			// Для новых записей проверяем право создания.
			if ($this->canDo->get('core.create'))
			{
				JToolBarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');
				JToolBarHelper::custom('helloworld.save2new', 'save-new.png',
										'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false
										);
			}

			JToolBarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			// Для существующих записей проверяем право редактирования.
			if ($this->canDo->get('core.edit'))
			{
				// Мы можем сохранять новую запись.
				JToolBarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');

				// Мы можем сохранять  в новую запись, но нужна проверка на создание.
				if ($this->canDo->get('core.create'))
				{
					JToolBarHelper::custom('helloworld.save2new', 'save-new.png',
											'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false
											);
				}
			}

			// Для сохранения копии записи проверяем право создания.
			if ($this->canDo->get('core.create'))
			{
				JToolBarHelper::custom('helloworld.save2copy', 'save-copy.png',
										'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false
										);
			}

			JToolBarHelper::cancel('helloworld.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
		}
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
