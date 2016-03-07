<div>
	<table class="normal-table">
		<tr>
			<th>User</th>
			<th>Team</th>
			<th>Answer</th>
			<th>Datetime</th>
		</tr>
		<?php foreach($logs as $log): ?>
		<tr class="<?php if($log->is_corrected == 1) echo "solved"; ?>">
			<td><?= $log->user->username; ?></td>
			<td><?= $log->team->name; ?></td>
			<td><?= $log->body; ?></td>
			<td><?= date("m/d/Y H:i:s", $log->created_at); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>