<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

/**
 * Хелпер HelloWorld компонента.
 */
abstract class HelloWorldHelper
{
	/**
	 * Кэш для доступных действий.
	 *
	 * @var  JObject
	 */
	private static $actions;

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

	/**
	 * Получаем доступы для действий.
	 *
	 * @param   int  $categoryId  Id категории.
	 * @param   int  $messageId   Id сообщения.
	 *
	 * @return  object
	 */
	public static function getActions($categoryId = 0, $messageId = 0)
	{
		// Определяем имя ассета (ресурса).
		if (empty($messageId) && empty($categoryId))
		{
			$assetName = 'com_helloworld';
			$section = 'component';
		}
		elseif (empty($messageId))
		{
			$assetName = 'com_helloworld.category.' . (int) $categoryId;
			$section = 'category';
		}
		else
		{
			$assetName = 'com_helloworld.message.' . (int) $messageId;
			$section = 'message';
		}

		if (empty(self::$actions))
		{
			// Получаем список доступных действий для компонента.
			$accessFile = JPATH_ADMINISTRATOR . '/components/com_helloworld/access.xml';
			$actions = JAccess::getActionsFromFile($accessFile, "/access/section[@name='" . $section . "']/");

			// Для сообщения добавляем действие core.admin.
			if ($section == 'message')
			{
				$adminAction = new stdClass;
				$adminAction->name = 'core.admin';

				array_push($actions, $adminAction);
			}

			self::$actions = new JObject;

			foreach ($actions as $action)
			{
				// Устанавливаем доступы пользователя для действий.
				self::$actions->set($action->name, JFactory::getUser()->authorise($action->name, $assetName));
			}
		}

		return self::$actions;
	}
}
