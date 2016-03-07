<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="is_public">is_public:</label>
		<input type="checkbox" name="is_public" id="is_public" value="1" <?php if(isset($is_public) && $is_public == 1) echo "checked"; ?>>
	</fieldset>
	<fieldset>
		<label for="body">Body:</label>
		<textarea class="normal-textarea" required="" name="body" id="body"><?php if(isset($body)) echo $body; ?></textarea>
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>