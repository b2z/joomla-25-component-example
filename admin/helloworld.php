<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Устанавливаем обработку ошибок в режим использования Exception.
JError::$legacy = false;

// Устанавливаем некоторые глобальные свойства.
$document = JFactory::getDocument();
$document->addStyleDeclaration('.icon-48-helloworld {background-image: url(../media/com_helloworld/images/hello-48x48.png);}');

// Подключаем библиотеку контроллера Joomla.
jimport('joomla.application.component.controller');

// Получаем экземпляр контроллера с префиксом HelloWorld.
$controller = JControllerLegacy::getInstance('HelloWorld');

// Исполняем задачу task из Запроса.
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task', 'display'));

// Перенаправляем, если перенаправление установлено в контроллере.
$controller->redirect();
