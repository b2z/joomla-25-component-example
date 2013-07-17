<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

/**
 * Хелпер HelloWorld компонента.
 */
abstract class HelloWorldHelper
{
	/**
	 * Конфигурируем подменю.
	 *
	 * @param   string  $submenu  Активный пункт меню.
	 *
	 * @return  void
	 */
	public static function addSubmenu($submenu)
	{
		// Добавляем пункты подменю.
		JSubMenuHelper::addEntry(
			JText::_('COM_HELLOWORLD_SUBMENU_MESSAGES'),
			'index.php?option=com_helloworld',
			$submenu == 'messages'
		);

		JSubMenuHelper::addEntry(
			JText::_('COM_HELLOWORLD_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&view=categories&extension=com_helloworld',
			$submenu == 'categories'
		);

		// Устанавливаем глобальные свойства.
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-helloworld ' .
			'{background-image: url(../media/com_helloworld/images/hello-48x48.png);}');

		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('COM_HELLOWORLD_ADMINISTRATION_CATEGORIES'));
		}
	}
}
