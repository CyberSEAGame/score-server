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
	<fieldset>
	<label for="group_id">Group:</label>
		<select name="group_id" id="group_id">
			<option value="1" <?php if(isset($group_id) && $group_id == 1) echo " selected"; ?>>User</option>
			<option value="100" <?php if(isset($group_id) && $group_id == 100) echo " selected"; ?>>Admin</option>
		</select>
	</fieldset>
	<fieldset>
		<label for="team_id">Team:</label>
		<select name="team_id" id="team_id">
			<option value="0">---</option>
			<?php foreach($teams as $team): ?>
				<option value="<?= $team->id; ?>" <?php if(isset($team_id) && $team_id == $team->id) echo " selected"; ?>><?= $team->name; ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>