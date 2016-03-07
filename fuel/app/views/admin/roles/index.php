<a class="create_button" href="/patrash/roles/create">Create New Role</a>
<div>
	<table class="normal-table">
		<tr>
			<th>is_public</th>
			<th>ID</th>
			<th>Body</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($roles as $role): ?>
		<tr id="role_<?= $role->id; ?>">
			<td><input type="checkbox" onclick="changePublic(<?= $role->id; ?>)" <?php if($role->is_public == 1) echo "checked"; ?>></td>
			<td><?= $role->id; ?></td>
			<td><?= mb_strimwidth($role->body, 0, 100, "..."); ?></td>
			<td><a class="normal-button" href="/patrash/roles/update/<?= $role->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteRole(<?= $role->id; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function changePublic(id){
		$.ajax({
			url: '/patrash/api/changerole.json',
			type: 'POST',
			data: {
				"id": id,
				"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
			},

			complete: function(){

			},
			success: function(res) {
			}
		})
	}

	function deleteRole(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/patrash/api/deleterole.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#role_" + id).hide();
				}
			})
		}
	}
</script>