<h1>Upload</h1>
<form id="upload_form" method="post" enctype="multipart/form-data" action="<?php echo $this->createFormAction($this->action_importviewer); ?>">
*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input id="parse_button" class="button-primary" type="submit" value="<?php _e('Import', 'emi'); ?>" />
<br />
<input type="checkbox" name="geocoding" value="true" /><?php _e("Enable geocoding to retrieve location informations. (May take a while)", "emi"); ?>
</form>
