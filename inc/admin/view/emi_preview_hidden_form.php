<div class="emi-edit" id="emi-edit-<?php echo $r['event_id']; ?>" style="display:none">
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
					sOpenvalue="<?php echo $location[$i]['location_state']; ?>" default="<?php echo $location[$i]['location_state']; ?>">
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
					value="<?php echo $r['event_end_date']; ?>" default="<?php echo $r['event_end_date']; ?>" parent="<?php echo $r['event_id']; ?>">
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
</div>