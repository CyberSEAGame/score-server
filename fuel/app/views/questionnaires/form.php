<div class="questionnaire">
	<?php if(Input::post("submit", null) != null): ?>
	<p class="center">Your answer has been updated.</p>
	<?php endif; ?>
	<form action="" method="post" class="questionnaire-form">
		<?= Form::csrf(); ?>
<?php $title = null; ?>
<?php foreach($questionnaires as $questionnaire): ?>
<?php if($title != $questionnaire["title"])
	{
		echo "<h3>{$questionnaire["title"]}</h3>";
		$title = $questionnaire["title"];
	}?>
	<fieldset>
		<label for="<?= $questionnaire["id"]; ?>"><?= $questionnaire["body"]; ?>:</label>
		<?php
		switch($questionnaire["type_id"])
		{
			// text
			case 0:
				echo<<<EOM
<textarea name="{$questionnaire["id"]}">{$questionnaire["answer"]}</textarea>
EOM;
				break;

			// y/n
			case 1:

				$c = 0;
				foreach(Config::get("yn") as $yn)
				{
					echo "<input type=\"radio\" name=\"{$questionnaire["id"]}\" value=\"{$c}\"";
					if($c == $questionnaire["answer"]) echo " checked";
					echo ">{$yn}";

					$c++;
				}

				break;
			// grade
			case 2:

				$c = 0;

				echo "<select name=\"{$questionnaire["id"]}\">";

				foreach(Config::get("grades") as $grade)
				{
					echo "<option value=\"{$c}\"";
					if($c == $questionnaire["answer"]) echo " selected";
					echo ">{$grade}</option>";

					$c++;
				}
				echo "</select>";

				break;

			// 5
			case 3:

				$c = 5;
				foreach(Config::get("5") as $five)
				{
					echo "<input type=\"radio\" name=\"{$questionnaire["id"]}\" value=\"{$c}\"";
					if($c == $questionnaire["answer"]) echo " checked";
					echo ">{$five}";

					$c--;
				}

				break;

			// text short
			case 4:
				echo<<<EOM
<input type="text" name="{$questionnaire["id"]}" value="{$questionnaire["answer"]}">
EOM;
				break;

		}; ?>
	</fieldset>
<?php endforeach; ?>
		<input type="submit" class="normal-button center" name="submit" value="Submit">
	</form>
</div>