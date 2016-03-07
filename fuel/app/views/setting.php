<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<?php if(isset($errors["username"])): ?>
			<p class="error">This username is already in use.</p>
		<?php endif; ?>
		<label for="username">Username:</label>
		<input type="text" required="" name="username" id="username" value="<?php if(isset($username)) echo $username; ?>">
	</fieldset>
	<fieldset>
		<?php if(isset($errors["email"])): ?>
			<p class="error">This email is already in use.</p>
		<?php endif; ?>
		<label for="email">Email:</label>
		<input type="email" required="" name="email" id="email" value="<?php if(isset($email)) echo $email; ?>">
	</fieldset>
	<fieldset>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" value="">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>