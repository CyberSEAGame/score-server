<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="name">Name:</label>
		<input type="text" required="" name="name" id="name" value="<?php if(isset($name)) echo $name; ?>">
	</fieldset>
	<fieldset>
		<label for="color">Color:</label>
		<input type="text" required="" name="color" id="color" maxlength="7" value="<?php if(isset($color)) echo $color; ?>">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>