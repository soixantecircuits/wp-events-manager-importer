<h1>Upload</h1>
<form method="post" enctype="multipart/form-data" action="<?php echo $this->createFormAction($this->action_importviewer); ?>">
*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="<?php _e('Parse', 'emi'); ?>" />
</form>
