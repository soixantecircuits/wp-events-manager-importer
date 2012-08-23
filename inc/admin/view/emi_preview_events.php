<td>
	<input class="emi-checkbox" parent="<?php echo $r['event_id']; ?>" type="checkbox">
</td>
<td>
	<strong>
		<a class="row-title emi-title" href="#" parent="<?php echo $r['event_id']; ?>"><?php echo $r['event_name']; ?></a>
	</strong>
	<div class="row-actions">
		<span class="fast-edit"><a href="#" parent="<?php echo $r['event_id']; ?>" class="emi-event-fast-edit"><?php _e('Edit', 'emi'); ?></a></span> |
		<span class="trash"><a href="#" parent="<?php echo $r['event_id']; ?>" class="emi-event-delete"><?php _e('Delete','emi'); ?></a></span>
	</div>
</td>
<?php /*
<td>
		Dupplicate
</td>
*/ ?>
<td>
	<span class="location_summary" default="<?php __("None", "emi"); ?>">
		<?php echo $location_summary; ?>
	</span>
</td>

<td>
	<span class="event_date">
		<?php echo $event_start_date; ?>
		<?php echo ($event_start_date != $event_end_date) ? " - $event_end_date":''; ?>
		<br />
		<?php
			echo $r['event_start_time'] . " - " . $r['event_end_time'];
		?>
	</span>
</td>
<?php /*
<td>
		Recurrence
</td>
*/ ?>
