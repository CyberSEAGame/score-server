<div>
	<table class="normal-table">
		<tr>
			<th>User ID</th>
			<th>Group</th>
			<th>Username</th>
			<th>Email</th>
			<th>IP</th>
			<th>login datetime</th>
		</tr>
		<?php foreach($logins as $login): ?>
		<tr>
			<td><?= $login->user->id; ?></td>
			<td><?= $login->user->getGroup(); ?></td>
			<td><?= $login->user->username; ?></td>
			<td><?= $login->user->email; ?></td>
			<td><?= $login->ip; ?></td>
			<td><?= date("m/d/Y H:i:s", $login->created_at); ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>