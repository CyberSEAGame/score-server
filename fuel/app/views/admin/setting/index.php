<?= Asset::css("jquery.datetimepicker.css"); ?>
<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="start_at">start_at:</label>
		<input type="text" required="" name="start_at" id="start_at" value="<?= $setting->getStartDatetime(); ?>">
	</fieldset>
	<fieldset>
		<label for="finish_at">finish_at:</label>
		<input type="text" required="" name="finish_at" id="finish_at" value="<?= $setting->getFinishDatetime(); ?>">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>
<?= Asset::js("jquery.min.js"); ?>
<?= Asset::js("jquery.datetimepicker.js"); ?>
<script>
	$(function(){
		$('#start_at').datetimepicker({
			format: 'm/d/Y H:i'
		});
		$('#finish_at').datetimepicker({
			format: 'm/d/Y H:i'
		});
	});
</script>