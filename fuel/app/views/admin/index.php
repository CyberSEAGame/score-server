<div class="announcement">
	<?php
	$announcement = Model_Announcement::getNewest();
	if($announcement != null)
	{
		echo "<h3>{$announcement->title}</h3>";
		echo "<p>" . nl2br($announcement->body) . "</p>";
	}
	?>
</div>