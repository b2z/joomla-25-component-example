<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

// Данные по сортировке.
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<tr>
	<th width="1%">
		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_HELLOWORLD_HELLOWORLD_HEADING_GREETING', 'greeting', $listDirn, $listOrder); ?>
	</th>
	<th width="10%">
		<?php echo JHtml::_('grid.sort', 'JCATEGORY', 'category_title', $listDirn, $listOrder); ?>
	</th>
	<th width="10%">
		<?php echo JHtml::_('grid.sort', 'JSTATUS', 'state', $listDirn, $listOrder); ?>
	</th>
	<th width="10%">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
		<?php if ($listOrder == 'ordering') : ?>
			<?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'helloworlds.saveorder'); ?>
		<?php endif; ?>
	</th>
	<th width="1%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'COM_HELLOWORLD_HELLOWORLD_HEADING_ID', 'id', $listDirn, $listOrder); ?>
	</th>
</tr>
