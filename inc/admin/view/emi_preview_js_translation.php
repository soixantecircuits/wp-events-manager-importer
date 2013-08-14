<?php
$js_array = array (
	"del_checked" => __('Delete checked events', 'emi'),
	"err_name" => __('Title cannot be empty', 'emi'),
	"err_location" => __('Location name cannot be empty', 'emi'),
	"err_address" => __('Address cannot be empty', 'emi'),
	"err_town" => __('Town cannot be empty', 'emi'),
	"err_start_time" => __('Start hour cannot be empty', 'emi'),
	"err_end_time" => __('End hour cannot be empty', 'emi'),
	"err_start_date" => __('Start date cannot be empty', 'emi'),
	"err_end_date" => __('End date cannot be empty', 'emi'),
); ?>
<script type="text/javascript">
	var loc = <?php echo json_encode($js_array); ?>;
</script>