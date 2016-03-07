<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="title">Title:</label>
		<input type="text" required="" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>