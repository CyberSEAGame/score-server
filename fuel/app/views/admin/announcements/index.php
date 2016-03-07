<a class="create_button" href="/admin/announcements/edit">Create New Announcement</a>
<div>
	<table class="normal-table">
		<tr>
			<th>is_public</th>
			<th>ID</th>
			<th>Title</th>
			<th>public_at</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($announcements as $announcement): ?>
		<tr id="announcement_<?= $announcement->id; ?>">
			<td><input type="checkbox" onclick="changePublic(<?= $announcement->id; ?>)" <?php if($announcement->is_public == 1) echo "checked"; ?>></td>
			<td><?= $announcement->id; ?></td>
			<td><?= $announcement->title; ?></td>
			<td><?= $announcement->getPublicDatetime(); ?></td>
			<td><a class="normal-button" href="/admin/announcements/edit/<?= $announcement->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteAnnouncement(<?= $announcement->id; ?>)">Delete</button></td>
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
			url: '/admin/api/changeannouncement.json',
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

	function deleteAnnouncement(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deleteannouncement.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#announcement_" + id).hide();
				}
			})
		}
	}
</script>