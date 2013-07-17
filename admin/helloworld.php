<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Проверка доступа.
if (!JFactory::getUser()->authorise('core.manage', 'com_helloworld'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 401);
}

// Устанавливаем обработку ошибок в режим использования Exception.
JError::$legacy = false;

// Подключаем хелпер.
JLoader::register('HelloWorldHelper', dirname(__FILE__) . '/helpers/helloworld.php');

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом HelloWorld.
$controller = JControllerLegacy::getInstance('HelloWorld');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task', 'display'));

// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();
