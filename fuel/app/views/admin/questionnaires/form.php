<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="title_id">Title:</label>
		<select name="title_id">
			<?php
			foreach($titles as $title): ?>
				<option value="<?= $title->id; ?>" <?php if(isset($title_id)){
					if($title_id == $title->id){
						echo "selected";
					}
				}?>><?= $title->title; ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="type_id">Type:</label>
		<select name="type_id">
		<?php
		$c = 0;
		foreach(Config::get("questionnaire_types") as $type): ?>
			<option value="<?= $c; ?>" <?php if(isset($type_id)){
				if($type_id == $c){
					echo "selected";
				}
			}?>><?= $type; ?></option>
		<?php $c++; ?>
		<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="body">Body:</label>
		<input type="text" required="" name="body" id="body" value="<?php if(isset($body)) echo $body; ?>">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>