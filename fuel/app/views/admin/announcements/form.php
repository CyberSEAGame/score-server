<?= Asset::css("jquery.datetimepicker.css"); ?>
<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="is_public">is_public:</label>
		<input type="checkbox" name="is_public" id="is_public" value="1" <?php if(isset($is_public) && $is_public == 1) echo "checked"; ?>>
	</fieldset>
	<fieldset>
		<label for="public_at">public_at:</label>
		<input type="text" required="" name="public_at" id="public_at" value="<?php if(isset($public_at)) echo $public_at; ?>">
	</fieldset>
	<fieldset>
		<label for="title">Title:</label>
		<input type="text" required="" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>">
	</fieldset>
	<fieldset>
		<label for="body">Body:</label>
		<textarea class="normal-textarea" required="" name="body" id="body"><?php if(isset($body)) echo $body; ?></textarea>
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>
<?= Asset::js("jquery.min.js"); ?>
<?= Asset::js("jquery.datetimepicker.js"); ?>
<script>
	$(function(){
		$('#public_at').datetimepicker({
			format: 'm/d/Y H:i'
		});
	});
</script>