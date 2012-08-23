jQuery(document).ready(function() {

/**
 * Upload Page
 */

jQuery('#parse_button').click(function() {
	jQuery(this).attr("disabled", "disabled");
	jQuery('form#upload_form').submit();
})

/**
 * Preview Page
 */

if (jQuery('#emi-form-preview').length > 0) {
	preview_page();
}

});

function preview_page () {

var oTable;
var giRedraw = false;

function update_pagination() {
	jQuery(".row-actions .trash a").unbind();
	jQuery(".row-actions .trash a").click(function() {
		oTable.fnDeleteRow(
			oTable.fnGetPosition(
				document.getElementById('event_'+jQuery(this).attr('parent'))
			)
		);
		jQuery('#emi-edit-'+jQuery(this).attr('parent')).remove();
	});

	jQuery('.emi-checkbox-th').click(function() {
		jQuery('.emi-checkbox').prop("checked", jQuery(this).prop("checked"));
	});

	// Inline-Edit
	jQuery(".row-actions .fast-edit a, .row-title").unbind();
	jQuery(".row-actions .fast-edit a, .row-title").click(function() {
		cancel(jQuery("#event_temp").attr('parent'));
		var hidden_content = jQuery('#emi-edit-'+jQuery(this).attr('parent')).children();
		jQuery("#event_"+jQuery(this).attr("parent")).after(
			"<tr id='event_temp' class='emi-edit' parent='"+jQuery(this).attr('parent')+"'>"+
				"<td colspan=4></td>"+
			"</tr>"
		);
		jQuery('#event_temp > td').append(hidden_content);
		jQuery('#event_'+jQuery(this).attr('parent')).css('display', 'none');
		return false;
	});
}

jQuery.fn.dataTableExt.oPagination.four_button = {
    "fnInit": function ( oSettings, nPaging, fnCallbackDraw )
    {
        nFirst = document.createElement( 'a' );
        nPrevious = document.createElement( 'a' );
        nNext = document.createElement( 'a' );
        nLast = document.createElement( 'a' );
		  nInfo = document.createElement( 'span' );
		  nInfoStart = document.createElement( 'span' );
		  nInfoSep = document.createElement( 'span' );
		  nInfoEnd = document.createElement( 'span' );

		  /* Rename pagination text */
		  jQuery(nFirst).text('«');
		  jQuery(nPrevious).text('‹');
		  jQuery(nNext).text('›');
		  jQuery(nLast).text('»');
		  jQuery(nInfoSep).text(' / ');

        nFirst.className = "paginate_button first";
        nPrevious.className = "paginate_button previous";
        nNext.className="paginate_button next";
        nLast.className = "paginate_button last";
		  nInfo.className = "paging-input displaying-num";
		  nInfoStart.className = "emi-current-page";
		  nInfoEnd.className = "emi-total-page";

        jQuery('.emi-pagination-links').append( nFirst );
        jQuery('.emi-pagination-links').append( nPrevious );
        jQuery('.emi-pagination-links').append( nInfo );
        jQuery('.emi-pagination-links').append( nNext );
        jQuery('.emi-pagination-links').append( nLast );

        jQuery('.paging-input').append( nInfoStart );
        jQuery('.paging-input').append( nInfoSep );
        jQuery('.paging-input').append( nInfoEnd );

        jQuery(nFirst).click( function () {
            oSettings.oApi._fnPageChange( oSettings, "first" );
            fnCallbackDraw( oSettings );
        } );

        jQuery(nPrevious).click( function() {
            oSettings.oApi._fnPageChange( oSettings, "previous" );
            fnCallbackDraw( oSettings );
        } );

        jQuery(nNext).click( function() {
            oSettings.oApi._fnPageChange( oSettings, "next" );
            fnCallbackDraw( oSettings );
        } );

        jQuery(nLast).click( function() {
            oSettings.oApi._fnPageChange( oSettings, "last" );
            fnCallbackDraw( oSettings );
        } );

        /* Disallow text selection */
        jQuery(nFirst).bind( 'selectstart', function () { return false; } );
        jQuery(nPrevious).bind( 'selectstart', function () { return false; } );
        jQuery(nNext).bind( 'selectstart', function () { return false; } );
        jQuery(nLast).bind( 'selectstart', function () { return false; } );
    },

    "fnUpdate": function ( oSettings, fnCallbackDraw )
    {
		  /* Update for pagination informations */
		  var oPaging = oSettings.oInstance.fnPagingInfo();
		  jQuery('#emi_number_elements').text(oPaging.iTotal);
		  jQuery('.emi-current-page').text(oPaging.iPage + 1);
		  jQuery('.emi-total-page').text(oPaging.iTotalPages);

		  update_pagination();

        if ( !oSettings.aanFeatures.p )
        {
            return;
        }

        /* Loop over each instance of the pager */
        var an = jQuery('.emi-pagination-links').children('a');
        for ( var i=0 ; i<an.length ; i++ )
        {
            if ( oSettings._iDisplayStart === 0 )
            {
                an[0].className = "disabled";
                an[1].className = "disabled";
            }
            else
            {
                an[0].className = "";
                an[1].className = "";
            }

            if ( oSettings.fnDisplayEnd() == oSettings.fnRecordsDisplay() )
            {
                an[2].className = "disabled";
                an[3].className = "disabled";
            }
            else
            {
                an[2].className = "";
                an[3].className = "";
            }
        }
    }
};

jQuery.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
{
  return {
    "iStart":         oSettings._iDisplayStart,
    "iEnd":           oSettings.fnDisplayEnd(),
    "iLength":        oSettings._iDisplayLength,
    "iTotal":         oSettings.fnRecordsTotal(),
    "iFilteredTotal": oSettings.fnRecordsDisplay(),
    "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
    "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
  };
};

oTable = jQuery('#preview_table').dataTable({
	"sPaginationType": "four_button",
	"sDom": '<"tablenav top"f>p'
});

jQuery('#preview_table_filter').append('<button id="delete-checked" class="button-secondary">'+loc.del_checked+'</button>');

jQuery('#delete-checked').click(function(){
	jQuery('.emi-checkbox').each(function(){
		if (jQuery(this).prop('checked')) {
			oTable.fnDeleteRow(
				oTable.fnGetPosition(
					document.getElementById('event_'+jQuery(this).attr('parent'))
				)
			);
			jQuery('#emi-edit-'+jQuery(this).attr('parent')).remove();
		}
	});
	jQuery('.emi-checkbox-th').prop('checked', false);
	return false;
});

function cancel(this_parent) {
	jQuery("#emi-event_name-"+this_parent).val(jQuery("#event_"+this_parent+" .emi-title").text());
	jQuery("#emi-location_name-"+this_parent).val(jQuery("#emi-location_name-"+this_parent).attr("default"));
	jQuery("#emi-location_address-"+this_parent).val(jQuery("#emi-location_address-"+this_parent).attr("default"));
	jQuery("#emi-location_town-"+this_parent).val(jQuery("#emi-location_town-"+this_parent).attr("default"));
	jQuery("#emi-location_state-"+this_parent).val(jQuery("#emi-location_state-"+this_parent).attr("default"));
	jQuery("#emi-location_postcode-"+this_parent).val(jQuery("#emi-location_postcode-"+this_parent).attr("default"));
	jQuery("#emi-location_region-"+this_parent).val(jQuery("#emi-location_region-"+this_parent).attr("default"));
	jQuery("#emi-location_country-"+this_parent).val(jQuery("#emi-location_country-"+this_parent).attr("default"));
	jQuery("#emi-location_latitude-"+this_parent).val(jQuery("#emi-location_latitude-"+this_parent).attr("default"));
	jQuery("#emi-location_longitude-"+this_parent).val(jQuery("#emi-location_longitude-"+this_parent).attr("default"));
	jQuery("#emi-post_content-"+this_parent).val(jQuery("#emi-post_content-"+this_parent).attr("default"));

	jQuery("#emi-event_start_date-"+this_parent).val(jQuery("#emi-event_start_date-"+this_parent).attr("default"));
	jQuery("#emi-event_end_date-"+this_parent).val(jQuery("#emi-event_end_date-"+this_parent).attr("default"));
	jQuery("#emi-event_start_time-"+this_parent).val(jQuery("#emi-event_start_time-"+this_parent).attr("default"));
	jQuery("#emi-event_end_time-"+this_parent).val(jQuery("#emi-event_end_time-"+this_parent).attr("default"));

	jQuery("#emi-edit-"+this_parent).append(jQuery('#event_temp > td').children());
	jQuery('#event_temp').remove();
	jQuery("#event_"+this_parent).css("display", "");
	return false;
}

jQuery(".emi-cancel").click(function() {
	cancel(jQuery(this).attr('parent'));
});

jQuery(".emi-save").click(function() {
	if (jQuery("#emi-event_name-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_name);
		return false;
	}
	if (jQuery("#emi-location_name-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_location);
		return false;
	}
	if (jQuery("#emi-location_address-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_address);
		return false;
	}
	if (jQuery("#emi-location_town-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_town);
		return false;
	}
	//if (jQuery("#emi-location_country-"+jQuery(this).attr("parent")).val() == '') {
		//alert("Country cannot be empty");
		//return false;
	//}
	if (jQuery("#emi-event_start_time-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_start_time);
		return false;
	}
	if (jQuery("#emi-event_end_time-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_end_time);
		return false;
	}
	if (jQuery("#emi-event_start_date-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_end_date);
		return false;
	}
	if (jQuery("#emi-event_end_date-"+jQuery(this).attr("parent")).val() == '') {
		alert(loc.err_name);
		return false;
	}
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

	jQuery("#emi-edit-"+jQuery(this).attr("parent")).append(jQuery('#event_temp > td').children());
	jQuery('#event_temp').remove();
	jQuery("#event_"+jQuery(this).attr("parent")).css("display", "");
	return false;
});

// Calendar \\

function customRange(a) {
	var date = jQuery('#emi-event_start_date-'+a.getAttribute('parent')).datepicker('getDate');
	return {
		minDate: date
	}
}

function setDate(a) {
	var date = jQuery.datepicker.parseDate('dd/mm/yy', a);
	jQuery('#emi-event_end_date-'+jQuery(this).attr('parent')).datepicker('setDate', date);
}

jQuery(".emi-event_start_date").datepicker({
	dateFormat: 'dd/mm/yy',
	onSelect: setDate
});
jQuery(".emi-event_end_date").datepicker({
	dateFormat: 'dd/mm/yy',
	beforeShow: customRange
});

};
