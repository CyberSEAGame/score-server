<form method="post" action="" class="normal-form">
	<?= Form::csrf(); ?>
	<fieldset>
		<label for="category_id">Category:</label>
		<select name="category_id">
			<?php
			foreach($categories as $category): ?>
				<option value="<?= $category->id; ?>" <?php if(isset($category_id)){
					if($category_id == $category->id){
						echo "selected";
					}
				}?>><?= $category->title; ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="title">Title:</label>
		<input type="text" required="" name="title" id="title" value="<?php if(isset($title)) echo $title; ?>">
	</fieldset>
	<fieldset>
		<label for="first_point">First Score:</label>
		<input type="number" required="" name="first_point" id="first_point" value="<?php if(isset($first_point)) echo $first_point; ?>">
	</fieldset>
	<fieldset>
		<label for="point">Score:</label>
		<select name="point">
			<?php
			foreach(Config::get("points") as $p): ?>
				<option value="<?= $p; ?>" <?php if(isset($point)){
					if($point == $p){
							echo "selected";
					}
				}?>><?= $p; ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="body">Body:</label>
		<textarea required="" name="body" id="body" class="normal-textarea"><?php if(isset($body)) echo $body; ?></textarea>
	</fieldset>
	<fieldset>
		<label for="answer">Answer:</label>
		<input type="text" required="" name="answer" id="answer" value="<?php if(isset($answer)) echo $answer; ?>">
	</fieldset>
	<button type="submit" class="normal-button center">Submit</button>
</form>