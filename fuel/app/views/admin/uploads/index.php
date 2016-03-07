<form method="post" action="" class="normal-form" enctype="multipart/form-data">
	<?= Form::csrf(); ?>
	<fieldset>
		<?php if($error): ?>
			<p class="error">Upload failed.</p>
		<?php endif; ?>
		<label for="upload_file">upload_file<br>(zip or image):</label>
		<input type="file" required="" name="upload_file" id="upload_file" value="">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>
<div>
	<table class="normal-table">
		<tr>
			<th>File name</th>
			<th></th>
		</tr>
		<?php foreach($files as $file): ?>
			<?php if(!preg_match("/^\./", $file)): ?>
		<tr>
			<td><a href="/files/<?= $file; ?>" target="_blank">/files/<?= $file; ?></a></td>
			<td><form method="post" action="">
					<input type="hidden" name="file" value="<?= $file; ?>">
					<button class="normal-button" onclick="deleteFile()">Delete</button>
			</form></td>
		</tr>
			<?php endif; ?>
		<?php endforeach; ?>
	</table>
</div>
<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteFile(){
		if(confirm('Do you want to delete it?')){
			return true;
		}

		return false;
	}
</script>