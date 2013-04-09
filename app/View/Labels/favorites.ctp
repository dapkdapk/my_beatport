<div class="actions span3 well">
	<h3><?php echo __('Actions'); ?></h3>
    -
</div>

<div class="labels index span11">
	<h2><?php echo __('Favorite Labels'); ?></h2>
    
	<table cellpadding="0" cellspacing="0" class="table table-striped">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($labels as $label): ?>
	<tr>
		<td><?php echo h($label['Label']['id']); ?>&nbsp;</td>
		<td><?php echo h($label['Label']['name']); ?>&nbsp;</td>
		<td class="actions">
            <?php echo $this->Favorites->toggleFavorite('follow', $label['Label']['id']); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $label['Label']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $label['Label']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $label['Label']['id']), null, __('Are you sure you want to delete # %s?', $label['Label']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>