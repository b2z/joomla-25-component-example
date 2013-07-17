<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Загружаем тултипы.
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_helloworld'); ?>" method="post" name="adminForm" id="adminForm">
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $this->escape($this->state->get('list.ordering')); ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->escape($this->state->get('list.direction')); ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
