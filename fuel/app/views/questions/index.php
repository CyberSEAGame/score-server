<div>
	<table class="normal-table">
		<tr>
			<th class="small center"></th>
			<th>Category</th>
			<th>Title</th>
			<th class="small">Score</th>
			<th></th>
		</tr>
		<?php foreach($questions as $question): ?>
		<tr class="<?php if($question["answer_id"] != null) echo "solved"; ?>">
			<td class="center"><?php if($question["is_solved"] == 1) echo "*"; ?></td>
			<td><?= $question["category"]; ?></td>
			<td><?= $question["title"]; ?></td>
			<td><?= $question["point"]; ?></td>
			<td><a class="normal-button" href="/questions/detail/<?= $question["id"]; ?>">Detail</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>