<h1><?php _e('Parsing Result', 'emi'); ?></h1>
<form id="emi-form-preview" action="<?php echo $this->createFormAction('emi_save');?>" method="post">
<table id="preview_table" class="wp-list-table widefat events-table posts" cellspacing="0">
	<thead>
		<tr>
			<th><input class="emi-checkbox-th" type="checkbox"></th>
			<th><?php _e ( 'Name', 'emi' ); ?></th>
			<th><?php _e ( 'Location', 'emi' ); ?></th>
			<th><?php _e ( 'Date and time', 'emi' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		foreach ( $events as $k => $r ) {
			$event_start_date = $r['event_start_date'];
			$event_end_date = $r['event_end_date'];
			$location_summary = (isset($location[$i]) && $location[$i]['location_name'] != null) ?
				"<b>" . $location[$i]['location_name'] . "</b><br/>" . $location[$i]['location_address'] . " - " . $location[$i]['location_town'] :
				__("None", "emi");
			?>

			<tr class="emi-event" id="event_<?php echo $r['event_id'] ?>">
				<?php include('emi_preview_events.php'); ?>
				<?php include('emi_preview_hidden_form.php'); ?>
			</tr>
			<?php
			$i++;
		}
		?>
	</tbody>
</table>
<div class="tablenav bottom">
<button type="submit" class="button-primary" id="emi-submit"><?php _e('Save','emi'); ?></button>
<label>
<span class="label-text"><?php _e("Import method", "emi"); ?> : </span>
<select name="emi-method">
	<option value="update" selected><?php _e("Update", "emi"); ?></option>
	<option value="append"><?php _e("Append", "emi"); ?></option>
	<option value="clean"><?php _e("Clean", "emi"); ?></option>
	<option value="cleanupdate"><?php _e("Clean and Update", "emi"); ?></option>
</select>
</label>
<div class="tablenav-pages">
	<span class="emi-pagination-links">
		<span class="displaying-num"><span id="emi_number_elements"></span> <?php _e('elements', 'emi'); ?></span>
		<!-- Pagination content here -->
	</span>
</div>
</div>
</form>
<?php include('emi_preview_js_translation.php');