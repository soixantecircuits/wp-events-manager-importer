jQuery(document).ready(function() {

var pagination = 0;
var totalElements = jQuery(".emi-event").length;

jQuery(".row-actions .fast-edit a, .row-title").click(function() {
	jQuery("#event_"+jQuery(this).attr("parent")).css("display", "none");
	jQuery("#emi-edit-"+jQuery(this).attr("parent")).css("display", "");
	return false;
});

jQuery(".row-actions .trash a").click(function() {
	jQuery("#event_"+jQuery(this).attr("parent")).remove();
	jQuery("#emi-edit-"+jQuery(this).attr("parent")).remove();
	return false;
});

jQuery(".emi-cancel").click(function() {
	jQuery("#emi-event_name-"+jQuery(this).attr("parent")).val(jQuery("#event_"+jQuery(this).attr("parent")+" .emi-title").text());
	jQuery("#emi-location_name-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_name-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_address-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_address-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_town-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_town-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_state-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_state-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_postcode-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_postcode-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_region-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_region-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_country-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_country-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_latitude-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_latitude-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-location_longitude-"+jQuery(this).attr("parent")).val(jQuery("#emi-location_longitude-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-post_content-"+jQuery(this).attr("parent")).val(jQuery("#emi-post_content-"+jQuery(this).attr("parent")).attr("default"));

	jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).val(jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).val(jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).val(jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).attr("default"));
	jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).val(jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).attr("default"));

	jQuery("#emi-edit-"+jQuery(this).attr("parent")).css("display", "none");
	jQuery("#event_"+jQuery(this).attr("parent")).css("display", "");
	return false;
});

jQuery(".emi-save").click(function() {
	jQuery("#event_"+jQuery(this).attr("parent")+" .emi-title").text(jQuery("#emi-event_name-"+jQuery(this).attr("parent")).val());

	jQuery("#emi-location_name-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_name-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_address-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_address-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_town-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_town-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_state-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_state-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_postcode-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_postcode-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_region-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_region-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_country-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_country-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_latitude-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_latitude-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-location_longitude-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-location_longitude-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-post_content-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-post_content-"+jQuery(this).attr("parent")).val());

	jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).val());
	jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).attr("default", jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).val());

	jQuery("#event_"+jQuery(this).attr("parent")+" .location_summary").empty();
	jQuery("#event_"+jQuery(this).attr("parent")+" .location_summary").append(
		"<b>" + jQuery("#emi-location_name-"+jQuery(this).attr("parent")).val() + "</b><br/>" +
		jQuery("#emi-location_address-"+jQuery(this).attr("parent")).val() +
		" - " + jQuery("#emi-location_town-"+jQuery(this).attr("parent")).val()
	);

	jQuery("#event_"+jQuery(this).attr("parent")+" .event_date").empty();
	jQuery("#event_"+jQuery(this).attr("parent")+" .event_date").append(
		jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).val() +
		((jQuery("#emi-event_start_date"+jQuery(this).attr("parent")).val() != jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).val()) ? 
			" - " + jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).val() : "") +
		"<br />" +
		jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).val() +
		" - " +
		jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).val()
	);


	jQuery("#emi-edit-"+jQuery(this).attr("parent")).css("display", "none");
	jQuery("#event_"+jQuery(this).attr("parent")).css("display", "");	
	return false;
});

// Calendar \\

jQuery(".emi-event_start_date").datepicker({ 
	dateFormat: 'dd/mm/yy',
	// FIXME
	//onSelect: function(dateText) {
		//jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).datepicker({
			//dateFormat: 'dd/mm/YY',
			//minDate: dateText.replace("/", "-")
		//});
	//}
});
jQuery(".emi-event_end_date").datepicker({ dateFormat: 'dd/mm/yy' });

// Pagination \\

function paginate() {
	jQuery(".emi-event").css("display", "none");

	var j = 0;
	for (var i = pagination * 15 + 1; i < (pagination * 15) + 16; i++) {
		jQuery("#event_"+i).css("display", "");
	}

	jQuery(".emi-first-page").removeClass("disabled");
	jQuery(".emi-prev-page").removeClass("disabled");
	jQuery(".emi-next-page").removeClass("disabled");
	jQuery(".emi-last-page").removeClass("disabled");
	if (pagination == 0) {
		jQuery(".emi-first-page").addClass("disabled");
		jQuery(".emi-prev-page").addClass("disabled");
	} else if (pagination == Math.floor(totalElements / 15)) {
		jQuery(".emi-next-page").addClass("disabled");
		jQuery(".emi-last-page").addClass("disabled");
	}

	jQuery(".emi-total-number").text(totalElements);
	jQuery(".emi-current-page").text(pagination + 1);
	jQuery(".emi-total-pages").text(Math.floor(totalElements / 15) + 1);
}
paginate();

jQuery(".emi-first-page").click(function() {
	if (pagination > 0) {
		pagination = 0;
		paginate();
	}
	return false;
});

jQuery(".emi-prev-page").click(function() {
	if (pagination > 0) {
		pagination--;
		paginate();
	}
	return false;
});

jQuery(".emi-next-page").click(function() {
	if (pagination < Math.floor(totalElements / 15)) {
		pagination++;
		paginate();
	}
	return false;
});

jQuery(".emi-last-page").click(function() {
	if (pagination < Math.floor(totalElements / 15)) {
		pagination = Math.floor(totalElements / 15);
		paginate();
	}
	return false;
});

jQuery('.emi_droparea').dropfile({

});


});

