<a class="create_button" href="/admin/users/edit">Create New User</a>
<a class="create_button" href="/admin/loginlog">Login Log</a>
<div>
	<table class="normal-table">
		<tr>
			<th class="small">ID</th>
			<th class="small">Group</th>
			<th>Username</th>
			<th>Email</th>
			<th>Team</th>
			<th>Created at</th>
			<th>Last login</th>
			<th class="middle"></th>
			<th class="middle"></th>
		</tr>
		<?php foreach($users as $user): ?>
		<tr id="user_<?= $user->id; ?>">
			<td><?= $user->id; ?></td>
			<td><?= $user->getGroup(); ?></td>
			<td><?= $user->username; ?></td>
			<td><?= $user->email; ?></td>
			<td><?php if($user->team != null) echo $user->team->name; ?></td>
			<td><?= $user->getCreatedDatetime(); ?></td>
			<td><?= $user->getLastloginDatetime(); ?></td>
			<td><a class="normal-button" href="/admin/users/edit/<?= $user->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteUser(<?= $user->id; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteUser(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deleteuser.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#user_" + id).hide();
				}
			})
		}
	}
</script>