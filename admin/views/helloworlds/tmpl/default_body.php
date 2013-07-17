<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;

foreach ($this->items as $i => $item) : ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td class="center">
			<?php echo JHtml::_('grid.id', $i, $item->id); ?>
		</td>
		<td>
			<?php echo $item->greeting; ?>
		</td>
		<td class="center">
			<?php echo $item->id; ?>
		</td>
	</tr>
<?php endforeach; ?>
