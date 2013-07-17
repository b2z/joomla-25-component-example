<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

foreach ($this->items as $i => $item) :
	$canEdit = JFactory::getUser()->authorise('core.edit', 'com_helloworld.message.' . $item->id); ?>

	<tr class="row<?php echo $i % 2; ?>">
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php if ($canEdit) : ?>
				<a href="<?php echo JRoute::_('index.php?option=com_helloworld&task=helloworld.edit&id=' . (int)$item->id); ?>">
					<?php echo $this->escape($item->greeting); ?>
				</a>
			<?php else : ?>
				<?php echo $this->escape($item->greeting); ?>
			<?php endif; ?>
		</td>
		<td class="center">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
