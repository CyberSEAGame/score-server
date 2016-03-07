<a class="create_button" href="/admin/questionnairetitles/edit">Create New Questionnaire Title</a>
<div>
	<table class="normal-table">
		<tr>
			<th>Sort</th>
			<th>ID</th>
			<th>Title</th>
			<th></th>
			<th></th>
		</tr>
		<?php foreach($titles as $title): ?>
		<tr id="title_<?= $title->id; ?>">
			<td><form action="" method="post">
					<Input type="hidden" name="id" value="<?= $title->id; ?>">
					<?= Form::csrf(); ?>
					<select name="sort" onchange="submit()">
						<?php for($i = 0; $i <= 20; $i++): ?>
							<option value="<?= $i; ?>" <?php if($i == $title->sort) echo "selected"; ?>><?= $i; ?></option>
						<?php endfor; ?>
					</select>
			</form></td>
			<td><?= $title->id; ?></td>
			<td><?= $title->title; ?></td>
			<td><a class="normal-button" href="/admin/questionnairetitles/edit/<?= $title->id; ?>">Edit</a></td>
			<td><button class="normal-button" onclick="deleteTitle(<?= $title->id; ?>)">Delete</button></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?= $pager; ?>
</div>

<?= Asset::js("jquery.min.js"); ?>
<?= Security::js_fetch_token(); ?>
<script>
	function deleteTitle(id){
		if(confirm('Do you want to delete it?')){
			$.ajax({
				url: '/admin/api/deletequestionnairetitle.json',
				type: 'POST',
				data: {
					"id": id,
					"<?= Config::get('security.csrf_token_key'); ?>": fuel_csrf_token()
				},

				complete: function(){

				},
				success: function(res) {
					$("#title_" + id).hide();
				}
			})
		}
	}
</script>