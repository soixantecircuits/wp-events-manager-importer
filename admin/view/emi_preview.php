<h1><?php _e('Parsing Result', 'emi'); ?></h1>
<form id="emi-form-preview" action="<?php echo $this->createFormAction('emi_save');?>" method="post">
<div class="tablenav top">
<label>
<span class="label-text"><?php _e("Import method", "emi"); ?> : </span>
<select name="emi-method">
	<option value="update" selected><?php _e("Update", "emi"); ?></option>
	<option value="append"><?php _e("Append", "emi"); ?></option>
	<option value="clean"><?php _e("Clean", "emi"); ?></option>
	<option value="cleanupdate"><?php _e("Clean and Update", "emi"); ?></option>
</select>
</label>
<div class="tablenav-pages"><span class="displaying-num"><span class="emi-total-number">X</span> <?php _e("elements", "emi"); ?></span>
	<span class="emi-pagination-links">
		<a class="emi-first-page" title="<?php _e("Go to the first page", "emi"); ?>" href="#">«</a>
		<a class="emi-prev-page" title="<?php _e("Go to the previous page", "emi"); ?>" href="#">‹</a>
		<span class="paging-input"><span class="emi-current-page">X</span> <?php _e("of", "emi"); ?> <span class="emi-total-pages">X</span></span>
		<a class="emi-next-page" title="<?php _e("Go to the next page", "emi"); ?>" href="#">›</a>
		<a class="emi-last-page" title="<?php _e("Go to the last page", "emi"); ?>" href="#">»</a>
	</span>
</div>
</div>
<table class="wp-list-table widefat events-table posts" cellspacing="0">
	<thead>
		<tr>
			<th><?php _e ( 'Name', 'emi' ); ?></th>
			<th><?php _e ( 'Location', 'emi' ); ?></th>
			<th colspan="2"><?php _e ( 'Date and time', 'emi' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$i = 0;
		foreach ( $events as $k => $r ) {
			// TODO Handle date_i18n with javascript
			//$event_start_date = date_i18n("D j M Y", strtotime(str_replace('/', '-', $r['event_start_date'])));
			//$event_end_date = date_i18n("D j M Y", strtotime(str_replace('/', '-', $r['event_end_date'])));
			$event_start_date = $r['event_start_date'];
			$event_end_date = $r['event_end_date'];
			$location_summary = (isset($location[$i]) && $location[$i]['location_name'] != null) ? 
				"<b>" . $location[$i]['location_name'] . "</b><br/>" . $location[$i]['location_address'] . " - " . $location[$i]['location_town'] : 
				__("None", "emi");
			?>
			
			<tr class="emi-event" id="event_<?php echo $r['event_id'] ?>">
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
			</tr>
			<tr class="emi-edit" id="emi-edit-<?php echo $r['event_id']; ?>" style="display:none">
				<td colspan="10" class="colspanchange">
				<fieldset class="inline-edit-left">
					<label>
						<span class="label-text"><?php _e("Title", "emi"); ?> : </span>
						<span class="input-text-wrap">
							<input name="emi[<?php echo $r['event_id']; ?>][event][db_event_name]" id="emi-event_name-<?php echo $r['event_id']; ?>" value="<?php echo $r['event_name']; ?>" />
						</span>
					</label>
					<br class="clear" />
					<label>
						<span class="label-text"><?php _e("Location name", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_name]" id="emi-location_name-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_name']; ?>" default="<?php echo $location[$i]['location_name']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Address", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_address]" id="emi-location_address-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_address']; ?>" default="<?php echo $location[$i]['location_address']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Town", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_town]" id="emi-location_town-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_town']; ?>" default="<?php echo $location[$i]['location_town']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("State", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_state]" id="emi-location_state-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_state']; ?>" default="<?php echo $location[$i]['location_state']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Postcode", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_postcode]" id="emi-location_postcode-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_postcode']; ?>" default="<?php echo $location[$i]['location_postcode']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Region", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_region]" id="emi-location_region-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_region']; ?>" default="<?php echo $location[$i]['location_region']; ?>">
						</span>
					</label>
				</fieldset>
				<fieldset class="inline-edit-center">
					<label>
						<span class="label-text"><?php _e("Country", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_country]" id="emi-location_country-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_country']; ?>" default="<?php echo $location[$i]['location_country']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Latitude", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_latitude]" id="emi-location_latitude-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_latitude']; ?>" default="<?php echo $location[$i]['location_latitude']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Longitude", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_location_longitude]" id="emi-location_longitude-<?php echo $location[$i]['location_id']; ?>"
								value="<?php echo $location[$i]['location_longitude']; ?>" default="<?php echo $location[$i]['location_longitude']; ?>">
						</span>
					</label>
					<br class="clear" />
					<label>
						<span class="label-text"><?php _e("Start Date", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $r['event_id']; ?>][event][db_event_start_date]" class="emi-event_start_date" id="emi-event_start_date-<?php echo $r['event_id']; ?>"
								value="<?php echo $r['event_start_date']; ?>" default="<?php echo $r['event_start_date']; ?>" parent="<?php echo $r['event_id']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("End Date", "emi"); ?> : </span>
						<span class="input-text-wrap">
   						<input name="emi[<?php echo $r['event_id']; ?>][event][db_event_end_date]" class="emi-event_end_date" id="emi-event_end_date-<?php echo $r['event_id']; ?>"
								value="<?php echo $r['event_end_date']; ?>" default="<?php echo $r['event_end_date']; ?>">
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("Start hour", "emi"); ?> : </span>
						<span class="input-text-wrap">
							<input name="emi[<?php echo $r['event_id']; ?>][event][db_event_start_time]" class="emi-event_start_time" id="emi-event_start_time-<?php echo $r['event_id']; ?>" 
								value="<?php echo $r['event_start_time']; ?>" default="<?php echo $r['event_start_time']; ?>"/>
						</span>
					</label>
					<label>
						<span class="label-text"><?php _e("End hour", "emi"); ?> : </span>
						<span class="input-text-wrap">
							<input name="emi[<?php echo $r['event_id']; ?>][event][db_event_end_time]" class="emi-event_end_time" id="emi-event_end_time-<?php echo $r['event_id']; ?>" 
								value="<?php echo $r['event_end_time']; ?>" default="<?php echo $r['event_start_time']; ?>"/>
						</span>
					</label>
				</fieldset>
				<fieldset class="inline-edit-right">
					<label>
						<span class="label-text"><?php _e("Content", "emi"); ?> : </span>
						<span class="input-text-wrap">
							<textarea name="emi[<?php echo $r['event_id']; ?>][event][db_post_content]" id="emi-post_content-<?php echo $r['event_id']; ?>"
								default="<?php echo $r['post_content']; ?>"><?php echo $r['post_content']; ?></textarea>
						</span>
					</label>
				</fieldset>
				<input type="hidden" name="emi[<?php echo $r['event_id']; ?>][event][db_event_all_day]" id="emi-event_all_day-<?php echo $r['event_id']; ?>"
					value="<?php echo $r['event_all_day']; ?>"/>
				<input type="hidden" name="emi[<?php echo $r['event_id']; ?>][event][db_event_rsvp]" id="emi-event_rsvp-<?php echo $r['event_id']; ?>"
					value="<?php echo $r['event_rsvp']; ?>"/>
				<input type="hidden" name="emi[<?php echo $r['event_id']; ?>][event][db_event_rsvp_date]" id="emi-event_rsvp_date-<?php echo $r['event_id']; ?>"
					value="<?php echo $r['event_rsvp_date']; ?>"/>
				<input type="hidden" name="emi[<?php echo $r['event_id']; ?>][event][db_event_rsvp_time]" id="emi-event_rsvp_time-<?php echo $r['event_id']; ?>"
					value="<?php echo $r['event_rsvp_time']; ?>"/>
				<input type="hidden" name="emi[<?php echo $r['event_id']; ?>][event][db_event_spaces]" id="emi-event_spaces-<?php echo $r['event_id']; ?>"
					value="<?php echo $r['event_spaces']; ?>"/>
   			<input type="hidden" name="emi[<?php echo $location[$i]['location_id']; ?>][location][db_post_content]" id="emi-location_post_content-<?php echo $location[$i]['location_id']; ?>"
					value="<?php echo $location[$i]['post_content']; ?>">
				

				<br class="clear">
				<p class="submit inline-edit-save">
					<button type="button" title="<?php _e("Cancel", "emi"); ?>" class="button-secondary cancel alignleft emi-cancel" parent="<?php echo $r['event_id']; ?>" ><?php _e("Cancel", "emi"); ?></button>
					<button type="button" title="<?php _e("Save", "emi"); ?>" class="button-primary save alignright emi-save" parent="<?php echo $r['event_id']; ?>" ><?php _e("Save", "emi"); ?></button>
				</p>
				</td>
			</tr>
			<?php
			$i++;
		}
		?>
	</tbody>
</table> 
<div class="tablenav bottom">
<input type="submit" class="button-primary" id="emi-submit" value="<?php _e('Save','emi'); ?>"> 
<div class="tablenav-pages"><span class="displaying-num"><span class="emi-total-number">X</span> <?php _e("elements", "emi"); ?></span>
	<span class="emi-pagination-links">
		<a class="emi-first-page" title="<?php _e("Go to the first page", "emi"); ?>" href="#">«</a>
		<a class="emi-prev-page" title="<?php _e("Go to the previous page", "emi"); ?>" href="#">‹</a>
		<span class="paging-input"><span class="emi-current-page">X</span> <?php _e("of", "emi"); ?> <span class="emi-total-pages">X</span></span>
		<a class="emi-next-page" title="<?php _e("Go to the next page", "emi"); ?>" href="#">›</a>
		<a class="emi-last-page" title="<?php _e("Go to the last page", "emi"); ?>" href="#">»</a>
	</span>
</div>
</div>
</form>
