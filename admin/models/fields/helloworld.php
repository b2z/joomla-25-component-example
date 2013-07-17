<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Подключаем тип поля list.
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Класс поля формы HelloWorld компонента HelloWorld.
 */
class JFormFieldHelloWorld extends JFormFieldList
{
	/**
	 * Тип поля.
	 *
	 * @var  string
	 */
	protected $type = 'HelloWorld';

	/**
	 * Метод для получения списка опций для поля списка.
	 *
	 * @return  array  Массив JHtml опций.
	 */
	protected function getOptions()
	{
		// Получаем объект базы данных.
		$db = JFactory::getDbo();

		// Конструируем SQL запрос.
		$query = $db->getQuery(true);
		$query->select('id, greeting')
			->from('#__helloworld');
		$db->setQuery($query);
		$messages = $db->loadObjectList();

		// Массив JHtml опций.
		$options = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->greeting);
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
