<div>
	<ul class="topic_list">
		<?php foreach($announcements as $announcement): ?>
			<li>
				<a href="/announcements/detail/<?= $announcement->id; ?>"><?= $announcement->title; ?> (<?= $announcement->getPublicDatetime(); ?>)</a>
			</li>
		<?php endforeach; ?>
	</ul>
	<?= $pager; ?>
</div>