<?php
// Запрет прямого доступа.
defined('_JEXEC') or die;
?>
<?php if ($this->item->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->item->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<h2>
	<?php echo $this->item->greeting .
		(($this->item->category and $this->item->params->get('show_category')) ? (' (' . $this->item->category . ')') : ''); ?>
</h2>
