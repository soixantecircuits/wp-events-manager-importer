<div class="emi_upload_wrap">
	<h1><?php _e("Upload","emi"); ?></h1>
	<form class="emi_form" method="post" enctype="multipart/form-data" action="<?php echo $this->createFormAction($this->action_importviewer); ?>">
		<div class="emi_droparea">
			<p>(.xlsx)</p>
			<input type="file" name="emi_file" /><br/>
			<p><?php _e("or","emi"); ?>
			<p><?php _e("Drop your file here","emi"); ?></p>
		</div>
		
		<input class="button emi_upload" type="submit" value="<?php _e('Upload and Preview', 'emi'); ?>" />
	</form>
</div>

